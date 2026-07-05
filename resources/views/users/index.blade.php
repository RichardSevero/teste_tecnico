@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-neutral-900">Gerencie seus usuários</h1>
        </div>

        <a
            href="{{ route('users.create') }}"
            class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700"
        >
            Novo usuário
        </a>
    </div>

    <form method="GET" action="{{ route('users.index') }}" class="mt-6 flex flex-col gap-3 md:flex-row">
        <input
            type="text"
            name="search"
            value="{{ $search }}"
            placeholder="Buscar por nome ou e-mail"
            class="w-full rounded-md border border-neutral-300 px-3 py-2 text-neutral-900 placeholder:text-neutral-500/70 focus:border-blue-500 focus:outline-none"
        >

        <div class="flex gap-3">
            <button
                type="submit"
                class="rounded-md bg-neutral-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-neutral-800"
            >
                Buscar
            </button>

            <a
                href="{{ route('users.index') }}"
                class="rounded-md border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 transition hover:bg-neutral-100"
            >
                Limpar
            </a>
        </div>
    </form>

    <div class="mt-6 overflow-x-auto rounded-lg border border-neutral-200">
        <table class="min-w-full divide-y divide-neutral-200 bg-white">
            <thead class="bg-neutral-50">
                <tr class="text-left text-sm font-medium text-neutral-700">
                    <th class="px-4 py-3">Nome</th>
                    <th class="px-4 py-3">E-mail</th>
                    <th class="px-4 py-3">Perfil</th>
                    <th class="px-4 py-3">Permissões</th>
                    <th class="px-4 py-3">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 text-sm text-neutral-700">
                @forelse ($users as $user)
                    <tr>
                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3 capitalize">{{ $user->role }}</td>
                        <td class="px-4 py-3">
                            @if ($user->permissions->isNotEmpty())
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($user->permissions as $permission)
                                        <span class="rounded-full bg-neutral-100 px-3 py-1 text-xs text-neutral-700">
                                            {{ $permission->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-neutral-400">Sem permissões</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3 text-sm">
                                <a href="{{ route('users.edit', $user) }}" class="text-blue-600 transition hover:text-blue-700">
                                    Editar
                                </a>

                                <form method="POST" action="{{ route('users.destroy', $user) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="text-red-600 transition hover:text-red-700"
                                        onclick="return confirm('Deseja excluir este usuario?')"
                                    >
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-neutral-500">
                            Nenhum usuário encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
@endsection
