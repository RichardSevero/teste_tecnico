<?php

use App\Http\Controllers\UserController;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->middleware('guest')->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    return back()->withErrors([
        'login' => 'E-mail ou senha invalidos.',
    ])->onlyInput('email');
})->name('login.submit');

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('home', [
            'pageTitle' => 'home',
        ]);
    })->name('home');

    Route::post('/logout', function (Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');

    Route::resource('usuarios', UserController::class)
        ->parameters(['usuarios' => 'user'])
        ->except(['show'])
        ->names('users');

    Route::get('/permissoes', function () {
        abort_unless(Auth::user()->isAdmin(), 403);

        return view('permissoes', [
            'pageTitle' => 'Permissões',
            'pageDescription' => 'Area base para o CRUD de permissoes.',
        ]);
    })->name('permissions.index');

    Route::get('/modulos/{permission:slug}', function (Permission $permission) {
        $user = Auth::user();

        abort_unless(
            $user->isAdmin() || $user->hasPermission($permission->slug),
            403
        );

        return view('modules.show', [
            'pageTitle' => $permission->name,
            'pageDescription' => $permission->description ?: 'Modulo liberado pela permissao do usuario.',
        ]);
    })->name('modules.show');
});
