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
                Jangan sampai kelewatan grand launching Kabinet <span class="text-white font-bold">METAFORSA</span>.
                <br class="hidden md:block"> <span
                    class="text-transparent bg-clip-text bg-linear-to-r from-red-500 to-red-400 italic">We're upgrading
                    the
                    feature, and you're
                    invited.</span>
            </p>

            <div class="flex flex-wrap justify-center gap-4 md:gap-8 mb-16" x-data="countdown()">
                <div class="flex flex-col items-center">
                    <span class="text-4xl md:text-6xl font-black text-white" x-text="days">00</span>
                    <span class="text-[10px] text-gray-500 font-bold uppercase tracking-[0.3em] mt-2">Days</span>
                </div>
                <div class="text-4xl md:text-6xl font-black text-red-600">:</div>
                <div class="flex flex-col items-center">
                    <span class="text-4xl md:text-6xl font-black text-white" x-text="hours">00</span>
                    <span class="text-[10px] text-gray-500 font-bold uppercase tracking-[0.3em] mt-2">Hours</span>
                </div>
                <div class="text-4xl md:text-6xl font-black text-red-600">:</div>
                <div class="flex flex-col items-center">
                    <span class="text-4xl md:text-6xl font-black text-white" x-text="minutes">00</span>
                    <span class="text-[10px] text-gray-500 font-bold uppercase tracking-[0.3em] mt-2">Minutes</span>
                </div>
                <div class="text-4xl md:text-6xl font-black text-red-600">:</div>
                <div class="flex flex-col items-center">
                    <span class="text-4xl md:text-6xl font-black text-white" x-text="seconds">00</span>
                    <span class="text-[10px] text-gray-500 font-bold uppercase tracking-[0.3em] mt-2">Seconds</span>
                </div>
            </div>

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

    @push('script')
        <script>
            function countdown() {
                return {
                    days: '00',
                    hours: '00',
                    minutes: '00',
                    seconds: '00',
                    expiry: new Date('2026-03-01T00:00:00').getTime(),
                    init() {
                        setInterval(() => {
                            let now = new Date().getTime();
                            let distance = this.expiry - now;

                            this.days = this.formatNumber(Math.floor(distance / (1000 * 60 * 60 * 24)));
                            this.hours = this.formatNumber(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 *
                                60)));
                            this.minutes = this.formatNumber(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)));
                            this.seconds = this.formatNumber(Math.floor((distance % (1000 * 60)) / 1000));
                        }, 1000);
                    },
                    formatNumber(number) {
                        return number < 10 ? '0' + number : number;
                    }
                }
            }
        </script>
    @endpush
</x-guest-layout>
