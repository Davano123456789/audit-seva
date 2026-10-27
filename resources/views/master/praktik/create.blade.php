@extends('layouts.app')

@section('title', 'Tambah Praktik')

@section('content')
    <x-page-header title="Tambah Praktik" subtitle="Tambahkan management practice ke sebuah proses TI." />

    <x-card>
        <form method="POST" action="{{ route('master.praktik.store') }}">
            @csrf
            @include('master.praktik._form')
        </form>
    </x-card>
@endsection
