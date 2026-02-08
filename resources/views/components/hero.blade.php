<section
    class="relative flex min-h-screen items-center overflow-hidden bg-linear-to-br from-gray-900 via-black to-red-950 pt-24 text-white md:pt-0">
    <div class="absolute inset-0 overflow-hidden opacity-20">
        <div class="absolute top-20 left-10 h-72 w-72 animate-pulse rounded-full bg-red-600 blur-3xl"></div>
        <div class="absolute right-10 bottom-20 h-96 w-96 animate-pulse rounded-full bg-red-800 blur-3xl"
            style="animation-delay: 1s"></div>
        <div class="absolute top-1/2 left-1/2 h-64 w-64 -translate-x-1/2 -translate-y-1/2 animate-pulse rounded-full bg-red-700 blur-3xl"
            style="animation-delay: 2s"></div>
    </div>

    <div class="absolute inset-0 opacity-10"
        style="
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(
                    90deg,
                    rgba(255, 255, 255, 0.05) 1px,
                    transparent 1px
                );
            background-size: 50px 50px;
        ">
    </div>

    <div class="relative z-10 container mx-auto px-4 py-0 md:py-24 2xl:py-0">
        <div class="flex flex-col items-center md:flex-row">
            <div class="font-jkt-sans mb-8 md:mb-0 md:w-1/2 md:pr-12">
                <div
                    class="mb-6 inline-flex items-center gap-2 rounded-full border border-red-500/30 bg-red-500/10 px-4 py-2 backdrop-blur-sm">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-500 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-red-500"></span>
                    </span>
                    <span class="text-sm font-medium uppercase text-red-400">
                        Kabinet {{ $activePeriod->cabinet_name }}
                    </span>
                </div>

                <h1 class="mb-6 text-4xl leading-tight font-bold tracking-tight lg:text-5xl xl:text-6xl">
                    <span class="bg-linear-to-r from-white via-gray-200 to-red-400 bg-clip-text text-transparent">
                        Himpunan Mahasiswa
                    </span>
                    <br />
                    <span class="text-red-500">Teknik Informatika</span>
                </h1>

                <p class="mb-8 text-lg leading-relaxed font-light text-gray-300">
                    Membangun ilmu keorganisasian yaitu, membangun jiwa korsa,
                    mentalitas, dan mengembangkan keahlian lainnya dalam ruang
                    lingkup Teknik Informatika.
                </p>

                <div class="flex gap-4 md:flex-wrap">
                    <a href="#about"
                        class="group relative inline-flex items-center gap-2 overflow-hidden rounded-lg bg-red-600 px-4 py-2 font-semibold text-white shadow-lg shadow-red-600/50 transition-all hover:bg-red-700 hover:shadow-xl hover:shadow-red-600/60 md:px-8 md:py-3">
                        <span>Tentang Kami</span>
                        <svg class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                    <a href="#activities"
                        class="inline-flex items-center gap-2 rounded-lg border-2 border-white/20 bg-white/5 px-4 py-2 font-semibold text-white backdrop-blur-sm transition-all hover:border-white/40 hover:bg-white/10 md:px-8 md:py-3">
                        <span>Lihat Kegiatan</span>
                    </a>
                </div>

                <div class="mt-12 grid grid-cols-3 gap-6 border-t border-white/10 pt-8">
                    <div>
                        <div class="text-3xl font-bold text-red-500">250+</div>
                        <div class="text-sm text-gray-400">Anggota Aktif</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-red-500">50+</div>
                        <div class="text-sm text-gray-400">Program</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-red-500">7+</div>
                        <div class="text-sm text-gray-400">Bidang</div>
                    </div>
                </div>
            </div>

            <!-- Visual Elements -->
            <div class="relative flex justify-center py-16 md:w-1/2">
                <!-- Main Card -->
                <div class="relative">
                    <!-- Floating Cards -->
                    <div class="relative h-96 w-80 lg:h-112 lg:w-96">
                        <!-- Card 1 - Main -->
                        <div
                            class="absolute inset-0 rounded-3xl bg-linear-to-br from-red-600 to-red-900 p-8 shadow-2xl shadow-red-900/50 backdrop-blur-sm">
                            <div class="flex h-full flex-col justify-between">
                                <div>
                                    <div class="mb-4 inline-block rounded-full bg-white/20 p-3 backdrop-blur-sm">
                                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <h3 class="mb-2 text-2xl font-bold">
                                        One Family One Goal
                                    </h3>
                                    <p class="text-sm text-white/80">
                                        Bersama membangun ekosistem kolaboratif
                                    </p>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                            </svg>
                                        </div>
                                        <span class="text-sm">Kolaborasi</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                            </svg>
                                        </div>
                                        <span class="text-sm">Inovasi</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <span class="text-sm">Prestasi</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2 - Floating -->
                        <div
                            class="animate-float absolute -top-6 -right-6 h-32 w-32 rounded-2xl bg-linear-to-br from-white to-gray-200 p-4 shadow-xl">
                            <div class="flex h-full flex-col items-center justify-center text-center">
                                <div class="text-3xl font-bold text-red-600">
                                    HMIF
                                </div>
                                <div class="text-xs font-medium text-gray-600">
                                    UKRI
                                </div>
                            </div>
                        </div>

                        <!-- Card 3 - Floating -->
                        <div class="animate-float absolute -bottom-14 -left-12 rounded-2xl bg-black/50 p-4 shadow-xl backdrop-blur-sm"
                            style="animation-delay: 1s">
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-600">
                                    <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                    </svg>
                                </div>
                                <div class="text-white">
                                    <div class="text-sm font-semibold">
                                        HMIF
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        Mahasiswa Teknik Informatika
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative Elements -->
                        <div
                            class="animate-spin-slow absolute top-1/2 -right-12 h-24 w-24 rounded-full border-4 border-dashed border-red-500/30">
                        </div>
                        <div
                            class="absolute top-1/3 -left-12 h-16 w-16 animate-pulse rounded-lg bg-white/10 backdrop-blur-sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <svg class="h-6 w-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
    </div>
</section>
