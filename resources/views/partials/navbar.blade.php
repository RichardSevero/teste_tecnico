@php
    $user = auth()->user();
    $permissions = $user->permissions()->orderBy('name')->get();
@endphp

<nav class="border-b border-neutral-200 bg-white px-12 py-8 text-sm text-neutral-900 shadow-sm">
    <div class="mx-auto grid max-w-7xl grid-cols-[1fr_auto_1fr] items-center text-lg">
        <div></div>

        <div class="flex items-center justify-center gap-6">
            <a href="{{ route('home') }}" class="transition hover:text-blue-600">Home</a>

            @if ($user->isAdmin())
                <a href="{{ route('users.index') }}" class="transition hover:text-blue-600">Usuários</a>
                <a href="{{ route('permissions.index') }}" class="transition hover:text-blue-600">Permissões</a>
            @else
                @foreach ($permissions as $permission)
                    <a href="{{ route('modules.show', $permission) }}" class="transition hover:text-blue-600">{{ $permission->name }}</a>
                @endforeach
            @endif
        </div>

        <details class="relative justify-self-end">
            <summary class="cursor-pointer list-none rounded-md border border-neutral-300 px-4 py-2 transition hover:border-blue-600 hover:text-blue-600">
                {{ $user->name }}
            </summary>

            <div class="absolute right-0 mt-3 rounded-lg border border-neutral-200 bg-white p-3 shadow-md">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="transition hover:text-blue-600">Sair</button>
                </form>
            </div>
        </details>
    </div>
</nav>
