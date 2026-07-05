<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso negado</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-neutral-100 text-neutral-900">
    <main class="flex min-h-screen items-center justify-center p-6">
        <section class="w-full max-w-lg rounded-lg border border-neutral-200 bg-white p-8 text-center shadow-sm">
            <p class="text-sm font-medium text-red-600">Erro 403</p>
            <h1 class="mt-2 text-2xl font-semibold">Acesso negado</h1>
            <p class="mt-4 text-neutral-600">
                Você não possui permissão para acessar este módulo.
            </p>

            <a
                href="{{ url()->previous() }}"
                class="mt-6 inline-flex rounded-md bg-neutral-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-neutral-800"
            >
                Voltar
            </a>
        </section>
    </main>
</body>
</html>
