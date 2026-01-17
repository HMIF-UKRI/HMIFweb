<x-auth-layout>
    <div
        class="relative min-h-screen w-full overflow-hidden bg-gray-950 flex items-center justify-center px-6 selection:bg-red-500 selection:text-white">

        <div class="pointer-events-none fixed inset-0 z-0 opacity-[0.03]"
            style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>

        <div class="pointer-events-none absolute -top-24 -left-24 h-125 w-125 rounded-full bg-red-900/20 blur-[120px]">
        </div>
        <div
            class="pointer-events-none absolute -bottom-24 -right-24 h-125 w-125 rounded-full bg-red-600/10 blur-[120px]">
        </div>

        <div class="absolute inset-0 z-0 opacity-20 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&q=80&w=2070"
                class="w-full h-full object-cover mix-blend-overlay">
        </div>

        <div class="relative z-10 w-full max-w-md">
            <div class="mb-10 text-center">
                <h1 class="text-3xl font-black tracking-tighter text-white md:text-4xl">
                    HMIF <span class="text-red-600 uppercase">Login</span>
                </h1>
                <p class="mt-2 text-sm text-gray-500 font-medium">Akses Portal Internal Pengurus HMIF</p>
            </div>

            <div
                class="overflow-hidden rounded-3xl border border-white/10 bg-gray-900/40 p-8 backdrop-blur-xl shadow-2xl">

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label for="email"
                            class="text-xs font-bold uppercase tracking-widest text-gray-400 ml-1">Email
                            Organization</label>
                        <div class="relative">
                            <i
                                class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></i>
                            <input id="email" type="email" name="email" :value="old('email')" required
                                autofocus
                                class="w-full rounded-2xl border-white/5 bg-gray-950/50 py-3.5 pl-11 pr-4 text-sm text-white placeholder-gray-600 transition-all focus:border-red-600 focus:ring-red-600/20"
                                placeholder="nama@hmif.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center justify-between ml-1">
                            <label for="password"
                                class="text-xs font-bold uppercase tracking-widest text-gray-400">Password</label>
                            @if (Route::has('password.request'))
                                <a class="text-[10px] uppercase font-bold text-red-500 hover:text-red-400 transition-colors"
                                    href="{{ route('password.request') }}">
                                    Forgot?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <i
                                class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></i>
                            <input id="password" type="password" name="password" required
                                class="w-full rounded-2xl border-white/5 bg-gray-950/50 py-3.5 pl-11 pr-4 text-sm text-white placeholder-gray-600 transition-all focus:border-red-600 focus:ring-red-600/20"
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div class="flex items-center">
                        <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="rounded border-white/10 bg-gray-950 text-red-600 shadow-sm focus:ring-red-600/20 transition-all">
                            <span
                                class="ms-2 text-xs font-medium text-gray-500 group-hover:text-gray-300 transition-colors">Tetap
                                masuk di perangkat ini</span>
                        </label>
                    </div>

                    <button type="submit"
                        class="relative w-full overflow-hidden rounded-2xl bg-red-600 py-4 text-sm font-black uppercase tracking-widest text-white transition-all hover:bg-red-700 hover:shadow-[0_0_20px_rgba(220,38,38,0.4)] active:scale-[0.98]">
                        Sign In
                    </button>
                </form>
            </div>

            <p class="mt-8 text-center text-[10px] uppercase tracking-[0.2em] text-gray-600">
                &copy; {{ date('Y') }} HMIF UKRI &bull; Research & Tech Dept
            </p>
        </div>
    </div>
</x-auth-layout>
