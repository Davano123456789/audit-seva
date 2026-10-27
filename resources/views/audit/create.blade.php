@extends('layouts.app')

@section('title', 'Buat Proyek Audit')

@section('content')
    <x-page-header title="Buat Proyek Audit" subtitle="Tentukan asesor serta proses TI yang akan dinilai." />

    <x-card>
        <form method="POST" action="{{ route('audit.store') }}">
            @csrf
            @include('audit._form')
        </form>
    </x-card>
@endsection
