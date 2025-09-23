<nav
    x-data="{ mobileMenuOpen: false }"
    class="fixed z-[9999] w-full bg-gradient-to-r from-red-800 to-red-900 text-white shadow-lg"
>
    <div class="container mx-auto">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="/" class="flex items-center text-2xl">
                    <img
                        src="{{ asset("images/logo.png") }}"
                        alt="HMIF logo"
                        width="20"
                        height="20"
                        class="h-20 w-20 bg-cover object-contain lg:h-24 lg:w-24"
                    />
                    <div
                        class="font-jkt-sans hidden flex-col tracking-wide lg:flex"
                    >
                        <span class="-ml-2 text-xs font-bold lg:text-base">
                            Himpunan Mahasiswa
                            <span
                                class="bg-linear-to-r from-red-400 to-red-400 bg-clip-text font-extrabold text-transparent"
                            >
                                Teknik Informatika
                            </span>
                        </span>
                        <span class="-ml-2 text-xs lg:text-base">
                            Universitas Kebangsaan Republik Indonesia
                        </span>
                    </div>
                    <div class="lg:hidden">
                        <span class="-ml-2 font-bold">HMIF UKRI</span>
                    </div>
                </a>
            </div>

            <!-- Menu Desktop -->
            <div
                class="hidden space-x-2 md:flex md:items-center md:justify-center"
            >
                <a
                    href="/"
                    class="relative block rounded-md px-3 py-2 text-sm transition-colors duration-200 after:absolute after:right-3 after:bottom-1.5 after:left-3 after:h-0.5 after:origin-left after:scale-x-0 after:bg-red-500 after:transition-transform after:duration-300 hover:after:scale-x-100"
                >
                    Beranda
                </a>
                <a
                    href="#about"
                    class="relative block rounded-md px-3 py-2 text-sm transition-colors duration-200 after:absolute after:right-3 after:bottom-1.5 after:left-3 after:h-0.5 after:origin-left after:scale-x-0 after:bg-red-500 after:transition-transform after:duration-300 hover:after:scale-x-100"
                >
                    Tentang Kami
                </a>

                <!-- Dropdown Desktop -->
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button
                        @mouseover="dropdownOpen = true"
                        @mouseleave="dropdownOpen = false"
                        class="flex w-full items-center rounded-md px-3 py-2 text-sm font-medium transition-all duration-300 focus:outline-none"
                    >
                        <span>Profil</span>
                        <svg
                            class="ml-1 h-5 w-5 transform transition-transform duration-300"
                            :class="{'rotate-180': dropdownOpen}"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>

                    <div
                        x-show="dropdownOpen"
                        @mouseover="dropdownOpen = true"
                        @mouseleave="dropdownOpen = false"
                        x-transition:enter="transition duration-200 ease-out"
                        x-transition:enter-start="scale-95 transform opacity-0"
                        x-transition:enter-end="scale-100 transform opacity-100"
                        x-transition:leave="transition duration-150 ease-in"
                        x-transition:leave-start="scale-100 transform opacity-100"
                        x-transition:leave-end="scale-95 transform opacity-0"
                        class="ring-opacity-5 absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white text-gray-800 shadow-xl ring-1 ring-black"
                        style="display: none"
                    >
                        <div class="space-y-1 p-2">
                            <a
                                href="/kegiatan"
                                class="relative block rounded-md px-3 py-2 text-sm transition-colors duration-200 after:absolute after:right-3 after:bottom-1.5 after:left-3 after:h-0.5 after:origin-left after:scale-x-0 after:bg-red-500 after:transition-transform after:duration-300 hover:after:scale-x-100"
                            >
                                Kegiatan
                            </a>
                            <a
                                href="/struktur-pengurus"
                                class="relative block rounded-md px-3 py-2 text-sm transition-colors duration-200 after:absolute after:right-3 after:bottom-1.5 after:left-3 after:h-0.5 after:origin-left after:scale-x-0 after:bg-red-500 after:transition-transform after:duration-300 hover:after:scale-x-100"
                            >
                                Struktur Pengurus
                            </a>
                            <a
                                href="/blog"
                                class="relative block rounded-md px-3 py-2 text-sm transition-colors duration-200 after:absolute after:right-3 after:bottom-1.5 after:left-3 after:h-0.5 after:origin-left after:scale-x-0 after:bg-red-500 after:transition-transform after:duration-300 hover:after:scale-x-100"
                            >
                                Blog
                            </a>
                            <a
                                href="/galeri"
                                class="relative block rounded-md px-3 py-2 text-sm transition-colors duration-200 after:absolute after:right-3 after:bottom-1.5 after:left-3 after:h-0.5 after:origin-left after:scale-x-0 after:bg-red-500 after:transition-transform after:duration-300 hover:after:scale-x-100"
                            >
                                Galeri
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Akhir Dropdown Desktop -->
            </div>

            <!-- Tombol Menu Mobile -->
            <div class="md:hidden">
                <button
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="rounded-md p-2 transition duration-300 hover:bg-red-700 focus:outline-none"
                >
                    <svg class="h-8 w-8" viewBox="0 0 24 24">
                        <path
                            class="fill-current text-white"
                            d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"
                        ></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div
        x-show="mobileMenuOpen"
        x-transition:enter="transition-opacity transition-transform duration-300 ease-out"
        x-transition:enter-start="-translate-y-4 transform opacity-0"
        x-transition:enter-end="translate-y-0 transform opacity-100"
        x-transition:leave="transition-opacity transition-transform duration-200 ease-in"
        x-transition:leave-start="translate-y-0 transform opacity-100"
        x-transition:leave-end="-translate-y-4 transform opacity-0"
        class="origin-top bg-red-900 md:hidden"
        style="display: none"
    >
        <div class="container mx-auto space-y-1 px-4 py-2">
            <a
                href="/"
                class="flex items-center rounded-md px-3 py-2 text-base font-medium transition hover:bg-red-800"
            >
                Beranda
            </a>
            <a
                href="#about"
                class="flex items-center rounded-md px-3 py-2 text-base font-medium transition hover:bg-red-800"
            >
                Tentang Kami
            </a>

            <!-- Dropdown Mobile -->
            <div x-data="{ dropdownOpen: false }" class="w-full">
                <button
                    @click="dropdownOpen = !dropdownOpen"
                    class="flex w-full items-center justify-between rounded-md px-3 py-2 text-base font-medium transition hover:bg-red-800"
                >
                    <span>Profil</span>
                    <svg
                        class="ml-1 h-5 w-5 transform transition-transform duration-300"
                        :class="{'rotate-180': dropdownOpen}"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
                <div x-show="dropdownOpen" x-collapse class="pl-6">
                    <a
                        href="/kegiatan"
                        class="flex items-center rounded-md px-3 py-2 text-base font-medium transition hover:bg-red-800"
                    >
                        Kegiatan
                    </a>
                    <a
                        href="/struktur-pengurus"
                        class="flex items-center rounded-md px-3 py-2 text-base font-medium transition hover:bg-red-800"
                    >
                        Struktur Pengurus
                    </a>
                    <a
                        href="/blog"
                        class="flex items-center rounded-md px-3 py-2 text-base font-medium transition hover:bg-red-800"
                    >
                        Blog
                    </a>
                    <a
                        href="/galeri"
                        class="flex items-center rounded-md px-3 py-2 text-base font-medium transition hover:bg-red-800"
                    >
                        Galeri
                    </a>
                </div>
            </div>
            <!-- Akhir Dropdown Mobile -->
        </div>
    </div>
</nav>
