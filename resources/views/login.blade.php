<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-neutral-100">
    <main class="flex min-h-screen items-center justify-center p-6">
        <section class="w-full max-w-sm rounded-xl border-1 border-neutral-300 bg-white p-6 shadow-lg">
            <h1 class="mb-6 text-center text-2xl font-semibold text-neutral-900">Entrar no sistema</h1>

            <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
                @csrf

            @if ($errors->any())
                <p class="rounded-md bg-red-50 px-3 py-2 text-sm text-red-600">
                     {{ $errors->first() }}
                </p>
            @endif

                <div>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        placeholder="E-mail"
                        class="w-full rounded-md border border-neutral-300 px-3 py-2 text-neutral-900 placeholder:text-neutral-500/70 focus:border-blue-500 focus:outline-none"
                    >
                </div>

                <div>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Senha"
                        class="w-full rounded-md border border-neutral-300 px-3 py-2 text-neutral-900 placeholder:text-neutral-500/70 focus:border-blue-500 focus:outline-none"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
                >
                    Entrar
                </button>
            </form>
        </section>
    </main>
</body>
</html>
