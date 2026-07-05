@extends('layouts.app')

@section('content')
        <p class="text-3xl font-semibold text-neutral-900">Bem-vindo ao sistema, {{ auth()->user()->name }}!</p>

        @if (auth()->user()->isAdmin())
            <p class="mt-2 text-neutral-700">
                Seu resumo de colaboradores: {{ $collaboratorsCount }}
            </p>

            <p class="mt-2 text-neutral-700">
                Seu resumo de permissões: {{ $permissionsCount }}
            </p>
        @endif
@endsection
