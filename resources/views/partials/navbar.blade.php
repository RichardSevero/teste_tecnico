@php
    $user = auth()->user();
    $permissions = $user->permissions()->orderBy('name')->get();
@endphp

<div class="border-b border-neutral-200 bg-white px-12 py-6">
    <div class="mx-auto flex max-w-7xl items-center justify-center">
        <img
            src="{{ asset('images/logo_santacasa.svg') }}"
            alt="Santa Casa"
            class="h-12 w-auto"
        >
        <details class="absolute right-15">
            <summary class="cursor-pointer list-none rounded-md border border-neutral-300 bg-[#174873] text-white px-6 py-2 transition hover:text-black">
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
</div>

<nav class="border-b border-neutral-200 bg-blue-600 px-12 py-6 text-sm text-white shadow-sm">
    <div class="mx-auto grid max-w-9xl grid-cols-[1fr_auto_1fr] items-center text-lg">
        <div></div>

        <div class="flex items-center justify-center gap-12">
            <a href="{{ route('home') }}" class="transition hover:text-black">Home</a>

            @if ($user->isAdmin())
                <a href="{{ route('users.index') }}" class="transition hover:text-black">Usuários</a>
                <a href="{{ route('permissions.index') }}" class="transition hover:text-black">Permissões</a>
            @else
                @foreach ($permissions as $permission)
                    <a href="{{ route('modules.show', $permission) }}" class="transition hover:text-black">{{ $permission->name }}</a>
                @endforeach
            @endif
        </div>
    </div>
</nav>
