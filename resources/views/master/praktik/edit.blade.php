@extends('layouts.app')

@section('title', 'Edit Praktik')

@section('content')
    <x-page-header title="Edit Praktik {{ $praktik->code }}" subtitle="Perbarui data management practice." />

    <x-card>
        <form method="POST" action="{{ route('master.praktik.update', $praktik) }}">
            @csrf
            @method('PUT')
            @include('master.praktik._form')
        </form>
    </x-card>
@endsection
