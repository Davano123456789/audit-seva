{{--
    Isi laporan hasil audit, dipakai oleh halaman laporan dan halaman cetak.
    Variabel: $report (App\Services\AuditReport::build)
--}}
@php
    $audit = $report['audit'];
    $fmt = fn ($n, $d = 2) => $n === null ? '-' : number_format($n, $d, ',', '.');
    $maturity = \App\Services\CapabilityAssessor::formatMaturity($report['index']); // contoh: "2,8"
    $th = 'border border-gray-300 bg-gray-100 px-3 py-2 text-center text-xs font-semibold';
    $td = 'border border-gray-300 px-3 py-2';
@endphp

<div class="space-y-8 text-sm">
    {{-- Judul --}}
    <div class="border-b-2 border-brand-700 pb-4 text-center">
        <p class="text-xs font-semibold uppercase tracking-widest text-brand-700">{{ config('app.name') }}</p>
        <h1 class="mt-1 text-xl font-bold">Laporan Hasil Penilaian Capability &amp; Maturity Level</h1>
        <p class="text-gray-600">Berdasarkan Kerangka Kerja COBIT 2019</p>
    </div>

    {{-- Identitas proyek --}}
    <table class="w-full">
        <tbody>
            @foreach ([
                'Nama Proyek' => $audit->name,
                'Objek Audit' => $audit->description ?: '-',
                'Asesor' => $audit->asesor->name,
                'Status' => $audit->status_label . ' (' . $report['completed_count'] . ' dari ' . $report['total_count'] . ' proses selesai dinilai)',
                'Tanggal Laporan' => now()->translatedFormat('d F Y'),
            ] as $label => $value)
                <tr class="align-top">
                    <td class="w-40 py-1 text-gray-500">{{ $label }}</td>
                    <td class="w-4 py-1">:</td>
                    <td class="py-1 font-medium">{{ $value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @unless ($report['is_final'])
        <div class="avoid-break rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-amber-800">
            <strong>Laporan sementara.</strong> Masih ada {{ $report['total_count'] - $report['completed_count'] }} proses yang belum selesai dinilai,
            sehingga maturity level di bawah hanya dihitung dari proses yang sudah selesai.
        </div>
    @endunless

    {{-- Tabel hasil pencapaian level --}}
    <section class="avoid-break">
        <h2 class="mb-1 text-center font-bold">Tabel Hasil Pencapaian Level (Maturity Level)</h2>
        <table class="mt-3 w-full border-collapse">
            <thead>
                <tr>
                    <th class="{{ $th }} w-12">No</th>
                    <th class="{{ $th }}">Proses TI</th>
                    <th class="{{ $th }}">Detail Proses TI</th>
                    <th class="{{ $th }} w-16">Level</th>
                    <th class="{{ $th }}">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($report['rows'] as $row)
                    <tr>
                        <td class="{{ $td }} text-center">{{ $loop->iteration }}.</td>
                        <td class="{{ $td }} text-center font-medium">{{ $row['code'] }}</td>
                        <td class="{{ $td }} italic">{{ $row['name'] }}</td>
                        <td class="{{ $td }} text-center font-semibold">{{ $row['level'] ?? '-' }}</td>
                        <td class="{{ $td }} italic">{{ $row['completed'] ? $row['level_name'] : 'Belum selesai dinilai' }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="{{ $td }} text-center font-bold italic">Maturity Level</td>
                    <td colspan="2" class="{{ $td }} text-center font-bold">{{ $maturity }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="{{ $td }} text-center font-bold">(Pembulatan)</td>
                    <td colspan="2" class="{{ $td }} text-center font-bold">
                        @if ($report['maturity_level'] !== null)
                            Level {{ $report['maturity_level'] }} (<span class="italic">{{ $report['maturity_name'] }}</span>)
                        @else
                            -
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </section>

    {{-- Perhitungan --}}
    @if ($report['index'] !== null)
        <section class="avoid-break">
            <h2 class="mb-2 font-bold">Perhitungan Maturity Level</h2>
            <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-4">
                <p class="text-center">
                    <span class="italic">Maturity Level</span> =
                    <span class="inline-flex flex-col items-center align-middle text-xs">
                        <span class="border-b border-gray-700 px-1">Jumlah Level Proses TI</span>
                        <span class="px-1">Jumlah Proses TI yang digunakan</span>
                    </span>
                    = <span class="inline-flex flex-col items-center align-middle">
                        <span class="border-b border-gray-700 px-1">{{ implode(' + ', $report['levels']) }}</span>
                        <span class="px-1">{{ $report['completed_count'] }}</span>
                    </span>
                    = <span class="inline-flex flex-col items-center align-middle">
                        <span class="border-b border-gray-700 px-1">{{ $report['sum'] }}</span>
                        <span class="px-1">{{ $report['completed_count'] }}</span>
                    </span>
                    = <strong>{{ $maturity }}</strong>
                </p>
                <p class="mt-3 text-center text-gray-600">
                    Berdasarkan tabel indeks maturity, nilai {{ $maturity }} berada pada
                    <strong>Level {{ $report['maturity_level'] }} ({{ $report['maturity_name'] }})</strong>.
                </p>
            </div>
        </section>
    @endif

    {{-- Analisis gap --}}
    <section class="avoid-break">
        <h2 class="mb-1 text-center font-bold">Tabel Analisis Kesenjangan (Gap)</h2>
        <table class="mt-3 w-full border-collapse">
            <thead>
                <tr>
                    <th class="{{ $th }} w-12">No</th>
                    <th class="{{ $th }}">Proses TI</th>
                    <th class="{{ $th }} w-20">Target</th>
                    <th class="{{ $th }} w-20">Capability</th>
                    <th class="{{ $th }} w-16">Gap</th>
                    <th class="{{ $th }}">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($report['rows'] as $row)
                    <tr>
                        <td class="{{ $td }} text-center">{{ $loop->iteration }}.</td>
                        <td class="{{ $td }}"><span class="font-medium">{{ $row['code'] }}</span> &middot; <span class="italic">{{ $row['name'] }}</span></td>
                        <td class="{{ $td }} text-center">{{ $row['target'] }}</td>
                        <td class="{{ $td }} text-center">{{ $row['level'] ?? '-' }}</td>
                        <td @class([$td, 'text-center font-semibold', 'text-red-600' => $row['gap'] > 0])>{{ $row['gap'] ?? '-' }}</td>
                        <td class="{{ $td }}">
                            @if (! $row['completed'])
                                Belum selesai dinilai
                            @elseif ($row['gap'] > 0)
                                Belum mencapai target
                            @else
                                Target tercapai
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    {{-- Rincian per proses --}}
    <section>
        <h2 class="mb-3 font-bold">Rincian Penilaian Capability Level per Proses</h2>
        <div class="space-y-5">
            @foreach ($report['rows'] as $row)
                @php
                    $assessed = collect($row['history'])->reject(fn ($h) => $h['status'] === 'skipped');
                @endphp
                <div class="avoid-break">
                    <p class="mb-2 font-semibold">
                        {{ $loop->iteration }}. {{ $row['code'] }} &middot; <span class="italic">{{ $row['name'] }}</span>
                        <span class="font-normal text-gray-500">({{ $row['description'] }})</span>
                    </p>

                    @if ($assessed->isEmpty())
                        <p class="text-gray-500">Belum ada level yang selesai dinilai.</p>
                    @else
                        <table class="w-full border-collapse">
                            <thead>
                                <tr>
                                    <th class="{{ $th }}">Level</th>
                                    <th class="{{ $th }}">Pertanyaan</th>
                                    <th class="{{ $th }}">Ya</th>
                                    <th class="{{ $th }}">Tidak</th>
                                    <th class="{{ $th }}">Capaian</th>
                                    <th class="{{ $th }}">Rating</th>
                                    <th class="{{ $th }}">Keputusan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assessed as $level => $h)
                                    <tr>
                                        <td class="{{ $td }} text-center">{{ $level }}</td>
                                        <td class="{{ $td }} text-center">{{ $h['total'] }}</td>
                                        <td class="{{ $td }} text-center">{{ $h['yes'] }}</td>
                                        <td class="{{ $td }} text-center">{{ $h['no'] }}</td>
                                        <td class="{{ $td }} text-center">{{ $fmt($h['percent']) }}%</td>
                                        <td class="{{ $td }} text-center">{{ $h['rating'] }} ({{ config("cobit.ratings.{$h['rating']}.name") }})</td>
                                        <td class="{{ $td }}">{{ \App\Services\CapabilityAssessor::decisionText($level, $h['rating']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <p class="mt-1 text-xs text-gray-600">
                            Capability level:
                            <strong>{{ $row['completed'] ? 'Level ' . $row['level'] . ' (' . $row['level_name'] . ')' : 'belum selesai dinilai' }}</strong>
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    </section>



    {{-- Lampiran: rincian jawaban per aktivitas (format Tabel Capability Assessment Level n) --}}
    @if (collect($report['rows'])->contains(fn ($row) => ! empty($row['assessments'])))
        <section class="break-before-page">
            <h2 class="mb-1 font-bold">Lampiran: Capability Assessment per Level</h2>
            <p class="mb-4 text-xs text-gray-600">Rincian penilaian setiap aktivitas berdasarkan hasil wawancara dan observasi.</p>

            @foreach ($report['rows'] as $row)
                @include('laporan.partials._capability-assessment')
            @endforeach
        </section>
    @endif
</div>
