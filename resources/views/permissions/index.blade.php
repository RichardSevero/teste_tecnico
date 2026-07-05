@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-neutral-900">Permissões</h1>
        </div>

        <a
            href="{{ route('permissions.create') }}"
            class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700"
        >
            Nova permissão
        </a>
    </div>

    <form method="GET" action="{{ route('permissions.index') }}" class="mt-6 flex flex-col gap-3 md:flex-row">
        <input
            type="text"
            name="search"
            value="{{ $search }}"
            placeholder="Buscar por nome ou slug"
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
                href="{{ route('permissions.index') }}"
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
                    <th class="px-4 py-3">Slug</th>
                    <th class="px-4 py-3">Descrição</th>
                    <th class="px-4 py-3">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 text-sm text-neutral-700">
                @forelse ($permissions as $permission)
                    <tr>
                        <td class="px-4 py-3">{{ $permission->name }}</td>
                        <td class="px-4 py-3">{{ $permission->slug }}</td>
                        <td class="px-4 py-3">{{ $permission->description ?: 'Sem descrição' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3 text-sm">
                                <a href="{{ route('permissions.edit', $permission) }}" class="text-blue-600 transition hover:text-blue-700">
                                    Editar
                                </a>

                                <form method="POST" action="{{ route('permissions.destroy', $permission) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="text-red-600 transition hover:text-red-700"
                                        onclick="return confirm('Deseja excluir esta permissão?')"
                                    >
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-neutral-500">
                            Nenhuma permissão encontrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $permissions->links() }}
    </div>
@endsection
