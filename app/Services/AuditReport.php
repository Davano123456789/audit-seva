<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Audit;
use App\Models\Question;

/**
 * Menyusun data laporan hasil audit (Tabel Hasil Pencapaian Level / Maturity Level).
 *
 * Maturity Level = jumlah capability level proses TI / jumlah proses TI yang digunakan.
 */
class AuditReport
{
    public function __construct(private CapabilityAssessor $assessor)
    {
    }

    public function build(Audit $audit): array
    {
        $audit->loadMissing(['asesor', 'processes' => fn ($q) => $q->orderBy('process_code'), 'processes.process']);

        $rows = $audit->processes->map(function ($item) use ($audit) {
            $completed = $item->status === 'completed';
            $level = $completed ? $item->computed_capability_level : null;
            $history = $this->assessor->evaluate($audit, $item->process_code)['history'];

            return [
                'code' => $item->process_code,
                'name' => $item->process->name,
                'description' => $item->process->description,
                'target' => $item->target_level,
                'level' => $level,
                'level_name' => CapabilityAssessor::levelName($level),
                'gap' => $completed ? max(0, $item->target_level - $level) : null,
                'completed' => $completed,
                'history' => $history,
                'assessments' => $this->assessmentTables($audit, $item->process_code, $history),
            ];
        });

        $completed = $rows->where('completed', true);
        $sum = $completed->sum('level');
        $count = $completed->count();
        $index = $count ? CapabilityAssessor::roundMaturity($sum / $count) : null;
        $maturityLevel = CapabilityAssessor::maturityLevel($index);

        return [
            'audit' => $audit,
            'rows' => $rows,
            'is_final' => $count > 0 && $count === $rows->count(),
            'completed_count' => $count,
            'total_count' => $rows->count(),
            'sum' => $sum,
            'levels' => $completed->pluck('level')->all(),
            'index' => $index,
            'maturity_level' => $maturityLevel,
            'maturity_name' => CapabilityAssessor::levelName($maturityLevel),
        ];
    }

    /**
     * Rincian jawaban per aktivitas untuk setiap level yang sudah dinilai
     * (format Tabel Capability Assessment Level n pada proposal).
     *
     * @return array<int, array{summary: array, practices: \Illuminate\Support\Collection}>
     */
    private function assessmentTables(Audit $audit, string $processCode, array $history): array
    {
        $assessedLevels = collect($history)->reject(fn ($h) => $h['status'] === 'skipped')->keys();

        if ($assessedLevels->isEmpty()) {
            return [];
        }

        $questions = Question::with('practice')
            ->whereIn('level', $assessedLevels)
            ->whereHas('practice', fn ($q) => $q->where('process_code', $processCode))
            ->orderBy('practice_code')
            ->orderBy('id')
            ->get();

        $answers = Answer::where('project_id', $audit->id)
            ->whereIn('question_id', $questions->pluck('id'))
            ->get()
            ->keyBy('question_id');

        return $questions->groupBy('level')
            ->sortKeys()
            ->map(fn ($levelQuestions, $level) => [
                'summary' => $history[$level],
                // [kode praktik => [praktik, daftar [pertanyaan, jawaban]]]
                'practices' => $levelQuestions->groupBy('practice_code')->map(fn ($items) => [
                    'practice' => $items->first()->practice,
                    'items' => $items->map(fn ($question) => [
                        'question' => $question,
                        'answer' => $answers->get($question->id),
                    ]),
                ]),
            ])
            ->all();
    }
}
