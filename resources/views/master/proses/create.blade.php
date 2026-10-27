@extends('layouts.app')

@section('title', 'Tambah Proses TI')

@section('content')
    <x-page-header title="Tambah Proses TI" subtitle="Tambahkan proses TI COBIT yang akan dinilai." />

    <x-card>
        <form method="POST" action="{{ route('master.proses.store') }}">
            @csrf
            @include('master.proses._form')
        </form>
    </x-card>
@endsection
