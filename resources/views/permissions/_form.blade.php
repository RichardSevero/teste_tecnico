<div class="grid gap-5">
    <div>
        <label for="name" class="mb-2 block text-sm font-medium text-neutral-700">Nome</label>
        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $permission->name) }}"
            class="w-full rounded-md border border-neutral-300 px-3 py-2 text-neutral-900 focus:border-blue-500 focus:outline-none"
        >
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="slug" class="mb-2 block text-sm font-medium text-neutral-700">Identificador</label>
        <input
            id="slug"
            name="slug"
            type="text"
            value="{{ old('slug', $permission->slug) }}"
            class="w-full rounded-md border border-neutral-300 px-3 py-2 text-neutral-900 focus:border-blue-500 focus:outline-none"
        >
        <p class="mt-1 text-sm text-neutral-500">Usado internamente nas rotas.</p>
        @error('slug')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="mb-2 block text-sm font-medium text-neutral-700">Descrição</label>
        <textarea
            id="description"
            name="description"
            rows="4"
            class="w-full rounded-md border border-neutral-300 px-3 py-2 text-neutral-900 focus:border-blue-500 focus:outline-none"
        >{{ old('description', $permission->description) }}</textarea>
        @error('description')
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
            href="{{ route('permissions.index') }}"
            class="rounded-md border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 transition hover:bg-neutral-100"
        >
            Cancelar
        </a>
    </div>
</div>
