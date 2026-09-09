@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator $productos */
@endphp

<x-layouts.storefront title="Catálogo de productos">
    <section class="animate-fade-up mb-10 flex flex-col gap-3">
        <p class="text-sm font-medium uppercase tracking-widest text-indigo-300">Tienda</p>
        <h1 class="text-4xl font-semibold tracking-tight text-white">Productos destacados</h1>
        <p class="max-w-2xl text-slate-300">Explorá el catálogo. Para administrar la tabla general de productos, iniciá sesión con SSO desde el menú superior izquierdo.</p>
    </section>

    @if (session('success'))
        <div class="mb-6 rounded-xl border border-emerald-400/30 bg-emerald-400/10 px-4 py-3 text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="catalog-grid grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($productos as $producto)
            @php
                $agotado = $producto->stock <= 0;
                $stockBajo = $producto->stock > 0 && $producto->stock <= 10;
            @endphp
            <article class="group overflow-hidden rounded-2xl border border-white/10 bg-white/5 shadow-lg shadow-indigo-950/40 backdrop-blur transition duration-300 hover:-translate-y-1.5 hover:border-indigo-400/40 hover:shadow-xl hover:shadow-indigo-500/20">
                <div class="relative h-36 overflow-hidden bg-gradient-to-br from-indigo-500 via-violet-500 to-fuchsia-500">
                    <div class="absolute inset-0 bg-slate-950/10 transition duration-500 group-hover:bg-slate-950/0"></div>
                    <span class="absolute bottom-4 left-4 text-4xl font-bold text-white/90">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr((string) $producto->nombre, 0, 1)) }}</span>
                    <span @class([
                        'absolute top-4 right-4 rounded-full px-3 py-1 text-xs font-semibold',
                        'bg-red-500/90 text-white' => $agotado,
                        'bg-amber-400/90 text-slate-900' => $stockBajo,
                        'bg-emerald-400/90 text-slate-900' => ! $agotado && ! $stockBajo,
                    ])>
                        {{ $agotado ? 'Agotado' : ($stockBajo ? 'Stock bajo' : 'Disponible') }}
                    </span>
                </div>
                <div class="flex flex-col gap-3 p-5">
                    <h2 class="text-lg font-semibold text-white">{{ $producto->nombre }}</h2>
                    <p class="min-h-12 text-sm text-slate-300">{{ \Illuminate\Support\Str::limit((string) $producto->descripcion, 90) }}</p>
                    <div class="flex items-end justify-between gap-3 pt-2">
                        <p class="text-2xl font-semibold text-indigo-200">${{ $producto->precio }}</p>
                        <p class="text-sm text-slate-400">{{ $producto->stock }} u.</p>
                    </div>
                </div>
            </article>
        @empty
            <p class="col-span-full rounded-2xl border border-white/10 bg-white/5 px-6 py-12 text-center text-slate-300">
                Todavía no hay productos para mostrar.
            </p>
        @endforelse
    </div>

    <div class="mt-10 text-slate-200">
        {{ $productos->links() }}
    </div>
</x-layouts.storefront>
