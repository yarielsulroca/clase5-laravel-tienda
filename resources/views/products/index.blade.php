@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator $productos */
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Productos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <x-storefront-nav />
    <div class="max-w-5xl mx-auto py-10 px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Listado de productos</h1>
            <a href="{{ route('products.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg">
                Nuevo producto
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($productos as $producto)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $producto->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">${{ $producto->precio }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $producto->stock }}</td>
                            <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                <a href="{{ route('products.show', $producto) }}" class="text-blue-600 hover:text-blue-800">Ver</a>
                                <a href="{{ route('products.edit', $producto) }}" class="text-yellow-600 hover:text-yellow-800">Editar</a>
                                <form action="{{ route('products.destroy', $producto) }}" method="POST" class="inline"
                                      onsubmit="return confirm('¿Eliminar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay productos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $productos->links() }}
        </div>
    </div>
</body>
</html>
