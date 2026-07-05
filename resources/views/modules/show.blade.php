@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold">{{ $pageTitle ?? 'Modulo' }}</h1>

    <p class="mt-3 text-neutral-600">
        {{ $pageDescription ?? 'Area liberada pela permissao do usuario.' }}
    </p>
@endsection
