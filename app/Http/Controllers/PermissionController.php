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
        abort_unless($request->user()?->isAdmin(), 403);

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
        abort_unless($request->user()?->isAdmin(), 403);

        $permission = new Permission();

        return view('permissions.create', compact('permission'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->isAdmin(), 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:permissions,slug'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Permission::create($data);

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permissao criada com sucesso.');
    }

    public function edit(Request $request, Permission $permission): View
    {
        abort_unless($request->user()?->isAdmin(), 403);

        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission): RedirectResponse
    {
        abort_unless($request->user()?->isAdmin(), 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('permissions', 'slug')->ignore($permission->id),
            ],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $permission->update($data);

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permissao atualizada com sucesso.');
    }

    public function destroy(Request $request, Permission $permission): RedirectResponse
    {
        abort_unless($request->user()?->isAdmin(), 403);

        $permission->users()->detach();
        $permission->delete();

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permissao excluida com sucesso.');
    }
}
