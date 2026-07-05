@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-neutral-900">Editar usuario</h1>
    <p class="mt-2 text-neutral-600">Atualize os dados do usuario selecionado.</p>

    <form method="POST" action="{{ route('users.update', $user) }}" class="mt-6">
        @csrf
        @method('PUT')
        @include('users._form')
    </form>
@endsection
