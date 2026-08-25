<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Presensi - {{ $event->title }} | HMIF UKRI</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: #ffffff !important;
                color: #000000 !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .standee-card {
                box-shadow: none !important;
                border: 2px solid #000000 !important;
                background: #ffffff !important;
                color: #000000 !important;
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 auto !important;
                page-break-inside: avoid;
            }

            .standee-card * {
                color: #000000 !important;
                text-shadow: none !important;
            }

            .qr-container {
                box-shadow: none !important;
                border: 2px solid #000000 !important;
            }

            .animate-scan {
                display: none !important;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-gray-950 text-white flex flex-col justify-between font-sans selection:bg-red-500 selection:text-white"
    x-data="{
        copied: false,
        isFullscreen: false,
        copyLink() {
            navigator.clipboard.writeText('{{ $scanUrl }}');
            this.copied = true;
            setTimeout(() => this.copied = false, 2500);
        },
        toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
                this.isFullscreen = true;
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                    this.isFullscreen = false;
                }
            }
        }
    }">

    <!-- Top Action Bar (Hidden on Print) -->
    <header class="no-print sticky top-0 z-50 border-b border-white/10 bg-gray-950/80 backdrop-blur-xl px-4 py-3 sm:px-6">
        <div class="container mx-auto flex flex-wrap items-center justify-between gap-3">
            <a href="{{ route('admin.events.show', $event->slug) }}"
                class="inline-flex items-center gap-2 text-xs font-bold text-gray-300 transition hover:text-white">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Detail Kegiatan</span>
            </a>

            <div class="flex flex-wrap items-center gap-2">
                <button type="button" @click="copyLink()"
                    class="inline-flex items-center gap-1.5 rounded-xl border border-white/10 bg-white/5 px-3.5 py-2 text-xs font-bold text-gray-200 transition hover:bg-white/10 hover:text-white">
                    <i class="fa-solid" :class="copied ? 'fa-check text-green-400' : 'fa-link'"></i>
                    <span x-text="copied ? 'Tautan Disalin!' : 'Salin Tautan Presensi'"></span>
                </button>

                <button type="button" @click="toggleFullscreen()"
                    class="inline-flex items-center gap-1.5 rounded-xl border border-white/10 bg-white/5 px-3.5 py-2 text-xs font-bold text-gray-200 transition hover:bg-white/10 hover:text-white">
                    <i class="fa-solid" :class="isFullscreen ? 'fa-compress' : 'fa-expand'"></i>
                    <span x-text="isFullscreen ? 'Keluar Fullscreen' : 'Mode Layar Penuh'"></span>
                </button>

                <button type="button" onclick="window.print()"
                    class="inline-flex items-center gap-1.5 rounded-xl bg-red-600 px-4 py-2 text-xs font-black uppercase tracking-wider text-white shadow-lg shadow-red-600/30 transition hover:bg-red-700">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Standee</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Standee Area -->
    <main class="container mx-auto flex flex-1 items-center justify-center p-4 sm:p-6 md:p-10">
        <div class="standee-card relative w-full max-w-2xl overflow-hidden rounded-[2.5rem] border border-white/10 bg-linear-to-b from-gray-900/90 via-gray-950/90 to-black p-6 sm:p-10 shadow-[0_0_80px_rgba(220,38,38,0.15)] backdrop-blur-2xl">
            <!-- Decorative Corners -->
            <div class="pointer-events-none absolute top-8 left-8 h-8 w-8 rounded-tl-xl border-t-2 border-l-2 border-red-500"></div>
            <div class="pointer-events-none absolute top-8 right-8 h-8 w-8 rounded-tr-xl border-t-2 border-r-2 border-red-500"></div>
            <div class="pointer-events-none absolute bottom-8 left-8 h-8 w-8 rounded-bl-xl border-b-2 border-l-2 border-red-500"></div>
            <div class="pointer-events-none absolute bottom-8 right-8 h-8 w-8 rounded-br-xl border-b-2 border-r-2 border-red-500"></div>

            <div class="flex flex-col items-center text-center">
                <!-- Branding -->
                <div class="mb-4 flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="HMIF Logo" class="h-12 w-12 object-contain" />
                    <div class="text-left">
                        <p class="text-sm font-black uppercase tracking-wider text-white">HMIF UKRI</p>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-red-400">
                            {{ $event->period?->name ?? 'Kabinet METAFORSA' }}
                        </p>
                    </div>
                </div>

                <!-- Category & Status Badge -->
                <div class="mb-3 flex flex-wrap items-center justify-center gap-2">
                    <span class="rounded-full border border-red-500/30 bg-red-500/10 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-red-400">
                        {{ $event->category?->name ?? 'Kegiatan' }}
                    </span>
                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[10px] font-bold text-gray-300">
                        {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y - H:i') }} WIB
                    </span>
                </div>

                <!-- Event Title -->
                <h1 class="mb-2 text-2xl sm:text-3xl md:text-4xl font-black tracking-tight text-white leading-tight">
                    {{ $event->title }}
                </h1>

                <!-- Location -->
                <p class="mb-6 inline-flex items-center gap-1.5 text-xs sm:text-sm font-medium text-gray-300">
                    <i class="fa-solid fa-location-dot text-red-500"></i>
                    <span>{{ $event->location }}</span>
                </p>

                <!-- QR Code Box -->
                <div class="relative group my-2">
                    <div class="absolute -inset-2 rounded-3xl bg-linear-to-tr from-red-600 via-orange-500 to-red-800 opacity-30 blur-lg transition duration-700 group-hover:opacity-50"></div>
                    <div class="qr-container relative rounded-2xl bg-white p-4 sm:p-5 shadow-2xl transition duration-300 transform group-hover:scale-[1.01]">
                        <div class="absolute inset-x-0 top-0 h-1 bg-linear-to-r from-transparent via-red-500 to-transparent animate-scan z-20"></div>
                        <div class="relative z-10 flex items-center justify-center">
                            {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(260)
                                ->backgroundColor(255, 255, 255)
                                ->color(0, 0, 0)
                                ->margin(1)
                                ->generate($scanUrl) !!}
                        </div>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="mt-6 space-y-2">
                    <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-1.5 backdrop-blur-md">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                        </span>
                        <span class="text-[11px] font-bold tracking-wider text-gray-200">
                            Arahkan kamera ponsel Anda ke QR Code untuk Presensi / Pendaftaran
                        </span>
                    </div>

                    <p class="text-[11px] font-mono text-gray-400 select-all">
                        {{ $scanUrl }}
                    </p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer Standee (Hidden on Print) -->
    <footer class="no-print py-4 text-center text-xs text-gray-500 border-t border-white/5">
        <p>&copy; {{ date('Y') }} Himpunan Mahasiswa Teknik Informatika - Universitas Kebangsaan Republik Indonesia</p>
    </footer>
</body>

</html>
