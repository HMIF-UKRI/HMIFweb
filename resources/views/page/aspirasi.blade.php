<x-guest-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Aspirasi Mahasiswa - HMIF UKRI',
            'description' => 'Sampaikan aspirasi, saran, dan kritik Anda untuk kemajuan Informatika UKRI.',
            'image' => asset('images/banner-aspirasi.png'),
            'url' => url()->current(),
        ])
    </x-slot>

    <div class="relative min-h-screen w-full flex items-center justify-center pt-24 pb-32 overflow-hidden bg-[#050505]">

        <div class="absolute inset-0 z-0">
            <div
                class="absolute top-[-10%] left-[-10%] w-125 h-125 bg-red-600/20 rounded-full blur-[120px] animate-pulse">
            </div>
            <div class="absolute bottom-[10%] right-[-5%] w-100 h-100 bg-red-900/10 rounded-full blur-[100px]">
            </div>

            <div class="absolute inset-0 opacity-[0.05]"
                style="background-image: linear-linear(#fff 1px, transparent 1px), linear-linear(90deg, #fff 1px, transparent 1px); background-size: 50px 50px;">
            </div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-5xl mx-auto">

                <div class="grid lg:grid-cols-2 gap-12 items-center">

                    <div class="text-left space-y-8">
                        <div class="space-y-4">
                            <div
                                class="inline-flex items-center gap-3 px-3 py-1 rounded-full border border-red-500/30 bg-red-500/10 backdrop-blur-md">
                                <span class="relative flex h-2 w-2">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                </span>
                                <span class="text-[10px] font-black text-red-500 uppercase tracking-[0.4em]">Live
                                    Channels</span>
                            </div>

                            <h1 class="text-5xl md:text-7xl font-black text-white leading-tight">
                                KOTAK <br>
                                <span
                                    class="text-transparent bg-clip-text bg-linear-to-r from-red-500 via-red-400 to-white">
                                    ASPIRASI.
                                </span>
                            </h1>

                            <p class="text-gray-400 text-lg leading-relaxed max-w-md font-light">
                                Platform aspirasi digital HMIF. Sampaikan gagasan, kritik, atau inovasi Anda untuk
                                membangun ekosistem Informatika yang lebih transformatif dan inovatif.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4">
                            <div class="p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                                <h4 class="text-red-500 font-bold text-xs uppercase mb-1">Anonimitas</h4>
                                <p class="text-gray-500 text-xs">Identitas Anda terjaga sepenuhnya dalam sistem kami.
                                </p>
                            </div>
                            <div class="p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                                <h4 class="text-red-500 font-bold text-xs uppercase mb-1">Direct Access</h4>
                                <p class="text-gray-500 text-xs">Terkoneksi langsung ke Badan Pengurus Humas Internal.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="relative group">
                        <div
                            class="absolute -inset-1 bg-linear-to-tr from-red-600 to-violet-600 rounded-[2.5rem] blur opacity-20 group-hover:opacity-40 transition duration-1000">
                        </div>

                        <div
                            class="relative bg-[#0d0d0d]/80 border border-white/10 backdrop-blur-2xl rounded-[2.5rem] p-8 md:p-12 shadow-3xl overflow-hidden">

                            <div
                                class="absolute top-8 left-8 w-8 h-8 border-t-2 border-l-2 border-red-500 rounded-tl-lg">
                            </div>
                            <div
                                class="absolute top-8 right-8 w-8 h-8 border-t-2 border-r-2 border-red-500 rounded-tr-lg">
                            </div>
                            <div
                                class="absolute bottom-8 left-8 w-8 h-8 border-b-2 border-l-2 border-red-500 rounded-bl-lg">
                            </div>
                            <div
                                class="absolute bottom-8 right-8 w-8 h-8 border-b-2 border-r-2 border-red-500 rounded-br-lg">
                            </div>

                            <div class="flex flex-col items-center">
                                <div
                                    class="relative bg-white p-4 rounded-3xl shadow-[0_0_50px_rgba(220,38,38,0.15)] transform transition-all duration-700 group-hover:scale-[1.02]">
                                    <div
                                        class="absolute inset-x-0 top-0 h-1 bg-linear-to-r from-transparent via-red-500 to-transparent animate-scan z-20">
                                    </div>
                                    <div class="relative z-10">
                                        {!! QrCode::size(220)->backgroundColor(255, 255, 255)->color(0, 0, 0)->margin(1)->generate(env('QR_KOTAK_ASPIRASI_URL')) !!}
                                    </div>
                                </div>

                                <div class="mt-10 w-full space-y-4">
                                    <a href="{{ env('QR_KOTAK_ASPIRASI_URL') }}" target="_blank"
                                        class="group relative flex items-center justify-center w-full bg-white text-black hover:bg-red-600 hover:text-white py-4 rounded-xl font-bold text-xs uppercase tracking-[0.2em] transition-all duration-300 overflow-hidden">
                                        <span class="relative z-10">Kirim Aspirasi Sekarang</span>
                                        <div
                                            class="absolute inset-0 h-full w-0 bg-red-600 transition-all duration-300 group-hover:w-full">
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="mt-24 border-t border-white/5 pt-8 flex flex-wrap justify-between items-center gap-6 opacity-40">
                    <span class="text-[10px] font-bold text-white uppercase tracking-widest">Teknik Informatika
                        UKRI</span>
                    <span class="text-[10px] font-bold text-white uppercase tracking-widest">Kabinet Metaforsa
                        2025/2026</span>
                    <span class="text-[10px] font-bold text-white uppercase tracking-widest">Humas Internal</span>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            @keyframes scan {
                0% {
                    top: 0%;
                    opacity: 0;
                }

                50% {
                    opacity: 1;
                }

                100% {
                    top: 100%;
                    opacity: 0;
                }
            }

            .animate-scan {
                position: absolute;
                animation: scan 3s linear infinite;
            }
        </style>
    @endpush
</x-guest-layout>
