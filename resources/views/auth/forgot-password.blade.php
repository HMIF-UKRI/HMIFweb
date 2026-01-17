<x-auth-layout>
    <div class="relative min-h-screen w-full overflow-hidden flex items-center justify-center px-6">

        <div class="relative z-10 w-full max-w-md" x-data="{ loading: false }">
            <div class="mb-10 text-center">
                <div
                    class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-red-600/10 mb-6 border border-red-600/20">
                    <i class="fa-solid fa-key text-2xl text-red-600"></i>
                </div>
                <h1 class="text-3xl font-black tracking-tighter text-white">Reset <span class="text-red-600">Akses</span>
                </h1>
                <p class="mt-4 text-sm text-gray-400 leading-relaxed">
                    Lupa password? Masukkan email organisasi Anda dan kami akan mengirimkan instruksi pemulihan.
                </p>
            </div>

            <div class="rounded-3xl border border-white/10 bg-gray-900/40 p-8 backdrop-blur-xl shadow-2xl">
                <form method="POST" action="{{ route('password.email') }}" @submit="loading = true">
                    @csrf
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-widest text-gray-500 ml-1">Email
                                Organization</label>
                            <div class="relative">
                                <i
                                    class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></i>
                                <input type="email" name="email" required
                                    class="w-full rounded-2xl border-white/5 bg-gray-950/50 py-3.5 pl-11 pr-4 text-sm text-white focus:border-red-600 focus:ring-red-600/20"
                                    placeholder="nama@hmif.com">
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full rounded-2xl bg-red-600 py-4 text-sm font-black uppercase tracking-widest text-white transition-all hover:bg-red-700 active:scale-[0.98] flex items-center justify-center gap-2">
                            <template x-if="!loading"><span>Kirim Link Reset</span></template>
                            <template x-if="loading"><i class="fa-solid fa-circle-notch animate-spin"></i></template>
                        </button>

                        <div class="text-center">
                            <a href="{{ route('login') }}"
                                class="text-xs font-bold text-gray-500 hover:text-white transition-colors">
                                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Login
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-auth-layout>
