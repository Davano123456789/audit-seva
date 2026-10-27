@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <x-page-header title="Tambah Pengguna" subtitle="Buat akun baru untuk administrator atau asesor." />

    <x-card>
        <form method="POST" action="{{ route('master.pengguna.store') }}">
            @csrf
            @include('master.pengguna._form')
        </form>
    </x-card>
@endsection
