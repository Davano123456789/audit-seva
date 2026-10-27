@extends('layouts.app')

@section('title', 'Edit Proses TI')

@section('content')
    <x-page-header title="Edit Proses {{ $proses->code }}" subtitle="Perbarui data proses TI." />

    <x-card>
        <form method="POST" action="{{ route('master.proses.update', $proses) }}">
            @csrf
            @method('PUT')
            @include('master.proses._form')
        </form>
    </x-card>
@endsection
