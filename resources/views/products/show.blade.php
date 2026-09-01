@php
    /** @var \App\Models\Producto $producto */
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $producto->nombre }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-xl mx-auto py-10 px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">{{ $producto->nombre }}</h1>
            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">Volver</a>
        </div>

        <div class="bg-white shadow rounded-lg p-6 space-y-3">
            <div>
                <h2 class="text-sm font-medium text-gray-500">Descripción</h2>
                <p class="text-gray-800">{{ $producto->descripcion }}</p>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Precio</h2>
                    <p class="text-gray-800">${{ $producto->precio }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Stock</h2>
                    <p class="text-gray-800">{{ $producto->stock }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Peso</h2>
                    <p class="text-gray-800">{{ $producto->peso }}</p>
                </div>
            </div>
            <div class="flex justify-end pt-4">
                <a href="{{ route('products.edit', $producto) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-4 py-2 rounded-lg">
                    Editar
                </a>
            </div>
        </div>
    </div>
</body>
</html>
