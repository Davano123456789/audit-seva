{{--
    Tabel Capability Assessment Level n untuk satu proses (format Tabel 3.2 / 3.3 proposal):
    Management Practice | Aktivitas | Exist (Y=1, N=0) | Bukti Hasil Kerja, diakhiri baris Total.
    Variabel: $row (satu baris dari AuditReport::build()['rows']), $th, $td
--}}
@foreach ($row['assessments'] as $level => $table)
    @php
        $summary = $table['summary'];
        $rating = config("cobit.ratings.{$summary['rating']}.name");
    @endphp

    <div class="mb-6">
        <p class="mb-2 text-center font-semibold">
            Capability Assessment Level {{ $level }} &ndash; {{ $row['code'] }} (<span class="italic">{{ $row['name'] }}</span>)
        </p>

        <table class="w-full border-collapse text-xs">
            <thead>
                <tr>
                    <th class="{{ $th }} w-1/5">Management Practice</th>
                    <th class="{{ $th }}">Aktivitas</th>
                    <th class="{{ $th }} w-20">Exist<br>(Y=1, N=0)</th>
                    <th class="{{ $th }} w-1/4">Bukti Hasil Kerja</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($table['practices'] as $practiceCode => $group)
                    @foreach ($group['items'] as $item)
                        <tr class="align-top">
                            @if ($loop->first)
                                <td class="{{ $td }}" rowspan="{{ $group['items']->count() }}">
                                    <span class="font-semibold">{{ $practiceCode }}</span>
                                    ({{ $group['practice']->description ?: $group['practice']->name }})
                                </td>
                            @endif
                            <td class="{{ $td }}">{{ $item['question']->question_text }}</td>
                            <td class="{{ $td }} text-center font-semibold">{{ $item['answer']?->answer ?? '-' }}</td>
                            <td class="{{ $td }}">{{ $item['answer']?->notes ?: '-' }}</td>
                        </tr>
                    @endforeach
                @endforeach
                <tr>
                    <td colspan="2" class="{{ $td }} text-center font-bold">Total</td>
                    <td class="{{ $td }} text-center font-bold">{{ $summary['yes'] }}</td>
                    <td class="{{ $td }} font-bold">{{ $rating }} ({{ $summary['rating'] }})</td>
                </tr>
            </tbody>
        </table>

        <p class="mt-2 text-xs text-gray-600">
            Persentase capaian = {{ $summary['yes'] }} &divide; {{ $summary['total'] }} &times; 100% =
            <strong>{{ number_format($summary['percent'], 2, ',', '.') }}%</strong>,
            termasuk kategori <strong>{{ $rating }} ({{ $summary['rating'] }})</strong>.
            {{ \App\Services\CapabilityAssessor::decisionText($level, $summary['rating']) }}.
        </p>
    </div>
@endforeach
