<x-guest-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Coming Soon - HMIF UKRI',
            'description' => 'Sesuatu yang besar sedang disiapkan oleh HMIF UKRI Kabinet METAFORSA.',
            'image' => asset('images/banner-kegiatan.png'),
            'url' => url()->current(),
        ])
    </x-slot>

    <div class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gray-950">
        <div class="pointer-events-none fixed inset-0 z-0 opacity-[0.03]"
            style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');">
        </div>

        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-150 h-150 bg-red-900/20 blur-[120px] rounded-full">
        </div>

        <div class="container relative z-10 px-4 mx-auto text-center mt-24">
            <div
                class="mb-6 inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-red-500/30 bg-red-900/20 backdrop-blur-md shadow-lg shadow-red-900/20">
                <span class="relative flex h-2 w-2">
                    <span
                        class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-red-500"></span>
                </span>
                <span class="text-[10px] font-black text-red-400 uppercase tracking-widest">System Under
                    Development</span>
            </div>

            <h1 class="text-5xl md:text-8xl font-black text-white tracking-tighter mb-4 uppercase italic">
                Coming <span class="text-transparent bg-clip-text bg-linear-to-r from-red-600 to-red-400">Soon</span>
            </h1>

            <p class="max-w-2xl mx-auto text-gray-400 text-sm md:text-lg mb-12 font-medium leading-relaxed">
                Sabar yaa, Lagi high-speed development nihh buat bikin fitur keren dan menarik pastinya di website HMIF
                UKRI. <br class="hidden md:block">
                <br class="hidden md:block"> <span
                    class="text-transparent bg-clip-text bg-linear-to-r from-red-500 to-red-400 italic">We're upgrading
                    the
                    feature, and you're
                    invited.</span>
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('home') }}"
                    class="group relative px-8 py-4 bg-red-600 text-white font-black text-[11px] uppercase tracking-[0.3em] rounded-2xl overflow-hidden transition-all hover:scale-105 shadow-2xl shadow-red-900/40">
                    <span class="relative z-10">Back to Home</span>
                    <div
                        class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                    </div>
                </a>
                <a href="https://instagram.com/hmif_ukri" target="_blank"
                    class="px-8 py-4 bg-white/5 border border-white/10 text-white font-black text-[11px] uppercase tracking-[0.3em] rounded-2xl transition-all hover:bg-white/10">
                    Follow Updates
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
