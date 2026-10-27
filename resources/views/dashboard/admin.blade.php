@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <x-welcome-banner subtitle="Kelola data master dan proyek pengukuran capability level COBIT 2019 dari sini." />

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Proyek Audit" :value="$stats['audits']" icon="folder-kanban"
                     hint="{{ $stats['in_progress'] }} berjalan · {{ $stats['completed'] }} selesai" />
        <x-stat-card label="Total Domain" :value="$stats['domains']" icon="layers"
                     hint="{{ $stats['processes'] }} proses TI" />
        <x-stat-card label="Asesor" :value="$stats['asesors']" icon="users"
                     hint="Akun asesor aktif" />
        <x-stat-card label="Pertanyaan" :value="$stats['questions']" icon="clipboard-list"
                     hint="Aktivitas kuesioner level 2 - 5" />
    </div>
@endsection
