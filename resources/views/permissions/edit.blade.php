@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-neutral-900">Editar permissão</h1>
    <p class="mt-2 text-neutral-600">Atualize os dados da permissão selecionada.</p>

    <form method="POST" action="{{ route('permissions.update', $permission) }}" class="mt-6">
        @csrf
        @method('PUT')
        @include('permissions._form')
    </form>
@endsection
