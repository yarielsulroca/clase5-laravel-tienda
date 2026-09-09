@props([
    'title' => 'Catálogo',
])

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 antialiased">
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="absolute -top-24 -left-16 h-72 w-72 rounded-full bg-indigo-500/30 blur-3xl"></div>
        <div class="absolute top-40 -right-16 h-80 w-80 rounded-full bg-violet-500/20 blur-3xl"></div>
    </div>

    <x-storefront-nav />

    <main class="relative mx-auto max-w-6xl px-4 py-10">
        {{ $slot }}
    </main>
</body>
</html>
