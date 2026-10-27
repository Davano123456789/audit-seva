@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
    <x-page-header title="Edit Pengguna" subtitle="Perbarui data akun {{ $pengguna->name }}." />

    <x-card>
        <form method="POST" action="{{ route('master.pengguna.update', $pengguna) }}">
            @csrf
            @method('PUT')
            @include('master.pengguna._form')
        </form>
    </x-card>
@endsection
