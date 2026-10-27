@extends('layouts.app')

@section('title', 'Edit Proyek Audit')

@section('content')
    <x-page-header title="Edit Proyek Audit" subtitle="{{ $audit->name }}" />

    <x-card>
        <form method="POST" action="{{ route('audit.update', $audit) }}">
            @csrf
            @method('PUT')
            @include('audit._form')
        </form>
    </x-card>
@endsection
