@extends("layouts.app")

@section("meta")
    @include(
        "components._meta",
        [
            "title" => "Kegiatan HMIF - HMIF UKRI",
            "description" =>
                "Agenda, dokumentasi, dan rangkaian kegiatan Himpunan Mahasiswa Informatika UKRI. Temukan seminar, workshop, pelatihan, dan acara sosial untuk memperkuat komunitas dan meningkatkan keterampilan anggota.",
            "keywords" =>
                "hmif, ukri, himatif, hima, informatika, kegiatan, agenda, seminar, workshop, pelatihan, sosial",
            "image" => asset("images/banner-kegiatan.png"),
            "url" => url()->current(),
        ]
    )
@endsection

@section("content")
    <div class="bg-white">
        {{-- BANNER --}}
        <div class="flex min-h-screen w-full items-center justify-center">
            <img
                src="{{ asset("images/banner-kegiatan.png") }}"
                alt="Banner Kegiatan"
                class="absolute inset-0 z-0 h-full w-full object-cover shadow-2xl shadow-red-500/50 drop-shadow-2xl"
            />
            <div class="z-10 flex h-full w-full items-center justify-center">
                <div class="w-3xl text-center text-white">
                    <div class="flex items-center">
                        <span
                            class="h-px flex-1 bg-gradient-to-r from-transparent to-gray-300"
                        ></span>

                        <span
                            class="shrink-0 bg-gradient-to-r from-red-100 to-red-600/80 bg-clip-text px-4 text-4xl font-bold tracking-wider text-transparent uppercase"
                        >
                            Kegiatan HMIF
                        </span>

                        <span
                            class="h-px flex-1 bg-gradient-to-l from-transparent to-gray-300"
                        ></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ====== Blog Section Start -->
        <section>
            <div
                class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8"
            >
                <header class="-mx-4 flex flex-wrap justify-center pt-20">
                    <div class="w-full px-4">
                        <div
                            class="mx-auto mb-[60px] max-w-[510px] text-center lg:mb-20"
                        >
                            <h2
                                class="text-secondary mb-4 text-3xl font-bold sm:text-4xl md:text-[40px]"
                            >
                                Agenda & Dokumentasi Kegiatan HMIF
                            </h2>
                            <p
                                class="text-secondary text-xs leading-relaxed sm:text-sm md:text-base"
                            >
                                serangkaian acara yang diselenggarakan oleh
                                Himpunan Mahasiswa Informatika untuk
                                meningkatkan keterlibatan, pengetahuan, dan
                                keterampilan anggota dalam bidang informatika.
                                Kegiatan ini mencakup seminar, workshop,
                                pelatihan, dan acara sosial yang bertujuan untuk
                                memperkuat komunitas dan memfasilitasi
                                pertukaran ide di antara mahasiswa.
                            </p>
                        </div>
                    </div>
                </header>

                <div class="mt-8 block lg:hidden">
                    <button
                        class="flex cursor-pointer items-center gap-2 border-b border-gray-400 pb-1 text-gray-900 transition hover:border-gray-600"
                    >
                        <span class="text-sm font-medium">
                            Filters & Sorting
                        </span>

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="size-4 rtl:rotate-180"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 4.5l7.5 7.5-7.5 7.5"
                            />
                        </svg>
                    </button>
                </div>

                <div
                    class="mt-4 lg:mt-8 lg:grid lg:grid-cols-4 lg:items-start lg:gap-8"
                >
                    <div class="hidden space-y-4 lg:sticky lg:top-32 lg:block">
                        {{-- Dropdown untuk Sorting --}}
                        <div>
                            <label
                                for="sortByStatus"
                                class="mb-1 block text-xs font-medium text-gray-700"
                            >
                                Urutkan Berdasarkan Status
                            </label>
                            <div class="relative">
                                <select
                                    id="sortByStatus"
                                    class="text-secondary flex w-full cursor-pointer appearance-none items-center justify-between rounded border border-gray-300 p-4 text-sm focus:ring-2 focus:ring-red-200 focus:outline-none"
                                >
                                    <option value="all" selected>
                                        Semua Status
                                    </option>
                                    <option value="upcoming">Mendatang</option>
                                    <option value="completed">
                                        Terlaksana
                                    </option>
                                    <option value="routine">Rutin</option>
                                    <option value="cancelled">
                                        Dibatalkan
                                    </option>
                                </select>
                                <span
                                    class="pointer-events-none absolute inset-y-0 right-4 flex items-center"
                                >
                                    <svg
                                        class="h-4 w-4 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M19 9l-7 7-7-7"
                                        />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        {{-- Dropdown untuk Filtering Kategori --}}
                        <div>
                            <p class="block text-xs font-medium text-gray-700">
                                Filter Berdasarkan Kategori
                            </p>

                            <div class="relative">
                                <select
                                    id="filterByCategory"
                                    class="text-secondary flex w-full cursor-pointer appearance-none items-center justify-between rounded border border-gray-300 p-4 text-sm focus:ring-2 focus:ring-red-200 focus:outline-none"
                                >
                                    <option value="all" selected>
                                        Semua Kategori
                                    </option>
                                    {{-- Loop untuk menampilkan kategori dari database --}}
                                    @foreach ($eventCategories as $category)
                                        <option value="{{ $category->name }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span
                                    class="pointer-events-none absolute inset-y-0 right-4 flex items-center"
                                >
                                    <svg
                                        class="h-4 w-4 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M19 9l-7 7-7-7"
                                        />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-3">
                        <div
                            id="events-list"
                            class="grid grid-cols-2 place-content-center gap-3"
                        >
                            {{-- Event items will be rendered here by JavaScript --}}
                        </div>
                        <div class="mt-8 text-center">
                            <button
                                id="loadMoreBtn"
                                {{-- Add an ID to the button --}}
                                class="group relative inline-flex cursor-pointer items-center overflow-hidden rounded-lg border-2 border-current px-8 py-3 text-red-500 transition-colors duration-300 hover:text-white focus:ring-3 focus:outline-none"
                            >
                                <span
                                    class="absolute top-0 left-0 z-0 h-full w-0 bg-red-900 transition-all duration-300 group-hover:w-full"
                                ></span>
                                <span
                                    class="absolute -end-full transition-all group-hover:end-4"
                                >
                                    <svg
                                        class="size-5 shadow-sm rtl:rotate-180"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3"
                                        />
                                    </svg>
                                </span>

                                <span
                                    class="z-10 text-sm font-medium transition-all group-hover:me-4"
                                >
                                    Lihat Lebih Banyak Kegiatan
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== Blog Section End -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sortByStatus = document.getElementById('sortByStatus');
            const filterByCategory =
                document.getElementById('filterByCategory');
            const eventsList = document.getElementById('events-list');
            const loadMoreBtn = document.getElementById('loadMoreBtn');

            const initialEventsData = @json($events);

            let allEvents = [];
            let currentFilteredEvents = [];
            const eventsToShowInitially = 6;
            let eventsDisplayedCount = 0;

            function parseEventsFromBlade() {
                return initialEventsData.map((eventData) => {
                    return {
                        title: eventData.title,
                        slug: eventData.slug,
                        short_description: eventData.short_description,
                        description: eventData.description,
                        thumbnail_path: eventData.thumbnail_path,
                        event_date: eventData.event_date,
                        location: eventData.location,
                        status: eventData.status,
                        event_categories_id: eventData.event_categories_id,
                        event_category_name: eventData.event_category.name,
                    };
                });
            }

            function displayEvents(eventsToRender) {
                eventsList.innerHTML = '';
                const fragment = document.createDocumentFragment();

                for (let i = 0; i < eventsToRender.length; i++) {
                    const event = eventsToRender[i];
                    const eventElement = document.createElement('a');
                    eventElement.href = `/event/${event.slug}`;
                    eventElement.className =
                        'group event-item relative block rounded-tr-4xl rounded-bl-4xl bg-black';
                    eventElement.setAttribute('data-status', event.status);
                    eventElement.setAttribute(
                        'data-category-id',
                        event.event_categories_id,
                    );
                    eventElement.setAttribute(
                        'data-event-date',
                        event.event_date,
                    );

                    eventElement.innerHTML = `
                        <img
                            alt="${event.title}"
                            src="/storage/${event.thumbnail_path}"
                            class="absolute inset-0 h-full w-full rounded-tr-4xl rounded-bl-4xl object-cover opacity-75 transition-opacity group-hover:opacity-50"
                        />
                        <div class="relative p-4 sm:p-6 lg:p-8">
                            <p class="text-sm font-medium tracking-widest text-amber-500/50 uppercase">
                                ${event.event_category_name}
                            </p>
                            <p class="text-xl font-bold text-white sm:text-2xl">
                                ${event.title}
                            </p>
                            <div class="mt-32 sm:mt-48 lg:mt-64">
                                <div class="translate-y-8 transform opacity-0 transition-all group-hover:translate-y-0 group-hover:opacity-100">
                                    <p class="text-sm text-white">
                                        ${event.description.substring(0, 150)}...
                                    </p>
                                </div>
                            </div>
                        </div>
                    `;
                    fragment.appendChild(eventElement);
                }
                eventsList.appendChild(fragment);

                if (eventsDisplayedCount < currentFilteredEvents.length) {
                    loadMoreBtn.style.display = 'inline-flex'; // Show button
                } else {
                    loadMoreBtn.style.display = 'none';
                }

                if (eventsToRender.length === 0) {
                    eventsList.innerHTML =
                        '<p class="text-center text-gray-500 col-span-full">Tidak ada kegiatan yang ditemukan.</p>';
                    loadMoreBtn.style.display = 'none';
                }
            }

            function filterAndSortEvents() {
                const selectedStatus = sortByStatus.value;
                const selectedCategory = filterByCategory.value;

                let tempFilteredEvents = allEvents.filter((event) => {
                    const matchesStatus =
                        selectedStatus === 'all' ||
                        event.status === selectedStatus;
                    const matchesCategory =
                        selectedCategory === 'all' ||
                        String(event.event_category_name) === selectedCategory;
                    return matchesStatus && matchesCategory;
                });

                tempFilteredEvents.sort((a, b) => {
                    const statusOrder = {
                        upcoming: 1,
                        routine: 2,
                        completed: 3,
                        cancelled: 4,
                    };

                    const statusA = statusOrder[a.status];
                    const statusB = statusOrder[b.status];

                    if (statusA !== statusB) {
                        return statusA - statusB;
                    }

                    const dateA = new Date(a.event_date);
                    const dateB = new Date(b.event_date);

                    if (isNaN(dateA.getTime()) || isNaN(dateB.getTime())) {
                        return 0;
                    }

                    return dateB.getTime() - dateA.getTime();
                });

                currentFilteredEvents = tempFilteredEvents;
                eventsDisplayedCount = Math.min(
                    eventsToShowInitially,
                    currentFilteredEvents.length,
                );
                displayEvents(
                    currentFilteredEvents.slice(0, eventsDisplayedCount),
                );
            }

            loadMoreBtn.addEventListener('click', () => {
                eventsDisplayedCount = currentFilteredEvents.length;
                displayEvents(currentFilteredEvents);
            });

            sortByStatus.addEventListener('change', filterAndSortEvents);

            filterByCategory.addEventListener('change', filterAndSortEvents);

            allEvents = parseEventsFromBlade();
            filterAndSortEvents();
        });
    </script>
@endsection
