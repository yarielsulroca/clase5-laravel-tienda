<x-layouts.storefront title="Iniciar sesión">
    <section class="mx-auto w-full max-w-md animate-fade-up">
        <div class="mb-8 flex flex-col gap-2">
            <p class="text-sm font-medium uppercase tracking-widest text-indigo-300">SSO-APP</p>
            <h1 class="text-3xl font-semibold text-white">Iniciar sesión</h1>
            <p class="text-sm text-slate-300">Usamos el microservicio de autenticación en {{ config('services.sso.url') }} solo para validar credenciales.</p>
        </div>

        <form method="POST" action="{{ route('login.store') }}"
              class="flex flex-col gap-5 rounded-2xl border border-white/10 bg-white/5 p-6 shadow-xl shadow-indigo-950/40 backdrop-blur">
            @csrf

            <div class="flex flex-col gap-2">
                <label for="email" class="text-sm font-medium text-slate-200">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                       class="rounded-xl border border-white/10 bg-slate-950/60 px-3 py-2 text-white outline-none ring-indigo-400 transition focus:ring-2">
                @error('email')
                    <p class="text-sm text-rose-300">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="password" class="text-sm font-medium text-slate-200">Contraseña</label>
                <input type="password" name="password" id="password" required
                       class="rounded-xl border border-white/10 bg-slate-950/60 px-3 py-2 text-white outline-none ring-indigo-400 transition focus:ring-2">
                @error('password')
                    <p class="text-sm text-rose-300">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="rounded-xl bg-indigo-500 px-4 py-2.5 font-semibold text-white shadow-lg shadow-indigo-500/30 transition duration-300 hover:-translate-y-0.5 hover:bg-indigo-400">
                Entrar al panel
            </button>
        </form>
    </section>
</x-layouts.storefront>
