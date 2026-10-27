@extends('layouts.app')

@section('title', 'Tambah Pertanyaan')

@section('content')
    <x-page-header title="Tambah Pertanyaan" subtitle="Tambahkan aktivitas yang akan dinilai pada capability level tertentu." />

    <x-card>
        <form method="POST" action="{{ route('master.pertanyaan.store') }}">
            @csrf
            @include('master.pertanyaan._form')
        </form>
    </x-card>
@endsection
