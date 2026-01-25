<x-guest-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => $event->title . ' - HMIF UKRI',
            'description' => $event->short_description,
            'keywords' =>
                'hmif, ukri, himatif, hima, informatika, ' . strtolower(str_replace(' ', ', ', $event->title)),
            'image' => asset('storage/' . $event->thumbnail_path),
            'url' => url()->current(),
        ])
    </x-slot>

    <div class="min-h-screen bg-gray-950 font-sans text-white selection:bg-red-500 selection:text-white">
        <div class="pointer-events-none fixed inset-0 z-0 opacity-[0.03]"
            style="
                background-image: url('https://grainy-gradients.vercel.app/noise.svg');
            ">
        </div>

        <div class="relative h-[55vh] min-h-112.5 w-full overflow-hidden">
            <img src="{{ $event->getFirstMediaUrl('thumbnails', 'thumb') }}" alt="{{ $event->title }}"
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
                                    {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}
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
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-6 shadow-2xl backdrop-blur-xl md:p-10">
                        <div class="mb-8 rounded-xl border-l-4 border-red-600 bg-red-900/10 p-5">
                            <p class="text-lg leading-relaxed font-medium text-gray-200 italic">
                                "{{ Str::limit($event->short_description, 55, '...') }}"
                            </p>
                        </div>

                        <div id="editorjs-content"
                            class="space-y-10 text-gray-400 leading-relaxed text-xl font-medium font-poppins">
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

                <div class="lg:col-span-4 font-poppins">
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
                                            {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}
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
                            </div>

                            <div class="mt-8 border-t border-white/10 pt-6">
                                @if ($event->status == 'upcoming')
                                    <a href="#"
                                        class="group relative flex w-full items-center justify-center overflow-hidden rounded-xl bg-red-600 px-6 py-3.5 text-center font-bold text-white shadow-lg shadow-red-900/30 transition duration-300 hover:scale-[1.02] hover:bg-red-700">
                                        <span class="relative z-10 flex items-center gap-2">
                                            Ikuti Kegiatan
                                            <i
                                                class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                                        </span>
                                    </a>
                                    <p class="mt-3 text-center text-[10px] text-gray-500">
                                        *Hubungi narahubung untuk info
                                        pendaftaran
                                    </p>
                                @else
                                    <button disabled
                                        class="w-full cursor-not-allowed rounded-xl border border-white/10 bg-white/5 px-6 py-3.5 text-center font-bold text-gray-500">
                                        Kegiatan Berakhir
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
                                    <p class="text-xs text-gray-400 uppercase">
                                        Kabinet {{ $event->period?->cabinet_name ?? 'MetaForsa' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($relatedEvents->isNotEmpty())
            <section class="border-t border-white/10 bg-black/40 py-16">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="mb-10 flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-white">
                                Kegiatan Lainnya
                            </h2>
                            <div class="mt-2 h-1 w-16 rounded-full bg-red-600"></div>
                        </div>
                        <a href="/kegiatan" class="text-sm font-medium text-red-500 transition hover:text-white">
                            Lihat Semua
                            <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($relatedEvents as $relatedEvent)
                            <a href="{{ route('event.show', $relatedEvent->slug) }}"
                                class="group relative flex flex-col overflow-hidden rounded-2xl border border-white/10 bg-gray-900 transition hover:-translate-y-1 hover:border-red-500/50 hover:shadow-lg hover:shadow-red-900/10">
                                <div class="relative h-48 w-full overflow-hidden">
                                    <img src="{{ $relatedEvent->getFirstMediaUrl('thumbnail', 'thumb') }}"
                                        alt="{{ $relatedEvent->title }}"
                                        class="h-full w-full object-cover transition duration-700 group-hover:scale-110"
                                        onerror="this.onerror=null; this.src='https://placehold.co/600x400/1a1a1a/cccccc?text=No+Image';" />
                                    <div
                                        class="absolute inset-0 bg-linear-to-t from-gray-900 via-transparent to-transparent opacity-90">
                                    </div>

                                    <span
                                        class="absolute top-3 right-3 rounded-md border border-white/10 bg-black/60 px-2 py-1 text-[10px] font-bold text-white backdrop-blur-sm">
                                        {{ \Carbon\Carbon::parse($relatedEvent->event_date)->format('d M Y') }}
                                    </span>
                                </div>
                                <div class="flex flex-1 flex-col p-5">
                                    <h3
                                        class="mb-2 line-clamp-2 text-lg font-bold text-white transition group-hover:text-red-500">
                                        {{ $relatedEvent->title }}
                                    </h3>
                                    <span
                                        class="mt-auto text-xs font-semibold text-gray-500 transition group-hover:text-white">
                                        Detail Kegiatan →
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </div>

    @push('script')
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
                                el.className = 'text-white text-lg md:text-xl leading-loose mb-4 opacity-80';
                                el.innerHTML = block.data.text;
                                break;
                            case 'list':
                                const isOrdered = block.data.style === 'ordered';
                                el = document.createElement(isOrdered ? 'ol' : 'ul');
                                el.className = 'space-y-4 text-gray-400 text-lg ' + (isOrdered ?
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
                                    `<p class="text-lg md:text-xl font-black text-white italic leading-tight">"${block.data.text}"</p>`;
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
    @endpush
</x-guest-layout>
