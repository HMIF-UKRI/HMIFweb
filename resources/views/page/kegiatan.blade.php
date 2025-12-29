@extends("layouts.app")

@section("meta")
    @include(
        "components._meta",
        [
            "title" => "Kegiatan HMIF - HMIF UKRI",
            "description" =>
                "Agenda, dokumentasi, dan rangkaian kegiatan Himpunan Mahasiswa Informatika UKRI.",
            "keywords" =>
                "hmif, ukri, himatif, hima, informatika, kegiatan, agenda, seminar, workshop",
            "image" => asset("images/banner-kegiatan.png"),
            "url" => url()->current(),
        ]
    )
@endsection

@section("content")
    <div class="min-h-screen bg-gray-950 text-white">
        {{-- HERO / BANNER SECTION --}}
        <div
            class="relative flex h-[50vh] min-h-[400px] w-full items-center justify-center overflow-hidden"
        >
            <div class="absolute inset-0 z-0">
                <img
                    src="{{ asset("images/banner-kegiatan.png") }}"
                    alt="Banner Kegiatan"
                    class="h-full w-full object-cover object-center opacity-40 blur-sm transition-transform duration-700 hover:scale-105"
                />
                <div
                    class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-900/80 to-red-900/20"
                ></div>
                <div
                    class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"
                ></div>
            </div>

            <div class="z-10 container mx-auto px-4 text-center">
                <span
                    class="mb-4 inline-block rounded-full border border-red-500/30 bg-red-900/30 px-4 py-1.5 text-sm font-medium text-red-400 backdrop-blur-md"
                >
                    Agenda & Arsip
                </span>
                <h1
                    class="mb-4 text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl"
                >
                    Kegiatan
                    <span
                        class="bg-gradient-to-r from-red-500 to-orange-500 bg-clip-text text-transparent"
                    >
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
                class="pointer-events-none absolute top-0 left-0 h-96 w-96 -translate-x-1/2 -translate-y-1/2 rounded-full bg-red-900/20 blur-[100px]"
            ></div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-4 lg:gap-8">
                    {{-- SIDEBAR FILTER (Sticky) --}}
                    <div class="mb-8 lg:col-span-1 lg:mb-0">
                        <div class="space-y-6 lg:sticky lg:top-24">
                            <div class="relative">
                                <input
                                    type="text"
                                    id="searchEvent"
                                    placeholder="Cari nama kegiatan..."
                                    class="w-full rounded-xl border border-white/10 bg-white/5 py-3 pr-4 pl-10 text-sm text-white placeholder-gray-500 transition focus:border-red-500 focus:bg-gray-900 focus:ring-1 focus:ring-red-500 focus:outline-none"
                                />
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                                >
                                    <svg
                                        class="h-4 w-4 text-gray-500"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                        />
                                    </svg>
                                </div>
                            </div>

                            <div
                                class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm"
                            >
                                <h3
                                    class="mb-4 flex items-center gap-2 text-sm font-bold tracking-wider text-gray-400 uppercase"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
                                        />
                                    </svg>
                                    Filter & Sort
                                </h3>

                                <div class="space-y-4">
                                    <div>
                                        <label
                                            for="sortByStatus"
                                            class="mb-1.5 block text-xs font-medium text-gray-400"
                                        >
                                            Status Kegiatan
                                        </label>
                                        <div class="relative">
                                            <select
                                                id="sortByStatus"
                                                class="w-full appearance-none rounded-lg border border-white/10 bg-gray-900 py-2.5 pr-8 pl-3 text-sm text-white focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none"
                                            >
                                                <option value="all">
                                                    Semua Status
                                                </option>
                                                <option value="upcoming">
                                                    Mendatang
                                                </option>
                                                <option value="completed">
                                                    Terlaksana
                                                </option>
                                                <option value="routine">
                                                    Rutin
                                                </option>
                                                <option value="cancelled">
                                                    Dibatalkan
                                                </option>
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400"
                                            >
                                                <svg
                                                    class="h-4 w-4"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 9l-7 7-7-7"
                                                    />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            for="filterByCategory"
                                            class="mb-1.5 block text-xs font-medium text-gray-400"
                                        >
                                            Kategori
                                        </label>
                                        <div class="relative">
                                            <select
                                                id="filterByCategory"
                                                class="w-full appearance-none rounded-lg border border-white/10 bg-gray-900 py-2.5 pr-8 pl-3 text-sm text-white focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none"
                                            >
                                                <option value="all">
                                                    Semua Kategori
                                                </option>
                                                @foreach ($eventCategories as $category)
                                                    <option
                                                        value="{{ $category->name }}"
                                                    >
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400"
                                            >
                                                <svg
                                                    class="h-4 w-4"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 9l-7 7-7-7"
                                                    />
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
                        <div
                            id="events-list"
                            class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3"
                        >
                            {{-- Event cards will be injected here via JS --}}
                        </div>

                        <div class="mt-12 text-center">
                            <button
                                id="loadMoreBtn"
                                class="group relative inline-flex items-center gap-2 overflow-hidden rounded-full border border-red-500/50 bg-red-900/10 px-8 py-3 text-red-500 transition-all duration-300 hover:border-red-500 hover:bg-red-600 hover:text-white focus:ring-2 focus:ring-red-500 focus:outline-none"
                                style="display: none"
                            >
                                <span class="text-sm font-bold tracking-wide">
                                    Muat Lebih Banyak
                                </span>
                                <svg
                                    class="h-4 w-4 transition-transform group-hover:translate-y-1"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </button>
                        </div>

                        <div id="empty-state" class="hidden py-20 text-center">
                            <div
                                class="mb-4 inline-flex h-20 w-20 items-center justify-center rounded-full bg-white/5"
                            >
                                <svg
                                    class="h-10 w-10 text-gray-500"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
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
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Elements
            const searchInput = document.getElementById('searchEvent');
            const sortByStatus = document.getElementById('sortByStatus');
            const filterByCategory =
                document.getElementById('filterByCategory');
            const eventsList = document.getElementById('events-list');
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            const emptyState = document.getElementById('empty-state');

            // Data
            const initialEventsData = @json($events);
            let allEvents = [];
            let currentFilteredEvents = [];
            const eventsToShowInitially = 6;
            let eventsDisplayedCount = 0;

            // Helper: Format Date (ex: 2024-12-25 -> 25 Des 2024)
            function formatDate(dateString) {
                if (!dateString) return '';
                const options = {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                };
                return new Date(dateString).toLocaleDateString(
                    'id-ID',
                    options,
                );
            }

            // Helper: Get Status Color Badge
            function getStatusBadge(status) {
                const styles = {
                    upcoming: 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                    completed:
                        'bg-green-500/10 text-green-400 border-green-500/20',
                    routine:
                        'bg-purple-500/10 text-purple-400 border-purple-500/20',
                    cancelled: 'bg-red-500/10 text-red-400 border-red-500/20',
                };
                const labels = {
                    upcoming: 'Akan Datang',
                    completed: 'Selesai',
                    routine: 'Rutin',
                    cancelled: 'Batal',
                };

                const style =
                    styles[status] ||
                    'bg-gray-500/10 text-gray-400 border-gray-500/20';
                const label = labels[status] || status;

                return `<span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-medium ${style}">${label}</span>`;
            }

            // Helper: Strip HTML for description preview (Security)
            function stripHtml(html) {
                let tmp = document.createElement('DIV');
                tmp.innerHTML = html;
                return tmp.textContent || tmp.innerText || '';
            }

            function parseEventsFromBlade() {
                return initialEventsData.map((eventData) => {
                    return {
                        title: eventData.title,
                        slug: eventData.slug,
                        // Gunakan stripHtml untuk keamanan jika description mengandung HTML
                        description_preview:
                            stripHtml(eventData.description).substring(0, 100) +
                            '...',
                        thumbnail_path: eventData.thumbnail_path,
                        event_date: eventData.event_date,
                        formatted_date: formatDate(eventData.event_date),
                        status: eventData.status,
                        event_category_name:
                            eventData.event_category?.name || 'Umum',
                    };
                });
            }

            function displayEvents(eventsToRender) {
                eventsList.innerHTML = '';

                if (eventsToRender.length === 0) {
                    emptyState.classList.remove('hidden');
                    loadMoreBtn.style.display = 'none';
                    return;
                } else {
                    emptyState.classList.add('hidden');
                }

                const fragment = document.createDocumentFragment();

                eventsToRender.forEach((event) => {
                    const eventElement = document.createElement('article');
                    // Menggunakan flex-col h-full agar kartu memiliki tinggi seragam
                    eventElement.className =
                        'group relative flex flex-col overflow-hidden rounded-2xl border border-white/10 bg-gray-900 transition-all duration-300 hover:-translate-y-1 hover:border-red-500/50 hover:shadow-lg hover:shadow-red-900/20 h-full';

                    eventElement.innerHTML = `
                        <div class="relative h-48 w-full overflow-hidden">
                            <img
                                alt="${event.title}"
                                src="/storage/${event.thumbnail_path}"
                                loading="lazy"
                                class="h-full w-full object-cover transition duration-700 group-hover:scale-110"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-80"></div>

                            <div class="absolute top-3 left-3 flex flex-col items-center rounded-lg bg-black/60 backdrop-blur-sm border border-white/10 px-3 py-1.5 text-center shadow-lg">
                                <span class="text-xs font-bold text-red-500 uppercase">${new Date(event.event_date).toLocaleString('id-ID', { month: 'short' })}</span>
                                <span class="text-lg font-bold text-white leading-none">${new Date(event.event_date).getDate()}</span>
                            </div>

                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center rounded-full bg-red-600 px-2.5 py-0.5 text-xs font-semibold text-white shadow-lg">
                                    ${event.event_category_name}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col p-5">
                            <div class="mb-3">
                                ${getStatusBadge(event.status)}
                            </div>

                            <h3 class="mb-2 text-xl font-bold text-white transition-colors group-hover:text-red-500 line-clamp-2">
                                <a href="/event/${event.slug}">
                                    ${event.title}
                                </a>
                            </h3>

                            <p class="mb-4 flex-1 text-sm text-gray-400 line-clamp-3">
                                ${event.description_preview}
                            </p>

                            <div class="mt-auto border-t border-white/10 pt-4">
                                <a href="/event/${event.slug}" class="flex items-center gap-2 text-sm font-medium text-white transition hover:text-red-400">
                                    Lihat Detail
                                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    `;
                    fragment.appendChild(eventElement);
                });

                eventsList.appendChild(fragment);

                // Handle Load More Button Visibility
                if (eventsDisplayedCount < currentFilteredEvents.length) {
                    loadMoreBtn.style.display = 'inline-flex';
                } else {
                    loadMoreBtn.style.display = 'none';
                }
            }

            function filterAndSortEvents() {
                const searchQuery = searchInput.value.toLowerCase();
                const selectedStatus = sortByStatus.value;
                const selectedCategory = filterByCategory.value;

                let tempFilteredEvents = allEvents.filter((event) => {
                    const matchesSearch = event.title
                        .toLowerCase()
                        .includes(searchQuery);
                    const matchesStatus =
                        selectedStatus === 'all' ||
                        event.status === selectedStatus;
                    const matchesCategory =
                        selectedCategory === 'all' ||
                        String(event.event_category_name) === selectedCategory;

                    return matchesSearch && matchesStatus && matchesCategory;
                });

                // Sort logic (Priority: Status -> Date)
                tempFilteredEvents.sort((a, b) => {
                    const statusOrder = {
                        upcoming: 1,
                        routine: 2,
                        completed: 3,
                        cancelled: 4,
                    };

                    const statusA = statusOrder[a.status] || 99;
                    const statusB = statusOrder[b.status] || 99;

                    if (statusA !== statusB) return statusA - statusB;

                    // If status same, sort by date descending (newest first)
                    return new Date(b.event_date) - new Date(a.event_date);
                });

                currentFilteredEvents = tempFilteredEvents;

                // Reset display count when filter changes
                eventsDisplayedCount = Math.min(
                    eventsToShowInitially,
                    currentFilteredEvents.length,
                );
                displayEvents(
                    currentFilteredEvents.slice(0, eventsDisplayedCount),
                );
            }

            // Event Listeners
            loadMoreBtn.addEventListener('click', () => {
                const nextCount = Math.min(
                    eventsDisplayedCount + eventsToShowInitially,
                    currentFilteredEvents.length,
                );
                const nextEvents = currentFilteredEvents.slice(
                    eventsDisplayedCount,
                    nextCount,
                );

                // Append instead of rewrite to create smooth flow,
                // but displayEvents needs rewrite logic for append.
                // For simplicity here, we re-render slice.
                // Ideally, displayEvents should handle append.
                // Let's just increase the limit and re-render everything for simplicity in this snippet.
                eventsDisplayedCount = nextCount;
                displayEvents(
                    currentFilteredEvents.slice(0, eventsDisplayedCount),
                );
            });

            searchInput.addEventListener('input', filterAndSortEvents); // Realtime search
            sortByStatus.addEventListener('change', filterAndSortEvents);
            filterByCategory.addEventListener('change', filterAndSortEvents);

            // Initialize
            allEvents = parseEventsFromBlade();
            filterAndSortEvents();
        });
    </script>
@endsection
