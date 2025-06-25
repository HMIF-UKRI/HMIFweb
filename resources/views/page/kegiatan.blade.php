@extends("layouts.app")

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
                        <div>
                            <label
                                for="SortBy"
                                class="mb-1 block text-xs font-medium text-gray-700"
                            >
                                Sort By
                            </label>
                            <div class="relative">
                                <select
                                    id="SortBy"
                                    class="text-secondary flex w-full cursor-pointer appearance-none items-center justify-between rounded border border-gray-300 p-4 text-sm focus:ring-2 focus:ring-red-200 focus:outline-none"
                                >
                                    <option value="mendatang" selected>
                                        Mendatang
                                    </option>
                                    <option value="terlaksana">
                                        Terlaksana
                                    </option>
                                    <option value="rutin">Rutin</option>
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

                        <div>
                            <p class="block text-xs font-medium text-gray-700">
                                Filters
                            </p>

                            <div class="relative">
                                <select
                                    id="SortBy"
                                    class="text-secondary flex w-full cursor-pointer appearance-none items-center justify-between rounded border border-gray-300 p-4 text-sm focus:ring-2 focus:ring-red-200 focus:outline-none"
                                >
                                    <option value="seminar" selected>
                                        Seminar
                                    </option>
                                    <option value="sorkshop">Workshop</option>
                                    <option value="sosial">Sosial</option>
                                    <option value="olahraga">Olahraga</option>
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
                            class="grid grid-cols-2 place-content-center gap-3"
                        >
                            @foreach ($events as $event)
                                <a
                                    href="{{ route("event.show", $event->slug) }}"
                                    class="group relative block rounded-tr-4xl rounded-bl-4xl bg-black"
                                >
                                    <img
                                        alt=""
                                        src="{{ asset("storage/" . $event->thumbnail_path) }}"
                                        class="absolute inset-0 h-full w-full rounded-tr-4xl rounded-bl-4xl object-cover opacity-75 transition-opacity group-hover:opacity-50"
                                    />

                                    <div class="relative p-4 sm:p-6 lg:p-8">
                                        <p
                                            class="text-sm font-medium tracking-widest text-amber-500/50 uppercase"
                                        >
                                            {{ $event->eventCategory->name }}
                                        </p>

                                        <p
                                            class="text-xl font-bold text-white sm:text-2xl"
                                        >
                                            {{ $event->title }}
                                        </p>

                                        <div class="mt-32 sm:mt-48 lg:mt-64">
                                            <div
                                                class="translate-y-8 transform opacity-0 transition-all group-hover:translate-y-0 group-hover:opacity-100"
                                            >
                                                <p class="text-sm text-white">
                                                    {{ \Illuminate\Support\Str::words($event->description, 30, "...") }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-8 text-center">
                            <button
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
@endsection
