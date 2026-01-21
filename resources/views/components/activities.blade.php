<section id="activities" class="relative overflow-hidden bg-gray-950 py-20 text-white">
    <div
        class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)]">
    </div>

    <div class="absolute top-0 left-0 h-px w-full bg-linear-to-r from-transparent via-red-900 to-transparent opacity-50">
    </div>
    <div class="absolute right-0 bottom-0 -mr-20 -mb-20 h-96 w-96 rounded-full bg-red-900/10 blur-3xl"></div>

    <div class="relative container mx-auto px-6 md:px-12">
        <div class="mb-16 text-center">
            <h2 class="mb-3 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                Program
                <span class="text-red-600">Kerja</span>
            </h2>
            <div class="mx-auto h-1 w-24 rounded-full bg-linear-to-r from-red-900 to-red-600"></div>
            <p class="mx-auto mt-4 max-w-2xl text-gray-400">
                Agenda dan aktivitas terbaru yang dilaksanakan oleh HMIF untuk meningkatkan kualitas mahasiswa.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($events as $event)
                <div
                    class="group relative flex flex-col overflow-hidden rounded-2xl border border-white/10 bg-gray-900/50 backdrop-blur-sm transition duration-500 hover:-translate-y-2 hover:border-red-600 hover:shadow-[0_0_20px_rgba(220,38,38,0.2)]">
                    <div class="relative h-56 w-full overflow-hidden">

                        @php
                            $thumbnail = $event->getFirstMediaUrl('thumbnails', 'thumb');
                            $defaultImage = 'https://placehold.co/600x400/1f2937/red?text=' . urlencode($event->title);
                        @endphp

                        <img src="{{ $thumbnail ?: $defaultImage }}" alt="{{ $event->title }}"
                            class="h-full w-full object-cover transition duration-700 group-hover:scale-110"
                            loading="lazy" />

                        <div class="absolute inset-0 bg-linear-to-t from-gray-900 via-gray-900/20 to-transparent">
                        </div>

                        <div class="absolute top-4 right-4">
                            <span
                                class="inline-flex items-center rounded-full border border-red-500/30 bg-black/60 px-3 py-1 text-xs font-semibold text-red-400 backdrop-blur-md">
                                <span class="mr-1.5 h-1.5 w-1.5 animate-pulse rounded-full bg-red-500"></span>
                                {{ $event->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-1 flex-col p-6">
                        <h3
                            class="mb-3 line-clamp-2 text-xl font-bold text-white transition-colors group-hover:text-red-500">
                            {{ $event->title }}
                        </h3>

                        <p class="mb-6 line-clamp-3 flex-1 text-sm leading-relaxed text-gray-400">
                            {{ Str::limit($event->description, 50) }}
                        </p>

                        <div
                            class="mt-auto flex items-center justify-between border-t border-white/10 pt-4 transition group-hover:border-red-900/50">
                            <a href="{{ route('event.show', $event->slug) }}"
                                class="flex items-center gap-2 text-sm font-semibold text-white transition group-hover:translate-x-1 hover:text-red-500">
                                Baca Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div
                        class="absolute bottom-0 left-0 h-0.5 w-0 bg-red-600 transition-all duration-500 group-hover:w-full">
                    </div>
                </div>
            @empty
                <div class="col-span-full py-10 text-center text-gray-500">
                    Belum ada program kerja yang ditampilkan.
                </div>
            @endforelse
        </div>

        <div class="mt-8 text-center">
            <a class="group relative inline-flex items-center overflow-hidden rounded-lg border-2 border-current bg-red-900 px-8 py-3 text-white transition-colors duration-300 hover:text-red-500 focus:ring-3 focus:outline-none"
                href="{{ route('event.index') }}">
                <span
                    class="absolute top-0 left-0 z-0 h-full w-0 bg-white transition-all duration-300 group-hover:w-full"></span>
                <span class="absolute -end-full transition-all group-hover:end-4">
                    <svg class="size-5 shadow-sm rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </span>

                <span class="z-10 text-sm font-medium transition-all group-hover:me-4">
                    Lihat Semua Kegiatan
                </span>
            </a>
        </div>
    </div>
</section>
