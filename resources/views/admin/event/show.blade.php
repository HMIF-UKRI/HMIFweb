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

    <div class="max-w-5xl mx-auto space-y-3">
        <a href="{{ route('admin.events.index') }}"
            class="inline-flex items-center gap-2 text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] hover:text-red-600 transition-colors">
            <ion-icon name="arrow-back-outline"></ion-icon>
            Back to Events
        </a>
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

            <div class="relative z-10 container mx-auto -mt-8 px-4 pb-20 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                    <div class="space-y-8 lg:col-span-8">
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

                    <div class="lg:col-span-4">
                        <div class="sticky top-24 space-y-6">
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
                                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-3 text-xs font-bold text-white transition hover:bg-green-700">
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
                                        <a href="{{ $event->whatsapp_group_link }}" target="_blank" rel="noopener"
                                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-4 rounded-xl font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 transition">
                                            <i class="fa-brands fa-whatsapp"></i> Buka Link Grup WhatsApp
                                        </a>
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
                            </div>
                            <a href="{{ route('admin.events.registrations.export', $event->slug) }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-[10px] font-black uppercase tracking-widest text-white transition hover:bg-emerald-700">
                                <i class="fa-solid fa-file-excel"></i>
                                Download Excel
                            </a>
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
                                            <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">Waktu</th>
                                            <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">Nama</th>
                                            <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">Email</th>
                                            <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">WhatsApp</th>
                                            <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">Kategori</th>
                                            <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">Instansi</th>
                                            <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">Prodi</th>
                                            <th class="px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500">Angkatan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/10 bg-black/20">
                                        @forelse ($registrations as $registration)
                                            <tr class="transition hover:bg-white/5">
                                                <td class="px-4 py-4 text-xs text-gray-400">
                                                    {{ $registration->created_at?->format('d M Y H:i') }}
                                                </td>
                                                <td class="px-4 py-4 text-sm font-bold text-white">
                                                    {{ $registration->full_name }}
                                                </td>
                                                <td class="px-4 py-4 text-sm text-gray-300">
                                                    {{ $registration->email }}
                                                </td>
                                                <td class="px-4 py-4 text-sm text-gray-300">
                                                    {{ $registration->phone }}
                                                </td>
                                                <td class="px-4 py-4">
                                                    <span class="rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-1 text-[10px] font-bold text-emerald-300">
                                                        {{ $registration->participant_category ?: 'Tidak Diisi' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-4 text-sm text-gray-300">
                                                    {{ $registration->institution ?: '-' }}
                                                </td>
                                                <td class="px-4 py-4 text-sm text-gray-300">
                                                    {{ $registration->major ?: '-' }}
                                                </td>
                                                <td class="px-4 py-4 text-sm text-gray-300">
                                                    {{ $registration->batch ?: '-' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="px-4 py-12 text-center text-sm text-gray-500">
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
