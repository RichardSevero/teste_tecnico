<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PermissionController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Permission::class);

        $search = $request->input('search');

        $permissions = Permission::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('permissions.index', compact('permissions', 'search'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Permission::class);

        $permission = new Permission;

        return view('permissions.create', compact('permission'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Permission::class);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:permissions,slug'],
            'description' => ['nullable', 'string', 'max:150'],
        ]);

        Permission::create($data);

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permissão criada com sucesso.');
    }

    public function edit(Request $request, Permission $permission): View
    {
        $this->authorize('update', $permission);

        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission): RedirectResponse
    {
        $this->authorize('update', $permission);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('permissions', 'slug')->ignore($permission->id),
            ],
            'description' => ['nullable', 'string', 'max:150'],
        ]);

        $permission->update($data);

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permissão atualizada com sucesso.');
    }

    public function destroy(Request $request, Permission $permission): RedirectResponse
    {
        $this->authorize('delete', $permission);

        if ($permission->users()->exists()) {
            return redirect()
                ->route('permissions.index')
                ->with('error', 'Não é possível excluir uma permissão vinculada a usuários.');
        }

        $permission->delete();

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permissão excluída com sucesso.');
    }
}
