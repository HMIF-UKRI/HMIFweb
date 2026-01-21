<x-guest-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Kegiatan HMIF - HMIF UKRI',
            'description' => 'Agenda, dokumentasi, dan rangkaian kegiatan Himpunan Mahasiswa Informatika UKRI.',
            'keywords' => 'hmif, ukri, himatif, hima, informatika, kegiatan, agenda, seminar, workshop',
            'image' => asset('images/banner-kegiatan.png'),
            'url' => url()->current(),
        ])
    </x-slot>

    <div class="min-h-screen bg-gray-950 text-white" x-data="eventFilter(@js($events))">
        {{-- HERO / BANNER SECTION --}}
        <div class="relative flex h-[50vh] min-h-100 w-full items-center justify-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/banner-kegiatan.png') }}" alt="Banner Kegiatan"
                    class="h-full w-full object-cover object-center opacity-40 blur-sm transition-transform duration-700 hover:scale-105" />
                <div class="absolute inset-0 bg-linear-to-t from-gray-950 via-gray-900/80 to-red-900/20"></div>
                <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
            </div>

            <div class="z-10 container mx-auto px-4 text-center">
                <span
                    class="mb-4 inline-block rounded-full border border-red-500/30 bg-red-900/30 px-4 py-1.5 text-sm font-medium text-red-400 backdrop-blur-md">
                    Agenda & Arsip
                </span>
                <h1 class="mb-4 text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Kegiatan
                    <span class="bg-linear-to-r from-red-500 to-orange-500 bg-clip-text text-transparent">
                        HMIF
                    </span>
                </h1>
                <p class="mx-auto max-w-2xl text-base text-gray-300 sm:text-lg">
                    Wadah pengembangan diri melalui seminar, workshop,
                    pelatihan, dan kegiatan sosial untuk memperkuat ekosistem
                    informatika.
                </p>
            </div>
        </div>

        <section class="relative py-12 lg:py-20">
            <div
                class="pointer-events-none absolute top-0 left-0 h-96 w-96 -translate-x-1/2 -translate-y-1/2 rounded-full bg-red-900/20 blur-[100px]">
            </div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-4 lg:gap-8">
                    {{-- SIDEBAR FILTER (Sticky) --}}
                    <div class="mb-8 lg:col-span-1 lg:mb-0">
                        <div class="space-y-6 lg:sticky lg:top-24">
                            <div class="relative">
                                <input type="text" x-model="search" placeholder="Cari nama kegiatan..."
                                    class="w-full rounded-xl border border-white/10 bg-white/5 py-3 pr-4 pl-10 text-sm text-white placeholder-gray-500 transition focus:border-red-500 focus:bg-gray-900 focus:ring-1 focus:ring-red-500 focus:outline-none" />
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm">
                                <h3
                                    class="mb-4 flex items-center gap-2 text-sm font-bold tracking-wider text-gray-400 uppercase">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Filter & Sort
                                </h3>

                                <div class="space-y-4">
                                    <div>
                                        <label for="sortByStatus"
                                            class="mb-1.5 block text-xs font-medium text-gray-400">
                                            Status Kegiatan
                                        </label>
                                        <div class="relative">
                                            <select x-model="status"
                                                class="w-full appearance-none rounded-lg border border-white/10 bg-gray-900 py-2.5 pr-8 pl-3 text-sm text-white focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none">
                                                <option value="all">
                                                    Semua Status
                                                </option>
                                                <option value="upcoming">
                                                    Mendatang
                                                </option>
                                                <option value="ongoing">
                                                    Sedang Berlangsung
                                                </option>
                                                <option value="completed">
                                                    Selesai
                                                </option>
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="filterByCategory"
                                            class="mb-1.5 block text-xs font-medium text-gray-400">
                                            Kategori
                                        </label>
                                        <div class="relative">
                                            <select x-model="category"
                                                class="w-full appearance-none rounded-lg border border-white/10 bg-gray-900 py-2.5 pr-8 pl-3 text-sm text-white focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none">
                                                <option value="all">
                                                    Semua Kategori
                                                </option>
                                                @foreach ($eventCategories as $category)
                                                    <option value="{{ $category->name }}">
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- EVENT LIST GRID --}}
                    <div class="lg:col-span-3">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
                            <template x-for="event in filteredEvents.slice(0, limit)" :key="event.slug">
                                <article
                                    class="group relative flex flex-col overflow-hidden rounded-2xl border border-white/10 bg-gray-900 transition-all hover:-translate-y-1 hover:border-red-500/50">
                                    <div class="relative h-48 w-full overflow-hidden">
                                        <img :src="event.image_url" :alt="event.title"
                                            class="h-full w-full object-cover group-hover:scale-110 transition duration-700">
                                        <div
                                            class="absolute top-3 left-3 bg-black/60 backdrop-blur rounded-lg px-3 py-1 text-center">
                                            <span class="text-xs font-bold text-red-500 block"
                                                x-text="event.day"></span>
                                            <span class="text-lg font-bold text-white" x-text="event.month"></span>
                                        </div>
                                    </div>
                                    <div class="p-5 flex-1 flex flex-col">
                                        <span x-html="getStatusBadge(event.status)"></span>
                                        <h3 class="mt-2 text-xl font-bold text-white group-hover:text-red-500 line-clamp-2"
                                            x-text="event.title"></h3>
                                        <p class="mt-3 text-sm text-gray-400 line-clamp-3" x-text="event.description">
                                        </p>
                                        <a :href="'/kegiatan/' + event.slug"
                                            class="mt-auto pt-4 text-sm font-medium text-white hover:text-red-400">Lihat
                                            Detail →</a>
                                    </div>
                                </article>
                            </template>

                            <div x-show="filteredEvents.length === 0" class="hidden py-20 text-center">
                                <div
                                    class="mb-4 inline-flex h-20 w-20 items-center justify-center rounded-full bg-white/5">
                                    <svg class="h-10 w-10 text-gray-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-white">
                                    Tidak ada kegiatan ditemukan
                                </h3>
                                <p class="mt-2 text-sm text-gray-400">
                                    Coba sesuaikan filter atau kata kunci pencarian
                                    Anda.
                                </p>
                            </div>
                        </div>
                        <div class="mt-12 text-center" x-show="limit < filteredEvents.length">
                            <button @click="limit += 6"
                                class="group relative inline-flex items-center gap-2 overflow-hidden rounded-full border border-red-500/50 bg-red-900/10 px-8 py-3 text-red-500 transition-all duration-300 hover:border-red-500 hover:bg-red-600 hover:text-white focus:ring-2 focus:ring-red-500 focus:outline-none">
                                <span class="text-sm font-bold tracking-wide">
                                    Muat Lebih Banyak
                                </span>
                                <svg class="h-4 w-4 transition-transform group-hover:translate-y-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
        </section>
    </div>

    @push('script')
        <script>
            function eventFilter(initialEvents) {
                return {
                    search: '',
                    status: 'all',
                    category: 'all',
                    limit: 6,
                    events: initialEvents.map(e => ({
                        ...e,
                        day: new Date(e.event_date).getDate(),
                        month: new Date(e.event_date).toLocaleString('id-ID', {
                            month: 'short'
                        }),
                        image_url: e.thumbnail_url
                    })),
                    get filteredEvents() {
                        return this.events.filter(e => {
                            const matchSearch = e.title.toLowerCase().includes(this.search.toLowerCase());
                            const matchStatus = this.status === 'all' || e.status === this.status;
                            const matchCategory = this.category === 'all' || (e.category && e.category.name === this
                                .category);

                            return matchSearch && matchStatus && matchCategory;
                        });
                    },
                    getStatusBadge(status) {
                        const badges = {
                            upcoming: {
                                label: 'Mendatang',
                                class: 'bg-blue-500/10 text-blue-400 border-blue-500/20'
                            },
                            ongoing: {
                                label: 'Sedang Berlangsung',
                                class: 'bg-green-500/10 text-green-400 border-green-500/20'
                            },
                            completed: {
                                label: 'Selesai',
                                class: 'bg-gray-500/10 text-gray-400 border-gray-500/20'
                            }
                        };
                        const badge = badges[status] || {
                            label: status,
                            class: 'bg-red-500/10 text-red-400 border-red-500/20'
                        };
                        return `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase border ${badge.class}">${badge.label}</span>`;
                    }
                }
            }
        </script>
    @endpush
    </x-app-layout>
