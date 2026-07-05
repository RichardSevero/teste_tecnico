@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-neutral-900">Novo usuario</h1>
    <p class="mt-2 text-neutral-600">Preencha os dados para cadastrar um novo usuario.</p>

    <form method="POST" action="{{ route('users.store') }}" class="mt-6">
        @csrf
        @include('users._form')
    </form>
@endsection
