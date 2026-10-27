@extends('layouts.app')

@section('title', 'Edit Domain')

@section('content')
    <x-page-header title="Edit Domain {{ $domain->id }}" subtitle="Perbarui data domain COBIT." />

    <x-card>
        <form method="POST" action="{{ route('master.domain.update', $domain) }}">
            @csrf
            @method('PUT')
            @include('master.domain._form')
        </form>
    </x-card>
@endsection
