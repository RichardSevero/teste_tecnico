<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('home', [
            'collaboratorsCount' => $user->isAdmin()
                ? User::where('role', 'colaborador')->count()
                : null,
            'permissionsCount' => $user->isAdmin()
                ? Permission::count()
                : null,
            'userPermissions' => $user->permissions()->orderBy('name')->get(),
        ]);
    }
}
