<?php

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

Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');