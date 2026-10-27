@extends('layouts.app')

@section('title', 'Edit Pertanyaan')

@section('content')
    <x-page-header title="Edit Pertanyaan" subtitle="Perbarui teks, praktik, atau level pertanyaan." />

    <x-card>
        <form method="POST" action="{{ route('master.pertanyaan.update', $pertanyaan) }}">
            @csrf
            @method('PUT')
            @include('master.pertanyaan._form')
        </form>
    </x-card>
@endsection
