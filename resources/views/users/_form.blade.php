@php
    $selectedPermissions = old('permissions', $user->permissions->pluck('id')->all());
    $selectedRole = old('role', $user->role ?: 'colaborador');
@endphp

<div class="grid gap-5">
    <div>
        <label for="name" class="mb-2 block text-sm font-medium text-neutral-700">Nome</label>
        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $user->name) }}"
            class="w-full rounded-md border border-neutral-300 px-3 py-2 text-neutral-900 focus:border-blue-500 focus:outline-none"
        >
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="mb-2 block text-sm font-medium text-neutral-700">E-mail</label>
        <input
            id="email"
            name="email"
            type="email"
            value="{{ old('email', $user->email) }}"
            class="w-full rounded-md border border-neutral-300 px-3 py-2 text-neutral-900 focus:border-blue-500 focus:outline-none"
        >
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="mb-2 block text-sm font-medium text-neutral-700">
            Senha @if ($user->exists) <span class="text-neutral-400">(opcional)</span> @endif
        </label>
        <input
            id="password"
            name="password"
            type="password"
            class="w-full rounded-md border border-neutral-300 px-3 py-2 text-neutral-900 focus:border-blue-500 focus:outline-none"
        >
        @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="role" class="mb-2 block text-sm font-medium text-neutral-700">Perfil</label>
        <select
            id="role"
            name="role"
            data-role-select
            class="w-full rounded-md border border-neutral-300 px-3 py-2 text-neutral-900 focus:border-blue-500 focus:outline-none"
        >
            <option value="admin" @selected($selectedRole === 'admin')>Admin</option>
            <option value="colaborador" @selected($selectedRole === 'colaborador')>Colaborador</option>
        </select>
        @error('role')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div data-permissions-wrapper>
        <p class="mb-2 block text-sm font-medium text-neutral-700">Permissoes</p>

        <div class="grid gap-2 rounded-md border border-neutral-200 p-4" data-permissions-container>
            @forelse ($permissions as $permission)
                <label class="flex items-center gap-2 text-sm text-neutral-700">
                    <input
                        type="checkbox"
                        name="permissions[]"
                        value="{{ $permission->id }}"
                        @checked(in_array($permission->id, $selectedPermissions))
                        data-permission-checkbox
                    >
                    <span>{{ $permission->name }}</span>
                </label>
            @empty
                <p class="text-sm text-neutral-400">Nenhuma permissao cadastrada.</p>
            @endforelse
        </div>

        <p
            class="mt-2 text-sm text-neutral-500 @if ($selectedRole !== 'admin') hidden @endif"
            data-admin-permissions-note
        >
            Permissões só podem ser selecionadas para usuários com perfil colaborador.
        </p>
        @error('permissions')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        @error('permissions.*')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex gap-3">
        <button
            type="submit"
            class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700"
        >
            Salvar
        </button>

        <a
            href="{{ route('users.index') }}"
            class="rounded-md border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 transition hover:bg-neutral-100"
        >
            Cancelar
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const roleSelect = document.querySelector('[data-role-select]');
        const permissionCheckboxes = document.querySelectorAll('[data-permission-checkbox]');
        const permissionsWrapper = document.querySelector('[data-permissions-wrapper]');
        const adminNote = document.querySelector('[data-admin-permissions-note]');

        if (!roleSelect || !permissionsWrapper) {
            return;
        }

        const syncPermissionsState = () => {
            const isAdmin = roleSelect.value === 'admin';

            permissionCheckboxes.forEach((checkbox) => {
                checkbox.disabled = isAdmin;

                if (isAdmin) {
                    checkbox.checked = false;
                }
            });

            permissionsWrapper.classList.toggle('opacity-60', isAdmin);
            adminNote?.classList.toggle('hidden', !isAdmin);
        };

        roleSelect.addEventListener('change', syncPermissionsState);
        syncPermissionsState();
    });
</script>
