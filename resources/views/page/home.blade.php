@extends("layouts.app")

@section("meta")
    @include(
        "components._meta",
        [
            "title" => "HMIF UKRI - Home",
            "description" =>
                "Selamat datang di website resmi Himpunan Mahasiswa Teknik Informatika UKRI. Temukan informasi terbaru tentang kegiatan, pengurus, dan visi misi kami.",
            "keywords" => "hmif,ukri,himatif,hima,informatika,teknik informatika",
            "url" => url()->current(),
        ]
    )
@endsection

@section("content")
    <div class="bg-white">
        <!-- Hero Section -->
        <section
            id="home"
            class="flex min-h-screen items-center bg-gradient-to-r from-gray-900 via-red-900 to-black pt-24 text-white md:pt-0"
        >
            <div class="container mx-auto px-4">
                <div class="flex flex-col items-center md:flex-row">
                    <div class="font-jkt-sans mb-8 md:mb-0 md:w-1/2">
                        <h1
                            class="mb-4 text-4xl font-bold tracking-wider lg:text-5xl xl:text-6xl"
                        >
                            Himpunan Mahasiswa Teknik Informatika
                        </h1>
                        <p class="mb-8 text-lg font-light">
                            Membangun ilmu keorganisasian yaitu, membangun jiwa
                            korsa, mentalitas, dan mengembangkan keahlian
                            lainnya dalam ruang lingkup Teknik Informatika.
                        </p>
                    </div>
                    <div class="flex justify-center md:w-1/2">
                        <img
                            src="{{ asset("images/banner2.png") }}"
                            alt="Hero Image"
                            width="20"
                            height="20"
                            class="-mt-24 w-full rounded-lg bg-cover bg-center object-cover shadow-lg"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- Divider Marquee -->
        <div class="relative w-full overflow-hidden bg-black py-4">
            <div class="animate-loop-scroll flex whitespace-nowrap">
                <div class="flex shrink-0 gap-8 px-4">
                    <span class="mx-8">
                        ✦ HIMPUNAN MAHASISWA TEKNIK INFORMATIKA ✦
                    </span>
                    <span class="mx-8">✦ ONE • FAMILY • ONE • GOAL ✦</span>
                    <span class="mx-8">✦ HMIF • HMIF • HMIF ✦</span>
                    <span class="mx-8">✦ 🔥 • 🔥 • 🔥 ✦</span>
                    <span class="mx-8">
                        ✦ HIMPUNAN MAHASISWA TEKNIK INFORMATIKA ✦
                    </span>
                    <span class="mx-8">✦ ONE • FAMILY • ONE • GOAL ✦</span>
                    <span class="mx-8">✦ HMIF • HMIF • HMIF ✦</span>
                    <span class="mx-8">✦ 🔥 • 🔥 • 🔥 ✦</span>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <section id="about" class="bg-black py-16">
            <div class="container mx-auto px-6 md:px-12">
                <div class="mb-12 text-center">
                    <h2 class="mb-2 text-3xl font-bold text-white">
                        Tentang Kita
                    </h2>
                    <div class="mx-auto h-1 w-24 rounded-full bg-red-900"></div>
                </div>
                <div
                    class="flex flex-col items-center md:flex-row md:items-start"
                >
                    <div class="mb-8 md:mb-0 md:w-1/2 md:pr-8">
                        <a href="#" class="block">
                            <img
                                alt=""
                                src="/images/banner.png"
                                class="h-56 w-full rounded-tr-3xl rounded-bl-3xl object-cover sm:h-64 lg:h-72"
                            />
                            <div
                                class="mt-4 sm:flex sm:items-center sm:justify-center sm:gap-4"
                            >
                                <strong class="font-medium">HIMF UKRI</strong>
                                <span
                                    class="hidden sm:block sm:h-px sm:w-8 sm:bg-yellow-500"
                                ></span>
                                <p class="mt-0.5 opacity-50 sm:mt-0">
                                    Kabinet METAFORSA
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="space-y-6 text-white md:w-1/2">
                        <div>
                            <h3 class="mb-2 text-2xl font-bold text-white">
                                Sejarah Kami
                            </h3>
                            <p class="leading-relaxed text-gray-300">
                                Himpunan Mahasiswa didirikan pada tahun 1986
                                dengan tujuan menjadi wadah bagi mahasiswa untuk
                                mengembangkan potensi, minat, dan bakat dalam
                                berbagai bidang.
                            </p>
                        </div>
                        <div>
                            <h3 class="mb-2 text-2xl font-bold text-white">
                                Visi
                            </h3>
                            <p class="leading-relaxed text-gray-300">
                                Mewujudkan HMIF sebagai ruang kolaborasi yang
                                mengintegrasikan ke informatikaan dengan
                                dinamika keorganisasian guna membangun ekosistem
                                intelektual yang transformatif dan inovatif.
                            </p>
                        </div>
                        <div>
                            <h3 class="mb-2 text-2xl font-bold text-white">
                                Misi
                            </h3>
                            <ul class="space-y-3">
                                <li class="flex text-base">
                                    <span class="mt-0.5 mr-2.5 text-red-500">
                                        <svg
                                            width="20"
                                            height="20"
                                            viewBox="0 0 20 20"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <g
                                                clip-path="url(#clip0_980_24852)"
                                            >
                                                <path
                                                    d="M10 0.5625C4.78125 0.5625 0.5625 4.78125 0.5625 10C0.5625 15.2188 4.78125 19.4688 10 19.4688C15.2188 19.4688 19.4688 15.2188 19.4688 10C19.4688 4.78125 15.2188 0.5625 10 0.5625ZM10 18.0625C5.5625 18.0625 1.96875 14.4375 1.96875 10C1.96875 5.5625 5.5625 1.96875 10 1.96875C14.4375 1.96875 18.0625 5.59375 18.0625 10.0312C18.0625 14.4375 14.4375 18.0625 10 18.0625Z"
                                                    fill="currentColor"
                                                />
                                                <path
                                                    d="M12.6875 7.09375L8.96875 10.7188L7.28125 9.0625C7 8.78125 6.5625 8.8125 6.28125 9.0625C6 9.34375 6.03125 9.78125 6.28125 10.0625L8.28125 12C8.46875 12.1875 8.71875 12.2813 8.96875 12.2813C9.21875 12.2813 9.46875 12.1875 9.65625 12L13.6875 8.125C13.9688 7.84375 13.9688 7.40625 13.6875 7.125C13.4063 6.84375 12.9688 6.84375 12.6875 7.09375Z"
                                                    fill="currentColor"
                                                />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_980_24852">
                                                    <rect
                                                        width="20"
                                                        height="20"
                                                        fill="white"
                                                    />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </span>
                                    Membangun Kerja sama diberbagai Lembaga
                                    terkhususnya diranah informatika untuk
                                    memperkuat peran HMIF sebagai wadah
                                    pengembangan akademik dan softskill.
                                </li>
                                <li class="flex text-base">
                                    <span class="mt-0.5 mr-2.5 text-red-500">
                                        <svg
                                            width="20"
                                            height="20"
                                            viewBox="0 0 20 20"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <g
                                                clip-path="url(#clip0_980_24852)"
                                            >
                                                <path
                                                    d="M10 0.5625C4.78125 0.5625 0.5625 4.78125 0.5625 10C0.5625 15.2188 4.78125 19.4688 10 19.4688C15.2188 19.4688 19.4688 15.2188 19.4688 10C19.4688 4.78125 15.2188 0.5625 10 0.5625ZM10 18.0625C5.5625 18.0625 1.96875 14.4375 1.96875 10C1.96875 5.5625 5.5625 1.96875 10 1.96875C14.4375 1.96875 18.0625 5.59375 18.0625 10.0312C18.0625 14.4375 14.4375 18.0625 10 18.0625Z"
                                                    fill="currentColor"
                                                />
                                                <path
                                                    d="M12.6875 7.09375L8.96875 10.7188L7.28125 9.0625C7 8.78125 6.5625 8.8125 6.28125 9.0625C6 9.34375 6.03125 9.78125 6.28125 10.0625L8.28125 12C8.46875 12.1875 8.71875 12.2813 8.96875 12.2813C9.21875 12.2813 9.46875 12.1875 9.65625 12L13.6875 8.125C13.9688 7.84375 13.9688 7.40625 13.6875 7.125C13.4063 6.84375 12.9688 6.84375 12.6875 7.09375Z"
                                                    fill="currentColor"
                                                />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_980_24852">
                                                    <rect
                                                        width="20"
                                                        height="20"
                                                        fill="white"
                                                    />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </span>
                                    Mengembangkan budaya organisasi HMIF yang
                                    kritis dan kreatif dilandaskan dengan
                                    nilai-nilai yang afektif, empatik dan
                                    profesional.
                                </li>
                                <li class="flex text-base">
                                    <span class="mt-0.5 mr-2.5 text-red-500">
                                        <svg
                                            width="20"
                                            height="20"
                                            viewBox="0 0 20 20"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <g
                                                clip-path="url(#clip0_980_24852)"
                                            >
                                                <path
                                                    d="M10 0.5625C4.78125 0.5625 0.5625 4.78125 0.5625 10C0.5625 15.2188 4.78125 19.4688 10 19.4688C15.2188 19.4688 19.4688 15.2188 19.4688 10C19.4688 4.78125 15.2188 0.5625 10 0.5625ZM10 18.0625C5.5625 18.0625 1.96875 14.4375 1.96875 10C1.96875 5.5625 5.5625 1.96875 10 1.96875C14.4375 1.96875 18.0625 5.59375 18.0625 10.0312C18.0625 14.4375 14.4375 18.0625 10 18.0625Z"
                                                    fill="currentColor"
                                                />
                                                <path
                                                    d="M12.6875 7.09375L8.96875 10.7188L7.28125 9.0625C7 8.78125 6.5625 8.8125 6.28125 9.0625C6 9.34375 6.03125 9.78125 6.28125 10.0625L8.28125 12C8.46875 12.1875 8.71875 12.2813 8.96875 12.2813C9.21875 12.2813 9.46875 12.1875 9.65625 12L13.6875 8.125C13.9688 7.84375 13.9688 7.40625 13.6875 7.125C13.4063 6.84375 12.9688 6.84375 12.6875 7.09375Z"
                                                    fill="currentColor"
                                                />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_980_24852">
                                                    <rect
                                                        width="20"
                                                        height="20"
                                                        fill="white"
                                                    />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </span>
                                    Menjadikan HMIF sebagai ruang aspirasi
                                    sekaligus etalase prestasi bagi seluruh
                                    elemen di prodi teknik informatika.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Board Section -->
        <section id="board" class="bg-black py-16 text-white">
            <div class="container mx-auto px-4">
                <div class="mb-12 text-center">
                    <h2 class="mb-2 text-3xl font-bold">Struktur Pengurus</h2>
                    <div class="mx-auto h-1 w-24 rounded-full bg-red-900"></div>
                </div>
                <div
                    class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4"
                >
                    <!-- Ketua -->
                    @forelse ($members as $member)
                        <div
                            class="transform overflow-hidden rounded-xl bg-white text-black shadow-xl shadow-red-600 transition hover:-translate-y-2"
                        >
                            <img
                                src="{{ asset("storage/" . $member->image) }}"
                                alt="Ketua"
                                class="h-64 w-full rounded-t-xl bg-cover bg-center object-cover"
                            />
                            <div class="p-4">
                                <h3 class="mb-1 text-xl font-bold">
                                    {{ $member->name }}
                                </h3>
                                <p class="mb-2 font-semibold text-red-900">
                                    {{ $member->position }}
                                </p>
                            </div>
                        </div>
                    @empty
                        
                    @endforelse
                </div>
                <div class="mt-8 text-center">
                    <a
                        class="group relative inline-flex items-center overflow-hidden rounded-lg border-2 border-current px-8 py-3 text-red-500 transition-colors duration-300 hover:text-white focus:ring-3 focus:outline-none"
                        href="/struktur-pengurus"
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
                            Lihat Semua Pengurus
                        </span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Activities Section -->
        <section id="activities" class="bg-white py-16">
            <div class="container mx-auto px-4">
                <div class="mb-12 text-center">
                    <h2 class="mb-2 text-3xl font-bold text-black">
                        Program Kegiatan
                    </h2>
                    <div class="mx-auto h-1 w-24 rounded-full bg-red-900"></div>
                </div>
                <div
                    class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3"
                >
                    @foreach ($events as $event)
                        <div
                            class="border-opacity-10 overflow-hidden rounded-lg border border-black bg-white shadow-lg"
                        >
                            <img
                                src="{{ asset("storage/" . $event->thumbnail_path) }}"
                                alt="{{ $event->title }}"
                                class="h-48 w-full bg-cover bg-center object-cover"
                            />
                            <div class="p-6">
                                <h3 class="mb-2 text-xl font-bold text-black">
                                    {{ $event->title }}
                                </h3>
                                <p class="mb-4 text-black opacity-75">
                                    {{ $event->short_description }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="rounded-full bg-red-900 px-3 py-1 text-sm text-white"
                                    >
                                        {{ $event->eventCategory->name }}
                                    </span>
                                    <a
                                        href="{{ route("event.show", $event->slug) }}"
                                        class="font-semibold text-red-900 hover:underline"
                                    >
                                        Detail →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8 text-center">
                    <a
                        class="group relative inline-flex items-center overflow-hidden rounded-lg border-2 border-current bg-red-900 px-8 py-3 text-white transition-colors duration-300 hover:text-red-500 focus:ring-3 focus:outline-none"
                        href="/kegiatan"
                    >
                        <span
                            class="absolute top-0 left-0 z-0 h-full w-0 bg-white transition-all duration-300 group-hover:w-full"
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
                            Lihat Semua Kegiatan
                        </span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Gallery Section (COOMING SOON) -->
        {{--
            <section id="gallery" class="bg-black py-16 text-white">
            <div class="container mx-auto px-4">
            <div class="mb-12 text-center">
            <h2 class="mb-2 text-3xl font-bold">Galeri Kegiatan</h2>
            <div class="mx-auto h-1 w-24 rounded-full bg-red-900"></div>
            </div>
            <div
            class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4"
            >
            <div class="overflow-hidden rounded-lg">
            <img
            src="/api/placeholder/400/320"
            alt="Gallery 1"
            class="h-48 w-full transform object-cover transition hover:scale-110"
            />
            </div>
            <div class="overflow-hidden rounded-lg">
            <img
            src="/api/placeholder/400/320"
            alt="Gallery 2"
            class="h-48 w-full transform object-cover transition hover:scale-110"
            />
            </div>
            <div class="overflow-hidden rounded-lg">
            <img
            src="/api/placeholder/400/320"
            alt="Gallery 3"
            class="h-48 w-full transform object-cover transition hover:scale-110"
            />
            </div>
            <div class="overflow-hidden rounded-lg">
            <img
            src="/api/placeholder/400/320"
            alt="Gallery 4"
            class="h-48 w-full transform object-cover transition hover:scale-110"
            />
            </div>
            <div class="overflow-hidden rounded-lg">
            <img
            src="/api/placeholder/400/320"
            alt="Gallery 5"
            class="h-48 w-full transform object-cover transition hover:scale-110"
            />
            </div>
            <div class="overflow-hidden rounded-lg">
            <img
            src="/api/placeholder/400/320"
            alt="Gallery 6"
            class="h-48 w-full transform object-cover transition hover:scale-110"
            />
            </div>
            <div class="overflow-hidden rounded-lg">
            <img
            src="/api/placeholder/400/320"
            alt="Gallery 7"
            class="h-48 w-full transform object-cover transition hover:scale-110"
            />
            </div>
            <div class="overflow-hidden rounded-lg">
            <img
            src="/api/placeholder/400/320"
            alt="Gallery 8"
            class="h-48 w-full transform object-cover transition hover:scale-110"
            />
            </div>
            </div>
            <div class="mt-8 text-center">
            <a
            class="group relative inline-flex items-center overflow-hidden rounded-lg border-2 border-current px-8 py-3 text-red-500 transition-colors duration-300 hover:text-white focus:ring-3 focus:outline-none"
            href="/struktur-pengurus"
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
            Lihat Semua Galeri
            </span>
            </a>
            </div>
            </div>
            </section>
        --}}
    </div>
@endsection
