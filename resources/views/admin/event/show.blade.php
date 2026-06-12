<x-app-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => $event->title . ' - HMIF UKRI',
            'description' =>
                'Portal Internal Pengurus HMIF UKRI untuk mengelola konten dan kegiatan organisasi secara efisien.',
            'keywords' => 'hmif, ukri, himatif, hima, informatika, kegiatan, agenda, seminar, workshop',
            'image' => asset('images/banner-kegiatan.png'),
            'url' => url()->current(),
        ])
    </x-slot>

    <x-slot name="header_title">
        Content / Events / Event Overview
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-3 px-4 sm:px-6 lg:px-8">
        <a href="{{ route('admin.events.index') }}"
            class="inline-flex items-center gap-2 text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] hover:text-red-600 transition-colors">
            <ion-icon name="arrow-back-outline"></ion-icon>
            Back to Events
        </a>

        @if (session('success') || session('warning') || session('error') || $errors->any())
            <div class="rounded-2xl border border-white/10 bg-gray-900 p-4">
                @if (session('success'))
                    <p class="text-sm font-bold text-emerald-400">{{ session('success') }}</p>
                @endif
                @if (session('warning'))
                    <p class="text-sm font-bold text-yellow-400">{{ session('warning') }}</p>
                @endif
                @if (session('error'))
                    <p class="text-sm font-bold text-red-400">{{ session('error') }}</p>
                @endif
                @if ($errors->any())
                    <ul class="list-disc space-y-1 pl-5 text-sm text-red-400">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        <div class="min-h-screen bg-gray-950 font-sans text-white selection:bg-red-500 selection:text-white">
            <div class="pointer-events-none fixed inset-0 z-0 opacity-[0.03]"
                style="
                background-image: url('https://grainy-gradients.vercel.app/noise.svg');
            ">
            </div>

            <div class="relative h-[55vh] min-h-112.5 w-full overflow-hidden">
                <img src="{{ $event->getFirstMediaUrl('thumbnails') }}" alt="{{ $event->title }}"
                    class="absolute inset-0 h-full w-full object-cover object-center transition-transform duration-1000 hover:scale-105"
                    onerror="this.onerror=null; this.src='https://placehold.co/1200x600/1a1a1a/cccccc?text=No+Image';" />

                <div class="absolute inset-0 bg-linear-to-t from-gray-950 via-gray-950/70 to-black/30"></div>

                <div
                    class="pointer-events-none absolute bottom-0 left-1/2 h-75 w-[60%] -translate-x-1/2 translate-y-1/2 rounded-full bg-red-900/50 blur-[120px]">
                </div>

                <div class="absolute inset-0 flex flex-col justify-end pb-12 sm:pb-16">
                    <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                            <nav class="flex items-center gap-2 text-sm text-gray-400">
                                <a href="{{ route('home') }}" class="transition hover:text-red-500">
                                    Beranda
                                </a>
                                <span class="text-gray-600">/</span>
                                <a href="{{ route('event.index') }}" class="transition hover:text-red-500">
                                    Kegiatan
                                </a>
                            </nav>

                            <a href="{{ route('event.index') }}"
                                class="flex items-center gap-2 text-sm font-medium text-red-500 transition hover:text-white sm:hidden">
                                <i class="fa-solid fa-arrow-left"></i>
                                Kembali
                            </a>
                        </div>

                        <div class="flex flex-col gap-4">
                            <div>
                                <span
                                    class="inline-flex items-center rounded-full border border-red-500/30 bg-red-900/20 px-3 py-1 text-xs font-bold tracking-wider text-red-400 uppercase shadow-lg shadow-red-900/20 backdrop-blur-md">
                                    {{ $event->category->name ?? 'Event HMIF' }}
                                </span>
                            </div>

                            <h1
                                class="max-w-5xl text-2xl leading-tight font-extrabold tracking-tight text-white drop-shadow-2xl md:text-3xl">
                                {{ $event->title }}
                            </h1>

                            <div class="mt-2 hidden items-center gap-6 text-gray-300 sm:flex">
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-calendar text-red-500"></i>
                                    <span>
                                        {{ \Carbon\Carbon::parse($event->event_date)->locale('id')->translatedFormat('l, d F Y') }}
                                    </span>
                                </div>
                                <div class="h-4 w-px bg-gray-700"></div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-location-dot text-red-500"></i>
                                    <span>{{ $event->location }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative z-10 mx-auto -mt-8 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-8 xl:grid-cols-12">
                    <div class="space-y-8 xl:col-span-8">
                        <div
                            class="rounded-2xl border border-white/10 bg-white/5 p-6 shadow-2xl backdrop-blur-xl md:p-10">
                            <div class="mb-8 rounded-xl border-l-4 border-red-600 bg-red-900/10 p-5">
                                <p class="text-lg leading-relaxed font-medium text-gray-200 italic">
                                    "{{ Str::limit($event->short_description, 55, '...') }}"
                                </p>
                            </div>

                            <div id="editorjs-content"
                                class="prose prose-invert prose-lg prose-headings:font-bold prose-headings:text-white prose-p:text-gray-300 prose-p:leading-relaxed prose-a:text-red-400 prose-a:no-underline hover:prose-a:underline prose-strong:text-white prose-li:text-gray-300 prose-img:rounded-xl prose-img:shadow-lg max-w-none font-poppins">
                            </div>

                            <div
                                class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-white/10 pt-6 sm:flex-row">
                                <span class="text-sm font-medium text-gray-400">
                                    Bagikan informasi ini:
                                </span>
                                <div class="flex gap-3">
                                    <a href="https://wa.me/?text={{ urlencode($event->title . ' - ' . url()->current()) }}"
                                        target="_blank"
                                        class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-white/5 text-white transition hover:scale-110 hover:border-transparent hover:bg-[#25D366] hover:text-white">
                                        <i class="fa-brands fa-whatsapp text-lg"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ urlencode($event->title) }}"
                                        target="_blank"
                                        class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-white/5 text-white transition hover:scale-110 hover:border-transparent hover:bg-[#1DA1F2] hover:text-white">
                                        <i class="fa-brands fa-twitter text-lg"></i>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                        target="_blank"
                                        class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-white/5 text-white transition hover:scale-110 hover:border-transparent hover:bg-[#1877F2] hover:text-white">
                                        <i class="fa-brands fa-facebook-f text-lg"></i>
                                    </a>
                                    <button
                                        onclick="navigator.clipboard.writeText('{{ url()->current() }}'); alert('Link berhasil disalin!')"
                                        class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-white/5 text-white transition hover:scale-110 hover:border-transparent hover:bg-gray-700">
                                        <i class="fa-solid fa-link text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="xl:col-span-4">
                        <div class="space-y-6 xl:sticky xl:top-24">
                            <div
                                class="rounded-2xl border border-white/10 bg-gray-900/90 p-6 shadow-2xl ring-1 ring-white/5 backdrop-blur-xl">
                                <h3
                                    class="mb-6 flex items-center gap-2 border-b border-white/10 pb-4 text-lg font-bold text-white">
                                    <i class="fa-solid fa-circle-info text-red-500"></i>
                                    Detail Acara
                                </h3>

                            <div class="space-y-6">
                                <div>
                                    <p class="mb-2 text-xs font-bold text-gray-500 uppercase">
                                        Status
                                        </p>
                                        @if ($event->status == 'upcoming')
                                            <span
                                                class="inline-flex w-full items-center gap-2 rounded-lg border border-blue-500/20 bg-blue-500/10 px-3 py-2 text-sm font-bold text-blue-400">
                                                <span class="relative flex h-2 w-2">
                                                    <span
                                                        class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span>
                                                    <span
                                                        class="relative inline-flex h-2 w-2 rounded-full bg-blue-500"></span>
                                                </span>
                                                Akan Datang
                                            </span>
                                        @elseif ($event->status == 'completed')
                                            <span
                                                class="inline-flex w-full items-center gap-2 rounded-lg border border-green-500/20 bg-green-500/10 px-3 py-2 text-sm font-bold text-green-400">
                                                <i class="fa-solid fa-check-circle"></i>
                                                Terlaksana
                                            </span>
                                        @elseif ($event->status == 'cancelled')
                                            <span
                                                class="inline-flex w-full items-center gap-2 rounded-lg border border-red-500/20 bg-red-500/10 px-3 py-2 text-sm font-bold text-red-400">
                                                <i class="fa-solid fa-ban"></i>
                                                Dibatalkan
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex w-full items-center gap-2 rounded-lg border border-gray-500/20 bg-gray-500/10 px-3 py-2 text-sm font-bold text-gray-400">
                                                <i class="fa-solid fa-rotate"></i>
                                                Sedang Berjalan
                                        </span>
                                    @endif
                                </div>

                                <div>
                                    <p class="mb-2 text-xs font-bold text-gray-500 uppercase">
                                        Mode Event
                                    </p>
                                    @if ($event->event_mode === 'registration')
                                        <span
                                            class="inline-flex w-full items-center gap-2 rounded-lg border border-emerald-500/20 bg-emerald-500/10 px-3 py-2 text-sm font-bold text-emerald-400">
                                            <i class="fa-solid fa-user-plus"></i>
                                            Pendaftaran Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex w-full items-center gap-2 rounded-lg border border-cyan-500/20 bg-cyan-500/10 px-3 py-2 text-sm font-bold text-cyan-400">
                                            <i class="fa-solid fa-qrcode"></i>
                                            Absensi Aktif
                                        </span>
                                    @endif
                                </div>

                                @if (false && $event->event_mode === 'registration')
                                    <div class="rounded-xl border border-white/10 bg-black/30 p-4">
                                        <div class="mb-4 flex items-center justify-between gap-3">
                                            <p class="text-xs font-bold uppercase text-gray-500">
                                                Data Pendaftaran
                                            </p>
                                            <span class="rounded-full border border-white/10 bg-white/5 px-2 py-1 text-[10px] font-bold text-gray-300">
                                                {{ $event->registrations_count }} orang
                                            </span>
                                        </div>

                                        @if ($event->registrations->isNotEmpty())
                                            <div class="space-y-3">
                                                @foreach ($event->registrations as $registration)
                                                    <div class="rounded-lg border border-white/10 bg-white/5 p-3">
                                                        <div class="flex items-start justify-between gap-3">
                                                            <div>
                                                                <p class="text-sm font-bold text-white">
                                                                    {{ $registration->full_name }}
                                                                </p>
                                                                <p class="text-[11px] text-gray-400">
                                                                    {{ $registration->email }}
                                                                </p>
                                                            </div>
                                                            <span class="text-[10px] text-gray-500">
                                                                {{ $registration->created_at?->diffForHumans() }}
                                                            </span>
                                                        </div>
                                                        <div class="mt-2 text-[11px] text-gray-400">
                                                            {{ $registration->phone }}
                                                            @if ($registration->institution)
                                                                <span class="mx-1 text-gray-600">•</span>
                                                                {{ $registration->institution }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500">
                                                Belum ada peserta yang mendaftar.
                                            </p>
                                        @endif
                                    </div>
                                @endif

                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-red-500">
                                            <i class="fa-regular fa-calendar-check text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-500 uppercase">
                                                Tanggal Pelaksanaan
                                            </p>
                                            <p class="mt-0.5 font-semibold text-white">
                                                {{ \Carbon\Carbon::parse($event->event_date)->locale('id')->translatedFormat('l, d F Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-4">
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-red-500">
                                            <i class="fa-solid fa-map-location-dot text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-500 uppercase">
                                                Lokasi
                                            </p>
                                            <p class="mt-0.5 leading-snug font-semibold text-white">
                                                {{ $event->location }}
                                            </p>
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($event->location) }}"
                                                target="_blank"
                                                class="mt-2 inline-flex items-center gap-1 text-xs text-red-400 hover:text-red-300 hover:underline">
                                                Buka di Google Maps
                                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                        </a>
                                    </div>
                                </div>

                                @if ($event->event_mode === 'registration' && $event->whatsapp_group_link)
                                    <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                                        <p class="mb-3 text-xs font-bold text-gray-500 uppercase">
                                            Link Grup WhatsApp
                                        </p>
                                        <a href="{{ $event->whatsapp_group_link }}" target="_blank"
                                            rel="noopener"
                                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-green-700">
                                            <i class="fa-brands fa-whatsapp"></i>
                                            Buka Link Grup
                                        </a>
                                    </div>
                                @endif
                            </div>

                                <div class="mt-8 border-t border-white/10 pt-6">
                                    @if ($event->event_mode === 'attendance' && $event->status == 'ongoing')
                                        <a href="{{ route('admin.attendances.qrcode', $event->slug) }}" target="_blank"
                                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-4 rounded-xl font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 transition">
                                            <i class="fa-solid fa-qrcode"></i> Generate QR Code absensi
                                        </a>
                                    @elseif ($event->event_mode === 'registration' && $event->whatsapp_group_link)
                                        <p class="text-xs font-medium text-gray-500">
                                            Link grup tersedia pada kartu di atas.
                                        </p>
                                    @else
                                        <button disabled
                                            class="w-full cursor-not-allowed rounded-xl border border-white/10 bg-white/5 px-6 py-3.5 text-center font-bold text-gray-500">
                                            @if ($event->event_mode === 'registration')
                                                Link Grup Belum Disiapkan
                                            @else
                                                Kegiatan Berakhir
                                            @endif
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm">
                                <p class="mb-3 text-xs font-bold text-gray-500 uppercase">
                                    Diselenggarakan Oleh
                                </p>
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('images/logo.png') }}" alt="HMIF Logo"
                                        class="h-10 w-10 object-contain brightness-90" />
                                    <div>
                                        <p class="text-sm font-bold text-white">
                                            HMIF UKRI
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            Kabinet METAFORSA
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($event->event_mode === 'registration')
                    <div class="mt-8 rounded-2xl border border-white/10 bg-gray-900/90 p-6 shadow-2xl ring-1 ring-white/5 backdrop-blur-xl">
                        <div class="mb-6 flex flex-col gap-4 border-b border-white/10 pb-5 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <p class="mb-2 text-[10px] font-black uppercase tracking-[0.3em] text-emerald-400">
                                    Data Pendaftaran
                                </p>
                                <h2 class="text-2xl font-black text-white">
                                    {{ $event->registrations_count }} Peserta Terdaftar
                                </h2>
                                @if ($registrationSearch !== '')
                                    <p class="mt-2 text-xs text-gray-400">
                                        Menampilkan {{ $registrations->total() }} hasil untuk "{{ $registrationSearch }}".
                                    </p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2 lg:items-end">
                                <form method="GET" action="{{ route('admin.events.show', $event->slug) }}"
                                    class="flex w-full gap-2 sm:w-80">
                                    <input type="text" name="registration_search" value="{{ $registrationSearch }}"
                                        placeholder="Cari nama pendaftar..."
                                        class="h-10 min-w-0 flex-1 rounded-lg border border-white/10 bg-black/40 px-3 text-xs text-white outline-none transition placeholder:text-gray-600 focus:border-emerald-600">
                                    <button type="submit"
                                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-600 text-white transition hover:bg-emerald-700"
                                        title="Cari pendaftar">
                                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                    </button>
                                    @if ($registrationSearch !== '')
                                        <a href="{{ route('admin.events.show', $event->slug) }}"
                                            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-gray-400 transition hover:bg-red-600 hover:text-white"
                                            title="Reset pencarian">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </a>
                                    @endif
                                </form>

                                <div class="flex flex-wrap items-center gap-2">
                                    <button type="button" x-on:click="$dispatch('open-modal', 'certificate-all')"
                                        class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-blue-600 px-3.5 text-[10px] font-bold uppercase tracking-wider text-white transition hover:bg-blue-700">
                                        <i class="fa-solid fa-paper-plane text-[11px]"></i>
                                        Kirim Sertifikat
                                    </button>
                                    <a href="{{ route('admin.events.registrations.export', $event->slug) }}"
                                        class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-emerald-600 px-3.5 text-[10px] font-bold uppercase tracking-wider text-white transition hover:bg-emerald-700">
                                        <i class="fa-solid fa-file-excel text-[11px]"></i>
                                        Download Excel
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6 grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-5">
                            @forelse ($registrationCategories as $category)
                                <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-500">
                                        {{ $category->label }}
                                    </p>
                                    <div class="mt-3 flex items-end justify-between gap-3">
                                        <p class="text-2xl font-black text-white">
                                            {{ $category->total }}
                                        </p>
                                        <p class="text-xs font-bold text-emerald-400">
                                            {{ number_format(($category->total / max($event->registrations_count, 1)) * 100, 1) }}%
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                                    <p class="text-sm text-gray-500">
                                        Belum ada kategori peserta.
                                    </p>
                                </div>
                            @endforelse
                        </div>

                        <div class="mb-6 rounded-xl border border-white/10 bg-black/30 p-5">
                            <div class="mb-4 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-500">
                                        Rata-rata Angkatan Mahasiswa
                                    </p>
                                    <p class="mt-2 text-3xl font-black text-white">
                                        {{ $batchSummary['average'] ? 'Angkatan ' . $batchSummary['average'] : '-' }}
                                    </p>
                                </div>
                                <div class="text-left md:text-right">
                                    <p class="text-xs font-bold text-emerald-400">
                                        {{ $batchSummary['count'] }} data valid
                                    </p>
                                    @if ($batchSummary['invalid_count'] > 0)
                                        <p class="mt-1 text-xs text-yellow-400">
                                            {{ $batchSummary['invalid_count'] }} data angkatan belum terbaca formatnya
                                        </p>
                                    @endif
                                </div>
                            </div>

                            @if ($batchSummary['distribution']->isNotEmpty())
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($batchSummary['distribution'] as $batch)
                                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-bold text-gray-300">
                                            {{ $batch['year'] }}: {{ $batch['total'] }} orang
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500">
                                    Belum ada data angkatan mahasiswa yang bisa dihitung.
                                </p>
                            @endif
                        </div>

                        <div class="overflow-hidden rounded-xl border border-white/10">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-white/10 text-left">
                                    <thead class="bg-white/5">
                                        <tr>
                                            <th class="w-[30%] px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">Peserta</th>
                                            <th class="w-[18%] px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">Kategori</th>
                                            <th class="w-[22%] px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">Instansi</th>
                                            <th class="w-[15%] px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">Akademik</th>
                                            <th class="w-[10%] px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">Sertifikat</th>
                                            <th class="w-[5%] px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/10 bg-black/20">
                                        @forelse ($registrations as $registration)
                                            <tr class="transition hover:bg-white/5">
                                                <td class="px-4 py-4 align-top">
                                                    <p class="text-sm font-bold leading-snug text-white">
                                                        {{ $registration->full_name }}
                                                    </p>
                                                    <p class="mt-1 break-all text-xs text-gray-400">
                                                        {{ $registration->email }}
                                                    </p>
                                                    <p class="mt-1 text-xs text-gray-500">
                                                        {{ $registration->phone }}
                                                    </p>
                                                    <p class="mt-2 text-[10px] font-bold uppercase tracking-widest text-gray-600">
                                                        {{ $registration->created_at?->format('d M Y H:i') }}
                                                    </p>
                                                </td>
                                                <td class="px-4 py-4 align-top">
                                                    <span class="rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-1 text-[10px] font-bold text-emerald-300">
                                                        {{ $registration->participant_category ?: 'Tidak Diisi' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-4 align-top text-sm leading-relaxed text-gray-300">
                                                    {{ $registration->institution ?: '-' }}
                                                </td>
                                                <td class="px-4 py-4 align-top text-sm leading-relaxed text-gray-300">
                                                    <p>{{ $registration->major ?: '-' }}</p>
                                                    <p class="mt-1 text-xs text-gray-500">
                                                        Angkatan {{ $registration->batch ?: '-' }}
                                                    </p>
                                                </td>
                                                <td class="px-4 py-4 align-top">
                                                    @if ($registration->certificate_sent_at)
                                                        <span class="inline-flex whitespace-nowrap rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-1 text-[10px] font-bold text-emerald-300">
                                                            {{ $registration->certificate_sent_at->format('d M Y H:i') }}
                                                        </span>
                                                    @else
                                                        <span class="inline-flex whitespace-nowrap rounded-full border border-yellow-500/20 bg-yellow-500/10 px-3 py-1 text-[10px] font-bold text-yellow-300">
                                                            Belum dikirim
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-4 align-top">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <button type="button"
                                                            x-on:click="$dispatch('open-modal', 'edit-registration-{{ $registration->id }}')"
                                                            class="inline-flex size-9 shrink-0 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-gray-300 transition hover:bg-blue-600 hover:text-white"
                                                            title="Edit pendaftar">
                                                            <i class="fa-solid fa-pen text-xs"></i>
                                                        </button>
                                                        <button type="button"
                                                            x-on:click="$dispatch('open-modal', 'certificate-registration-{{ $registration->id }}')"
                                                            class="inline-flex size-9 shrink-0 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-gray-300 transition hover:bg-emerald-600 hover:text-white"
                                                            title="Kirim sertifikat">
                                                            <i class="fa-solid fa-paper-plane text-xs"></i>
                                                        </button>
                                                        <form action="{{ route('admin.events.registrations.destroy', [$event->slug, $registration]) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Hapus data pendaftar ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="inline-flex size-9 shrink-0 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-gray-300 transition hover:bg-red-600 hover:text-white"
                                                                title="Hapus pendaftar">
                                                                <i class="fa-solid fa-trash text-xs"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="px-4 py-12 text-center text-sm text-gray-500">
                                                    Belum ada peserta yang mendaftar.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if ($registrations->hasPages())
                            <nav class="mt-5 flex flex-wrap items-center justify-between gap-3">
                                <p class="text-xs text-gray-500">
                                    Menampilkan {{ $registrations->firstItem() }}-{{ $registrations->lastItem() }}
                                    dari {{ $registrations->total() }} data
                                </p>
                                <div class="flex flex-wrap items-center gap-2">
                                    @if ($registrations->onFirstPage())
                                        <span class="rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-xs font-bold text-gray-600">
                                            Sebelumnya
                                        </span>
                                    @else
                                        <a href="{{ $registrations->previousPageUrl() }}"
                                            class="rounded-lg border border-white/10 bg-gray-800 px-3 py-2 text-xs font-bold text-gray-200 transition hover:border-emerald-500/50 hover:bg-emerald-600 hover:text-white">
                                            Sebelumnya
                                        </a>
                                    @endif

                                    @foreach ($registrations->getUrlRange(1, $registrations->lastPage()) as $page => $url)
                                        @if ($page === $registrations->currentPage())
                                            <span class="rounded-lg border border-emerald-500 bg-emerald-600 px-3 py-2 text-xs font-black text-white">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $url }}"
                                                class="rounded-lg border border-white/10 bg-gray-800 px-3 py-2 text-xs font-bold text-gray-200 transition hover:border-emerald-500/50 hover:bg-emerald-600 hover:text-white">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach

                                    @if ($registrations->hasMorePages())
                                        <a href="{{ $registrations->nextPageUrl() }}"
                                            class="rounded-lg border border-white/10 bg-gray-800 px-3 py-2 text-xs font-bold text-gray-200 transition hover:border-emerald-500/50 hover:bg-emerald-600 hover:text-white">
                                            Berikutnya
                                        </a>
                                    @else
                                        <span class="rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-xs font-bold text-gray-600">
                                            Berikutnya
                                        </span>
                                    @endif
                                </div>
                            </nav>
                        @endif

                        <x-modal name="certificate-all" maxWidth="2xl">
                            <form action="{{ route('admin.events.registrations.certificates', $event->slug) }}"
                                method="POST" enctype="multipart/form-data" class="p-5 md:p-6">
                                @csrf
                                <div class="mb-4">
                                    <p class="mb-2 text-[10px] font-black uppercase tracking-[0.3em] text-blue-400">
                                        Kirim Global
                                    </p>
                                    <h2 class="text-xl font-black text-white">
                                        Kirim Sertifikat ke Semua Peserta
                                    </h2>
                                    <p class="mt-2 text-sm text-gray-400">
                                        File yang sama akan dikirim ke semua peserta terdaftar.
                                    </p>
                                </div>

                                <div class="space-y-3">
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Subject Email</label>
                                        <input type="text" name="certificate_subject"
                                            value="Sertifikat Kegiatan - {{ $event->title }}"
                                            class="w-full rounded-lg border border-white/10 bg-black/40 px-3.5 py-2.5 text-sm text-white outline-none transition focus:border-blue-600">
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Ucapan / Pesan</label>
                                        <textarea name="certificate_message" rows="4" required
                                            class="w-full resize-none rounded-lg border border-white/10 bg-black/40 px-3.5 py-2.5 text-sm text-white outline-none transition focus:border-blue-600">Terima kasih sudah mengikuti {{ $event->title }}. Semoga ilmu dan pengalaman dari kegiatan ini bermanfaat. Sertifikat peserta kami lampirkan pada email ini.</textarea>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-widest text-gray-500">File Sertifikat</label>
                                        <input type="file" name="certificate_file" required accept=".pdf,.jpg,.jpeg,.png"
                                            class="w-full rounded-lg border border-white/10 bg-black/40 px-3.5 py-2.5 text-sm text-gray-300 outline-none transition file:mr-4 file:rounded-md file:border-0 file:bg-blue-600 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-white focus:border-blue-600">
                                        <p class="mt-2 text-[10px] text-gray-500">PDF/JPG/PNG, maksimal 10MB.</p>
                                    </div>
                                </div>

                                <div class="mt-5 flex justify-end gap-2">
                                    <button type="button" x-on:click="$dispatch('close-modal', 'certificate-all')"
                                        class="rounded-lg border border-white/10 px-4 py-2.5 text-xs font-bold text-gray-400 transition hover:bg-white/5">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="rounded-lg bg-blue-600 px-4 py-2.5 text-xs font-black uppercase tracking-widest text-white transition hover:bg-blue-700">
                                        Kirim Semua
                                    </button>
                                </div>
                            </form>
                        </x-modal>

                        @foreach ($registrations as $registration)
                            <x-modal name="edit-registration-{{ $registration->id }}" maxWidth="xl">
                                <form action="{{ route('admin.events.registrations.update', [$event->slug, $registration]) }}"
                                    method="POST" class="p-5 md:p-6">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4">
                                        <p class="mb-2 text-[10px] font-black uppercase tracking-[0.3em] text-blue-400">
                                            Edit Pendaftar
                                        </p>
                                        <h2 class="text-xl font-black text-white">
                                            {{ $registration->full_name }}
                                        </h2>
                                    </div>

                                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Nama Lengkap</label>
                                            <input type="text" name="full_name" value="{{ $registration->full_name }}" required
                                                class="w-full rounded-lg border border-white/10 bg-black/40 px-3.5 py-2.5 text-sm text-white outline-none transition focus:border-blue-600">
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Email</label>
                                            <input type="email" name="email" value="{{ $registration->email }}" required
                                                class="w-full rounded-lg border border-white/10 bg-black/40 px-3.5 py-2.5 text-sm text-white outline-none transition focus:border-blue-600">
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-widest text-gray-500">No. WhatsApp</label>
                                            <input type="text" name="phone" value="{{ $registration->phone }}" required
                                                class="w-full rounded-lg border border-white/10 bg-black/40 px-3.5 py-2.5 text-sm text-white outline-none transition focus:border-blue-600">
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Kategori Peserta</label>
                                            <select name="participant_category" required
                                                class="w-full rounded-lg border border-white/10 bg-black/40 px-3.5 py-2.5 text-sm text-white outline-none transition focus:border-blue-600">
                                                @foreach (['Mahasiswa', 'Pelajar', 'Pekerja', 'Umum', 'Lainnya'] as $category)
                                                    <option value="{{ $category }}" class="bg-gray-950"
                                                        {{ $registration->participant_category === $category ? 'selected' : '' }}>
                                                        {{ $category }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Instansi</label>
                                            <input type="text" name="institution" value="{{ $registration->institution }}" required
                                                class="w-full rounded-lg border border-white/10 bg-black/40 px-3.5 py-2.5 text-sm text-white outline-none transition focus:border-blue-600">
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Prodi/Jurusan</label>
                                            <input type="text" name="major" value="{{ $registration->major }}"
                                                class="w-full rounded-lg border border-white/10 bg-black/40 px-3.5 py-2.5 text-sm text-white outline-none transition focus:border-blue-600">
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Angkatan</label>
                                            <input type="text" name="batch" value="{{ $registration->batch }}"
                                                class="w-full rounded-lg border border-white/10 bg-black/40 px-3.5 py-2.5 text-sm text-white outline-none transition focus:border-blue-600">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Catatan</label>
                                            <textarea name="notes" rows="2"
                                                class="w-full resize-none rounded-lg border border-white/10 bg-black/40 px-3.5 py-2.5 text-sm text-white outline-none transition focus:border-blue-600">{{ $registration->notes }}</textarea>
                                        </div>
                                    </div>

                                    <div class="mt-5 flex justify-end gap-2">
                                        <button type="button" x-on:click="$dispatch('close-modal', 'edit-registration-{{ $registration->id }}')"
                                            class="rounded-lg border border-white/10 px-4 py-2.5 text-xs font-bold text-gray-400 transition hover:bg-white/5">
                                            Batal
                                        </button>
                                        <button type="submit"
                                            class="rounded-lg bg-blue-600 px-4 py-2.5 text-xs font-black uppercase tracking-widest text-white transition hover:bg-blue-700">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </x-modal>

                            <x-modal name="certificate-registration-{{ $registration->id }}" maxWidth="xl">
                                <form action="{{ route('admin.events.registrations.certificate', [$event->slug, $registration]) }}"
                                    method="POST" enctype="multipart/form-data" class="p-5 md:p-6">
                                    @csrf
                                    <div class="mb-4">
                                        <p class="mb-2 text-[10px] font-black uppercase tracking-[0.3em] text-emerald-400">
                                            Kirim Sertifikat
                                        </p>
                                        <h2 class="text-xl font-black text-white">
                                            {{ $registration->full_name }}
                                        </h2>
                                        <p class="mt-2 text-sm text-gray-400">
                                            Email tujuan: {{ $registration->email }}
                                        </p>
                                    </div>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Subject Email</label>
                                            <input type="text" name="certificate_subject"
                                                value="Sertifikat Kegiatan - {{ $event->title }}"
                                                class="w-full rounded-lg border border-white/10 bg-black/40 px-3.5 py-2.5 text-sm text-white outline-none transition focus:border-emerald-600">
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-widest text-gray-500">Ucapan / Pesan</label>
                                            <textarea name="certificate_message" rows="4" required
                                                class="w-full resize-none rounded-lg border border-white/10 bg-black/40 px-3.5 py-2.5 text-sm text-white outline-none transition focus:border-emerald-600">Terima kasih sudah mengikuti {{ $event->title }}. Semoga ilmu dan pengalaman dari kegiatan ini bermanfaat. Sertifikat peserta kami lampirkan pada email ini.</textarea>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-widest text-gray-500">File Sertifikat</label>
                                            <input type="file" name="certificate_file" required accept=".pdf,.jpg,.jpeg,.png"
                                                class="w-full rounded-lg border border-white/10 bg-black/40 px-3.5 py-2.5 text-sm text-gray-300 outline-none transition file:mr-4 file:rounded-md file:border-0 file:bg-emerald-600 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-white focus:border-emerald-600">
                                            <p class="mt-2 text-[10px] text-gray-500">PDF/JPG/PNG, maksimal 10MB.</p>
                                        </div>
                                    </div>

                                    <div class="mt-5 flex justify-end gap-2">
                                        <button type="button" x-on:click="$dispatch('close-modal', 'certificate-registration-{{ $registration->id }}')"
                                            class="rounded-lg border border-white/10 px-4 py-2.5 text-xs font-bold text-gray-400 transition hover:bg-white/5">
                                            Batal
                                        </button>
                                        <button type="submit"
                                            class="rounded-lg bg-emerald-600 px-4 py-2.5 text-xs font-black uppercase tracking-widest text-white transition hover:bg-emerald-700">
                                            Kirim
                                        </button>
                                    </div>
                                </form>
                            </x-modal>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const rawData = {!! $event->description !!};
                const container = document.getElementById('editorjs-content');

                if (rawData && rawData.blocks) {
                    rawData.blocks.forEach(block => {
                        let el;
                        switch (block.type) {
                            case 'header':
                                el = document.createElement(`h${block.data.level}`);
                                el.className =
                                    'text-3xl text-white font-black tracking-tight mt-12 mb-6 uppercase';
                                el.innerHTML = block.data.text;
                                break;
                            case 'paragraph':
                                el = document.createElement('p');
                                el.className =
                                    'text-white text-sm md:text-lg text-justify leading-loose mb-4 opacity-80';
                                el.innerHTML = block.data.text;
                                break;
                            case 'list':
                                const isOrdered = block.data.style === 'ordered';
                                el = document.createElement(isOrdered ? 'ol' : 'ul');
                                el.className = 'space-y-4 text-white text-sm md:text-lg ' + (isOrdered ?
                                    'list-decimal ml-6' : 'list-disc ml-6');
                                block.data.items.forEach(item => {
                                    const li = document.createElement('li');
                                    li.innerHTML = item.content || item;
                                    el.appendChild(li);
                                });
                                break;
                            case 'quote':
                                const blockquote = document.createElement('blockquote');
                                blockquote.className =
                                    'relative p-8 md:p-12 border-l-4 border-red-600 bg-white/2 rounded-r-[2rem] my-12';
                                blockquote.innerHTML =
                                    `<p class="text-lg md:text-xl font-black text-white italic leading-tight">${block.data.text}</p>`;
                                if (block.data.caption) {
                                    blockquote.innerHTML +=
                                        `<cite class="block mt-4 text-[10px] font-black text-red-500 uppercase tracking-[0.2em]">— ${block.data.caption}</cite>`;
                                }
                                el = blockquote;
                                break;
                            case 'image':
                                const figure = document.createElement('figure');
                                figure.className = 'my-16 space-y-4';
                                const img = document.createElement('img');
                                img.src = block.data.file.url;
                                img.className =
                                    'w-full max-h-96 object-contain bg-center rounded-[3rem] border border-white/10 shadow-2xl';
                                figure.appendChild(img);
                                if (block.data.caption) {
                                    const figcaption = document.createElement('figcaption');
                                    figcaption.className =
                                        'text-center text-[10px] font-bold text-gray-600 uppercase tracking-widest italic';
                                    figcaption.innerHTML = block.data.caption;
                                    figure.appendChild(figcaption);
                                }
                                el = figure;
                                break;
                        }
                        if (el) container.appendChild(el);
                    });
                } else {
                    container.innerHTML =
                        '<p class="text-gray-500 italic text-center uppercase tracking-widest text-[10px]">No description available.</p>';
                }
            });
        </script>
    </x-slot>
</x-app-layout>
