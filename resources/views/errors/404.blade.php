<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página não encontrada</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-neutral-100 text-neutral-900">
    <main class="flex min-h-screen items-center justify-center p-6">
        <section class="w-full max-w-lg rounded-lg border border-neutral-200 bg-white p-8 text-center shadow-sm">
            <p class="text-sm font-medium text-red-600">Erro 404</p>
            <h1 class="mt-2 text-2xl font-semibold">Página não encontrada</h1>
            <p class="mt-4 text-neutral-600">
                A página que você tentou acessar não existe ou foi removida.
            </p>

            <a
                href="{{ route('home') }}"
                class="mt-6 inline-flex rounded-md bg-neutral-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-neutral-800"
            >
                Ir para a página inicial
            </a>
        </section>
    </main>
</body>
</html>
