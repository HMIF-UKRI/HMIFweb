<nav x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
    :class="scrolled ? 'bg-black/80 backdrop-blur-md shadow-lg shadow-red-900/10' : 'bg-transparent backdrop-blur-sm'"
    class="fixed top-0 z-9999 w-full border-b border-white/5 transition-all duration-300">
    <div class="container mx-auto px-4 md:px-6">
        <div class="flex h-20 items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="/" class="group flex items-center gap-3">
                    <div class="relative">
                        <div
                            class="absolute -inset-2 rounded-full bg-red-600/20 opacity-0 blur-lg transition duration-500 group-hover:opacity-100">
                        </div>
                        <img src="{{ asset('images/logo.png') }}" alt="HMIF logo" width="40" height="40"
                            class="relative h-12 w-12 object-contain" />
                    </div>

                    <div class="hidden flex-col font-sans lg:flex">
                        <h3 class="text-xs font-bold tracking-wider text-white">
                            Himpunan Mahasiswa
                            <span
                                class="bg-linear-to-r from-red-500 to-red-400 bg-clip-text font-extrabold text-transparent">
                                Teknik Informatika
                            </span>
                        </h3>
                        <h3 class="text-[10px] font-medium tracking-wide text-gray-400">
                            Universitas Kebangsaan Republik Indonesia
                        </h3>
                    </div>
                    <div class="lg:hidden">
                        <span class="text-lg font-bold tracking-wide text-white">
                            HMIF
                            <span class="text-red-500">UKRI</span>
                        </span>
                    </div>
                </a>
            </div>

            <div class="hidden md:flex md:items-center md:space-x-8">
                <a href="/" class="group relative text-sm font-medium text-gray-300 transition hover:text-white">
                    Beranda
                    <span
                        class="absolute -bottom-1 left-1/2 h-1 w-1 -translate-x-1/2 rounded-full bg-red-600 opacity-0 transition-all duration-300 group-hover:opacity-100"></span>
                </a>

                <a href="#about" class="group relative text-sm font-medium text-gray-300 transition hover:text-white">
                    Tentang Kami
                    <span
                        class="absolute -bottom-1 left-1/2 h-1 w-1 -translate-x-1/2 rounded-full bg-red-600 opacity-0 transition-all duration-300 group-hover:opacity-100"></span>
                </a>

                <a href="{{ route('aspirasi') }}"
                    class="group relative text-sm font-medium text-gray-300 transition hover:text-white">
                    Kotak Aspirasi
                    <span
                        class="absolute -bottom-1 left-1/2 h-1 w-1 -translate-x-1/2 rounded-full bg-red-600 opacity-0 transition-all duration-300 group-hover:opacity-100"></span>
                </a>

                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @mouseenter="dropdownOpen = true" @mouseleave="dropdownOpen = false"
                        class="flex items-center gap-1 text-sm font-medium text-gray-300 transition hover:text-white focus:outline-none"
                        :class="{ 'text-white': dropdownOpen }">
                        <span>Profil</span>
                        <svg class="h-4 w-4 transition-transform duration-300"
                            :class="{ 'rotate-180 text-red-500': dropdownOpen }" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="dropdownOpen" @mouseenter="dropdownOpen = true" @mouseleave="dropdownOpen = false"
                        x-transition:enter="transition duration-200 ease-out"
                        x-transition:enter-start="translate-y-2 opacity-0"
                        x-transition:enter-end="translate-y-0 opacity-100"
                        x-transition:leave="transition duration-150 ease-in"
                        x-transition:leave-start="translate-y-0 opacity-100"
                        x-transition:leave-end="translate-y-2 opacity-0"
                        class="ring-opacity-5 absolute top-full right-0 mt-2 w-56 origin-top-right rounded-xl border border-white/10 bg-gray-900/95 p-2 shadow-xl ring-1 ring-black backdrop-blur-xl"
                        style="display: none">
                        <div class="space-y-1">
                            <a href="{{ route('event.index') }}"
                                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-gray-300 transition hover:bg-white/5 hover:text-red-400">
                                <i class="fa-solid fa-calendar-day w-5 text-center text-xs opacity-70"></i>
                                Kegiatan
                            </a>
                            <a href="{{ route('struktur-pengurus') }}"
                                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-gray-300 transition hover:bg-white/5 hover:text-red-400">
                                <i class="fa-solid fa-users w-5 text-center text-xs opacity-70"></i>
                                Struktur Pengurus
                            </a>
                            <a href="{{ route('blog.index') }}"
                                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-gray-300 transition hover:bg-white/5 hover:text-red-400">
                                <i class="fa-solid fa-newspaper w-5 text-center text-xs opacity-70"></i>
                                Blog
                            </a>
                            <a href="{{ route('coming-soon') }}"
                                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-gray-300 transition hover:bg-white/5 hover:text-red-400">
                                <i class="fa-solid fa-images w-5 text-center text-xs opacity-70"></i>
                                Galeri
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="relative z-50 flex h-10 w-10 items-center justify-center rounded-lg text-gray-300 transition hover:bg-white/10 hover:text-white focus:outline-none">
                    <span class="sr-only">Toggle menu</span>

                    <div class="relative flex h-5 w-6 flex-col justify-between">
                        <span
                            class="h-0.5 w-full transform rounded-full bg-current transition-all duration-300 ease-in-out"
                            :class="mobileMenuOpen ? 'translate-y-2.25 rotate-45' : 'origin-center'"></span>

                        <span
                            class="h-0.5 w-full transform rounded-full bg-current transition-all duration-300 ease-in-out"
                            :class="mobileMenuOpen ? 'opacity-0' : 'opacity-100'"></span>

                        <span
                            class="h-0.5 w-full transform rounded-full bg-current transition-all duration-300 ease-in-out"
                            :class="mobileMenuOpen ? '-translate-y-2.25 -rotate-45' : 'origin-center'"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileMenuOpen" x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="-translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="-translate-y-full opacity-0"
        class="fixed inset-0 z-40 flex flex-col bg-gray-950/95 backdrop-blur-xl md:hidden" style="display: none">
        <div class="flex flex-col space-y-2 bg-black/80 px-6 pt-24 pb-6">
            <a href="/"
                class="flex items-center rounded-xl border border-white/5 bg-white/5 px-4 py-4 text-base font-medium text-white transition hover:border-red-500/30 hover:bg-red-900/20 hover:text-red-400">
                Beranda
            </a>
            <a href="#about"
                class="flex items-center rounded-xl border border-white/5 bg-white/5 px-4 py-4 text-base font-medium text-white transition hover:border-red-500/30 hover:bg-red-900/20 hover:text-red-400">
                Tentang Kami
            </a>

            <a href="{{ route('aspirasi') }}"
                class="flex items-center rounded-xl border border-white/5 bg-white/5 px-4 py-4 text-base font-medium text-white transition hover:border-red-500/30 hover:bg-red-900/20 hover:text-red-400">
                Kotak Aspirasi
            </a>

            <div x-data="{ dropdownOpen: false }" class="overflow-hidden rounded-xl border border-white/5 bg-white/5">
                <button @click="dropdownOpen = !dropdownOpen"
                    class="flex w-full items-center justify-between px-4 py-4 text-base font-medium text-white transition hover:bg-white/5 focus:outline-none">
                    <span>Profil</span>
                    <svg class="h-5 w-5 transform transition-transform duration-300"
                        :class="{ 'rotate-180 text-red-500': dropdownOpen }" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="dropdownOpen" class="border-t border-white/5 bg-black/20">
                    <a href="/kegiatan"
                        class="block border-l-2 border-transparent px-8 py-3 text-sm text-gray-300 transition hover:border-red-500 hover:bg-white/5 hover:text-red-400">
                        Kegiatan
                    </a>
                    <a href="{{ route('struktur-pengurus') }}"
                        class="block border-l-2 border-transparent px-8 py-3 text-sm text-gray-300 transition hover:border-red-500 hover:bg-white/5 hover:text-red-400">
                        Struktur Pengurus
                    </a>
                    <a href="{{ route('blog.index') }}"
                        class="block border-l-2 border-transparent px-8 py-3 text-sm text-gray-300 transition hover:border-red-500 hover:bg-white/5 hover:text-red-400">
                        Blog
                    </a>
                    <a href="{{ route('coming-soon') }}"
                        class="block border-l-2 border-transparent px-8 py-3 text-sm text-gray-300 transition hover:border-red-500 hover:bg-white/5 hover:text-red-400">
                        Galeri
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-auto p-6">
            <p class="text-center text-xs text-gray-600">
                &copy; 2025 HMIF UKRI. All rights reserved.
            </p>
        </div>
    </div>
</nav>
