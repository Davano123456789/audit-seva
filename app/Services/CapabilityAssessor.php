<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Audit;
use App\Models\AuditProcess;
use App\Models\Question;

/**
 * Logika penilaian capability level sesuai proposal:
 *
 * 1. Penilaian dimulai dari Level 2, setiap aktivitas dijawab Ya (Y) / Tidak (N).
 * 2. Persentase = jumlah jawaban Ya / jumlah pertanyaan x 100%.
 * 3. Persentase dikonversi ke rating N / P / L / F (config/cobit.php).
 * 4. F  -> level lulus, penilaian lanjut ke level berikutnya.
 *    L  -> penilaian berhenti, capability = level tersebut.
 *    P/N-> penilaian berhenti, capability = level sebelumnya.
 * 5. Level yang tidak memiliki pertanyaan dilewati.
 */
class CapabilityAssessor
{
    public const IN_PROGRESS = 'in_progress';
    public const COMPLETED = 'completed';
    public const EMPTY = 'empty'; // proses belum memiliki pertanyaan sama sekali

    /**
     * Konversi persentase ke kode rating, contoh: 90 -> F, 60 -> L.
     */
    public static function rating(float $percent): string
    {
        foreach (config('cobit.ratings') as $code => $rating) {
            if ($percent >= $rating['min']) {
                return $code;
            }
        }

        return 'N';
    }

    public static function levelName(?int $level): string
    {
        return $level === null ? '-' : config("cobit.levels.{$level}.name", '-');
    }

    /**
     * Bulatkan maturity index sesuai jumlah desimal di config, contoh: 2.8333 -> 2.8.
     */
    public static function roundMaturity(float $index): float
    {
        return round($index, config('cobit.maturity_decimals'));
    }

    /**
     * Format tampilan maturity index, contoh: 2.8333 -> "2,8".
     */
    public static function formatMaturity(?float $index): string
    {
        return $index === null ? '-' : number_format(self::roundMaturity($index), config('cobit.maturity_decimals'), ',', '.');
    }

    /**
     * Pembulatan maturity index ke maturity level (Tabel 2.4), contoh: 2.8 -> 3.
     */
    public static function maturityLevel(?float $index): ?int
    {
        if ($index === null) {
            return null;
        }

        $index = self::roundMaturity($index);

        foreach (config('cobit.maturity_scale') as $range) {
            if ($index <= $range['max']) {
                return $range['level'];
            }
        }

        return config('cobit.max_level');
    }

    /**
     * Keterangan keputusan sebuah level berdasarkan rating-nya.
     */
    public static function decisionText(int $level, string $rating): string
    {
        return match ($rating) {
            'F' => 'Lulus, lanjut ke level berikutnya',
            'L' => "Berhenti, capability Level {$level}",
            default => 'Berhenti, capability Level ' . ($level - 1),
        };
    }

    /**
     * Hitung kondisi penilaian satu proses dalam sebuah audit.
     *
     * @return array{
     *     status: string,
     *     active_level: ?int,
     *     capability_level: ?int,
     *     has_next_level: bool,
     *     history: array<int, array>
     * }
     */
    public function evaluate(Audit $audit, string $processCode): array
    {
        $questionsByLevel = Question::whereHas('practice', fn ($q) => $q->where('process_code', $processCode))
            ->get(['id', 'level'])
            ->groupBy('level');

        $answers = Answer::where('project_id', $audit->id)
            ->whereIn('question_id', $questionsByLevel->flatten()->pluck('id'))
            ->pluck('answer', 'question_id');

        $history = [];

        for ($level = config('cobit.start_level'); $level <= config('cobit.max_level'); $level++) {
            $ids = $questionsByLevel->get($level, collect())->pluck('id');

            if ($ids->isEmpty()) {
                $history[$level] = ['status' => 'skipped'];
                continue;
            }

            $total = $ids->count();
            $levelAnswers = $answers->only($ids->all());

            // Level ini belum dijawab lengkap -> menjadi level aktif
            if ($levelAnswers->count() < $total) {
                return $this->result(self::IN_PROGRESS, $history, $questionsByLevel, activeLevel: $level);
            }

            $yes = $levelAnswers->filter(fn ($a) => $a === Answer::YES)->count();
            $percent = round($yes / $total * 100, 2);
            $rating = self::rating($percent);

            $history[$level] = [
                'status' => $rating === 'F' ? 'passed' : 'stopped',
                'total' => $total,
                'yes' => $yes,
                'no' => $total - $yes,
                'percent' => $percent,
                'rating' => $rating,
            ];

            if ($rating !== 'F') {
                $capability = $rating === 'L' ? $level : $level - 1;

                return $this->result(self::COMPLETED, $history, $questionsByLevel, capabilityLevel: $capability);
            }
        }

        // Semua level yang memiliki pertanyaan lulus (F) -> capability = level tertinggi yang lulus
        $passed = collect($history)->filter(fn ($h) => $h['status'] === 'passed')->keys();

        if ($passed->isEmpty()) {
            return $this->result(self::EMPTY, $history, $questionsByLevel);
        }

        return $this->result(self::COMPLETED, $history, $questionsByLevel, capabilityLevel: $passed->max());
    }

    /**
     * Evaluasi lalu simpan hasilnya ke proses audit dan perbarui ringkasan proyek.
     */
    public function sync(AuditProcess $item): array
    {
        $audit = $item->audit;
        $result = $this->evaluate($audit, $item->process_code);

        $hasAnswers = Answer::where('project_id', $audit->id)
            ->whereHas('question.practice', fn ($q) => $q->where('process_code', $item->process_code))
            ->exists();

        $item->update([
            'status' => match (true) {
                $result['status'] === self::COMPLETED => 'completed',
                $hasAnswers => 'in_progress',
                default => 'not_started',
            },
            'computed_capability_level' => $result['status'] === self::COMPLETED ? $result['capability_level'] : null,
        ]);

        $this->refreshAudit($audit);

        return $result;
    }

    /**
     * Perbarui status proyek dan maturity index (rata-rata capability proses yang sudah selesai).
     */
    public function refreshAudit(Audit $audit): void
    {
        $processes = $audit->processes()->get(['status', 'computed_capability_level']);
        $completed = $processes->where('status', 'completed');

        $audit->update([
            'maturity_index' => $completed->isNotEmpty() ? self::roundMaturity($completed->avg('computed_capability_level')) : null,
            'status' => match (true) {
                $processes->isNotEmpty() && $completed->count() === $processes->count() => 'completed',
                $processes->contains(fn ($p) => $p->status !== 'not_started') => 'in_progress',
                default => 'draft',
            },
        ]);
    }

    private function result(string $status, array $history, $questionsByLevel, ?int $activeLevel = null, ?int $capabilityLevel = null): array
    {
        return [
            'status' => $status,
            'active_level' => $activeLevel,
            'capability_level' => $capabilityLevel,
            // Apakah masih ada level berpertanyaan setelah level aktif (untuk prediksi "lanjut" atau "selesai")
            'has_next_level' => $activeLevel !== null
                && $questionsByLevel->keys()->contains(fn ($level) => $level > $activeLevel),
            'history' => $history,
        ];
    }
}
