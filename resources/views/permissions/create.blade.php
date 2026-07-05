@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-neutral-900">Nova permissão</h1>
    <p class="mt-2 text-neutral-600">Preencha os dados para cadastrar uma nova permissão.</p>

    <form method="POST" action="{{ route('permissions.store') }}" class="mt-6">
        @csrf
        @include('permissions._form')
    </form>
@endsection
