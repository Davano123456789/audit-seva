@extends('layouts.app')

@section('title', 'Tambah Domain')

@section('content')
    <x-page-header title="Tambah Domain" subtitle="Tambahkan domain COBIT baru." />

    <x-card>
        <form method="POST" action="{{ route('master.domain.store') }}">
            @csrf
            @include('master.domain._form')
        </form>
    </x-card>
@endsection
