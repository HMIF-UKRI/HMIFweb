@extends("layouts.app")

@section("content")
    <body class="bg-white">
        <!-- Hero Section -->
        <section
            id="home"
            class="flex min-h-screen items-center bg-gradient-to-r from-gray-900 via-red-900 to-black pt-24 text-white md:pt-0"
        >
            <div class="container mx-auto px-4">
                <div class="flex flex-col items-center md:flex-row">
                    <div class="mb-8 md:mb-0 md:w-1/2">
                        <h1 class="mb-4 text-4xl font-bold md:text-6xl">
                            Himpunan Mahasiswa Teknik Informatika
                        </h1>
                        <p class="mb-8 text-lg md:text-xl">
                            Mewujudkan mahasiswa yang aktif, kreatif, dan
                            inovatif dalam mengembangkan potensi diri dan
                            memberikan kontribusi untuk masyarakat.
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
                    <div class="mx-auto h-1 w-24 bg-red-900"></div>
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
                                    Kabinet DIGISWARA
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
                                Himpunan Mahasiswa didirikan pada tahun 20XX
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
                                Menjadi organisasi kemahasiswaan yang unggul,
                                profesional, dan berkontribusi nyata bagi
                                kemajuan mahasiswa dan masyarakat.
                            </p>
                        </div>
                        <div>
                            <h3 class="mb-2 text-2xl font-bold text-white">
                                Misi
                            </h3>
                            <ul class="list-disc space-y-2 pl-6 text-gray-300">
                                <li>
                                    Mengembangkan potensi akademik dan
                                    non-akademik mahasiswa
                                </li>
                                <li>
                                    Membangun karakter kepemimpinan dan
                                    profesionalisme
                                </li>
                                <li>
                                    Meningkatkan solidaritas dan kerjasama antar
                                    mahasiswa
                                </li>
                                <li>
                                    Berperan aktif dalam kegiatan kemahasiswaan
                                    dan pengabdian masyarakat
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
                    <div class="mx-auto h-1 w-24 bg-red-900"></div>
                </div>
                <div
                    class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4"
                >
                    <!-- Ketua -->
                    <div
                        class="transform overflow-hidden rounded-xl bg-white text-black shadow-lg transition hover:-translate-y-2"
                    >
                        <img
                            src="/images/ketua.jpg"
                            alt="Ketua"
                            class="h-64 w-full object-contain"
                        />
                        <div class="p-4">
                            <h3 class="mb-1 text-xl font-bold">Acong</h3>
                            <p class="mb-2 font-semibold text-red-900">
                                Ketua Himpunan
                            </p>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit. Duis sed dapibus leo.
                            </p>
                        </div>
                    </div>
                    <!-- Wakil Ketua -->
                    <div
                        class="transform overflow-hidden rounded-xl bg-white text-black shadow-lg transition hover:-translate-y-2"
                    >
                        <img
                            src="/images/wakil.jpg"
                            alt="Wakil Ketua"
                            class="h-64 w-full object-contain"
                        />
                        <div class="p-4">
                            <h3 class="mb-1 text-xl font-bold">Ikhsan</h3>
                            <p class="mb-2 font-semibold text-red-900">
                                Wakil Ketua
                            </p>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit. Duis sed dapibus leo.
                            </p>
                        </div>
                    </div>
                    <!-- Sekretaris -->
                    <div
                        class="transform overflow-hidden rounded-xl bg-white text-black shadow-lg transition hover:-translate-y-2"
                    >
                        <img
                            src="/images/sekertaris.jpg"
                            alt="Sekretaris"
                            class="h-64 w-full object-contain"
                        />
                        <div class="p-4">
                            <h3 class="mb-1 text-xl font-bold">Tania</h3>
                            <p class="mb-2 font-semibold text-red-900">
                                Sekretaris
                            </p>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit. Duis sed dapibus leo.
                            </p>
                        </div>
                    </div>
                    <!-- Bendahara -->
                    <div
                        class="transform overflow-hidden rounded-xl bg-white text-black shadow-lg transition hover:-translate-y-2"
                    >
                        <img
                            src="/images/bendahara.jpg"
                            alt="Bendahara"
                            class="h-64 w-full object-contain"
                        />
                        <div class="p-4">
                            <h3 class="mb-1 text-xl font-bold">Simai</h3>
                            <p class="mb-2 font-semibold text-red-900">
                                Bendahara
                            </p>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit. Duis sed dapibus leo.
                            </p>
                        </div>
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
                    <div class="mx-auto h-1 w-24 bg-red-900"></div>
                </div>
                <div
                    class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3"
                >
                    <!-- Activity 1 -->
                    <div
                        class="border-opacity-10 overflow-hidden rounded-lg border border-black bg-white shadow-lg"
                    >
                        <img
                            src="/api/placeholder/400/320"
                            alt="Activity 1"
                            class="h-48 w-full object-cover"
                        />
                        <div class="p-6">
                            <h3 class="mb-2 text-xl font-bold text-black">
                                Seminar Nasional
                            </h3>
                            <p class="mb-4 text-black opacity-75">
                                Seminar tahunan dengan menghadirkan pembicara
                                dari berbagai bidang untuk memberikan wawasan
                                dan inspirasi kepada mahasiswa.
                            </p>
                            <div class="flex items-center justify-between">
                                <span
                                    class="rounded-full bg-red-900 px-3 py-1 text-sm text-white"
                                >
                                    Tahunan
                                </span>
                                <a
                                    href="#"
                                    class="font-semibold text-red-900 hover:underline"
                                >
                                    Detail →
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Activity 2 -->
                    <div
                        class="border-opacity-10 overflow-hidden rounded-lg border border-black bg-white shadow-lg"
                    >
                        <img
                            src="/api/placeholder/400/320"
                            alt="Activity 2"
                            class="h-48 w-full object-cover"
                        />
                        <div class="p-6">
                            <h3 class="mb-2 text-xl font-bold text-black">
                                Workshop Keterampilan
                            </h3>
                            <p class="mb-4 text-black opacity-75">
                                Seri workshop untuk meningkatkan keterampilan
                                praktis dan soft skill mahasiswa sesuai
                                kebutuhan dunia kerja.
                            </p>
                            <div class="flex items-center justify-between">
                                <span
                                    class="rounded-full bg-red-900 px-3 py-1 text-sm text-white"
                                >
                                    Bulanan
                                </span>
                                <a
                                    href="#"
                                    class="font-semibold text-red-900 hover:underline"
                                >
                                    Detail →
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Activity 3 -->
                    <div
                        class="border-opacity-10 overflow-hidden rounded-lg border border-black bg-white shadow-lg"
                    >
                        <img
                            src="/api/placeholder/400/320"
                            alt="Activity 3"
                            class="h-48 w-full object-cover"
                        />
                        <div class="p-6">
                            <h3 class="mb-2 text-xl font-bold text-black">
                                Bakti Sosial
                            </h3>
                            <p class="mb-4 text-black opacity-75">
                                Kegiatan pengabdian kepada masyarakat dalam
                                bentuk donasi, edukasi, dan bantuan sosial untuk
                                komunitas sekitar.
                            </p>
                            <div class="flex items-center justify-between">
                                <span
                                    class="rounded-full bg-red-900 px-3 py-1 text-sm text-white"
                                >
                                    Semester
                                </span>
                                <a
                                    href="#"
                                    class="font-semibold text-red-900 hover:underline"
                                >
                                    Detail →
                                </a>
                            </div>
                        </div>
                    </div>
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

        <!-- Gallery Section -->
        <section id="gallery" class="bg-black py-16 text-white">
            <div class="container mx-auto px-4">
                <div class="mb-12 text-center">
                    <h2 class="mb-2 text-3xl font-bold">Galeri Kegiatan</h2>
                    <div class="mx-auto h-1 w-24 bg-red-900"></div>
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
                        href="#"
                        class="hover:bg-opacity-90 inline-block rounded-lg bg-red-900 px-6 py-3 font-bold text-white transition"
                    >
                        Lihat Semua Foto
                    </a>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="bg-white py-16">
            <div class="container mx-auto px-4">
                <div class="mb-12 text-center">
                    <h2 class="mb-2 text-3xl font-bold text-black">
                        Hubungi Kami
                    </h2>
                    <div class="mx-auto h-1 w-24 bg-red-900"></div>
                </div>
                <div class="flex flex-col gap-8 md:flex-row">
                    <div class="rounded-lg bg-white p-6 shadow-lg md:w-1/2">
                        <h3 class="mb-4 text-2xl font-bold text-black">
                            Kirim Pesan
                        </h3>
                        <form>
                            <div class="mb-4">
                                <label
                                    for="name"
                                    class="mb-2 block font-medium text-black"
                                >
                                    Nama Lengkap
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-red-900 focus:outline-none"
                                />
                            </div>
                            <div class="mb-4">
                                <label
                                    for="email"
                                    class="mb-2 block font-medium text-black"
                                >
                                    Email
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-red-900 focus:outline-none"
                                />
                            </div>
                            <div class="mb-4">
                                <label
                                    for="subject"
                                    class="mb-2 block font-medium text-black"
                                >
                                    Subjek
                                </label>
                                <input
                                    type="text"
                                    id="subject"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-red-900 focus:outline-none"
                                />
                            </div>
                            <div class="mb-4">
                                <label
                                    for="message"
                                    class="mb-2 block font-medium text-black"
                                >
                                    Pesan
                                </label>
                                <textarea
                                    id="message"
                                    rows="5"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-red-900 focus:outline-none"
                                ></textarea>
                            </div>
                            <button
                                type="submit"
                                class="hover:bg-opacity-90 w-full rounded-lg bg-red-900 px-6 py-3 font-bold text-white transition"
                            >
                                Kirim Pesan
                            </button>
                        </form>
                    </div>
                    <div class="rounded-lg bg-white p-6 shadow-lg md:w-1/2">
                        <h3 class="mb-4 text-2xl font-bold text-black">
                            Informasi Kontak
                        </h3>
                        <div class="mb-4">
                            <h4 class="mb-1 font-bold text-black">Alamat</h4>
                            <p class="text-black opacity-75">
                                Jl. Contoh No. 123, Kota, Provinsi, Indonesia
                            </p>
                        </div>
                        <div class="mb-4">
                            <h4 class="mb-1 font-bold text-black">Email</h4>
                            <p class="text-black opacity-75">
                                info@himpunanmahasiswa.ac.id
                            </p>
                        </div>
                        <div class="mb-4">
                            <h4 class="mb-1 font-bold text-black">Telepon</h4>
                            <p class="text-black opacity-75">
                                +62 123 4567 890
                            </p>
                        </div>
                        <div class="mt-6">
                            <h4 class="mb-2 font-bold text-black">Lokasi</h4>
                            <div class="h-64 w-full rounded-lg bg-gray-200">
                                <!-- Map placeholder -->
                                <div
                                    class="flex h-full w-full items-center justify-center bg-gray-300 text-gray-500"
                                >
                                    Map Placeholder
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
@endsection
