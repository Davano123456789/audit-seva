@extends('layouts.print')

@section('title', 'Laporan ' . $report['audit']->name)

@section('content')
    @include('laporan.partials._konten')

    {{-- Tanda tangan asesor --}}
    <div class="avoid-break mt-12 flex justify-end text-sm">
        <div class="w-64 text-center">
            <p>{{ now()->translatedFormat('d F Y') }}</p>
            <p>Asesor,</p>
            <div class="h-20"></div>
            <p class="font-semibold underline">{{ $report['audit']->asesor->name }}</p>
        </div>
    </div>
@endsection
