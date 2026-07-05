@extends('layouts.app')

@section('content')
    <p class="text-3xl font-semibold text-neutral-900">Bem-vindo ao sistema, {{ auth()->user()->name }}!</p>

    @if (auth()->user()->isAdmin())
        <p class="mt-2 text-neutral-700">
            Seu resumo de colaboradores: {{ $collaboratorsCount }}
        </p>

        <p class="mt-2 text-neutral-700">
            Seu resumo de permissoes: {{ $permissionsCount }}
        </p>
    @else
        <div class="mt-6">
            <h2 class="text-lg font-semibold text-neutral-900">Seus acessos:</h2>

            @if ($userPermissions->isEmpty())
                <p class="mt-2 text-sm text-neutral-600">Você não possui acessos vinculados no momento.</p>
            @else
                <ul class="mt-3 space-y-2 text-sm text-neutral-700">
                    @foreach ($userPermissions as $permission)
                        <li class="bg-neutral-50 px-3 py-2">
                            {{ $permission->name }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif
@endsection
