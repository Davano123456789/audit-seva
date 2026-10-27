@extends('layouts.app')

@section('title', 'Laporan Audit')

@section('content')
    @php
        $audit = $report['audit'];
        $back = auth()->user()->isAdmin() ? route('audit.show', $audit) : route('penilaian.show', $audit);
    @endphp

    <x-page-header title="Laporan Hasil Audit" :subtitle="$audit->name">
        <x-slot:actions>
            <x-button :href="$back" variant="secondary" icon="arrow-left">Kembali</x-button>
            <x-button :href="route('laporan.cetak', $audit)" icon="printer" target="_blank">Cetak / PDF</x-button>
        </x-slot:actions>
    </x-page-header>

    <x-card class="p-6 md:p-10">
        @include('laporan.partials._konten')
    </x-card>
@endsection
