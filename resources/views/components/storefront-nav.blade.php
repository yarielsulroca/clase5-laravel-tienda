@php
    $ssoUser = session('sso.user');
    $estaAutenticado = is_array($ssoUser);
@endphp

<nav class="relative z-10 border-b border-white/10 bg-slate-950/70 backdrop-blur">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('inicio') }}"
               class="rounded-lg bg-indigo-500 px-3 py-1.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition duration-300 hover:-translate-y-0.5 hover:bg-indigo-400">
                Catálogo
            </a>

            @if ($estaAutenticado)
                <a href="{{ route('products.index') }}"
                   class="rounded-lg px-3 py-1.5 text-sm font-medium text-slate-200 transition duration-300 hover:bg-white/10 hover:text-white">
                    Panel
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="rounded-lg px-3 py-1.5 text-sm font-medium text-slate-200 transition duration-300 hover:bg-white/10 hover:text-white">
                    Iniciar sesión
                </a>
            @endif
        </div>

        @if ($estaAutenticado)
            <div class="flex items-center gap-3">
                <span class="hidden text-sm text-slate-300 sm:inline">{{ $ssoUser['name'] ?? $ssoUser['email'] ?? 'Sesión SSO' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="rounded-lg px-3 py-1.5 text-sm font-medium text-slate-300 transition duration-300 hover:bg-white/10 hover:text-white">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        @endif
    </div>
</nav>
