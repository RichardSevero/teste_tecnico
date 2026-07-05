<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
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
    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');

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

    Route::resource('permissoes', PermissionController::class)
        ->parameters(['permissoes' => 'permission'])
        ->except(['show'])
        ->names('permissions');

    Route::get('/modulos/{permission:slug}', function (Permission $permission) {
        $user = Auth::user();

        abort_if($user->isAdmin(), 403);

        abort_unless(
            $user->hasPermission($permission->slug),
            403
        );

        return view('modules.show', [
            'pageTitle' => $permission->name,
            'pageDescription' => $permission->description ?: 'Modulo liberado pela permissao do usuario.',
        ]);
    })->name('modules.show');
});
