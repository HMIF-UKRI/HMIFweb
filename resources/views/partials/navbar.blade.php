<!-- Navbar -->
<nav
    class="fixed z-[9999] w-full bg-gradient-to-r from-red-800 to-red-900 text-white shadow-lg"
>
    <div class="container mx-auto py-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="/" class="flex items-center text-2xl font-bold">
                    <img
                        src="{{ asset("images/logo.png") }}"
                        alt=""
                        width="20"
                        height="20"
                        class="h-12 w-12"
                    />
                    <span
                        class="bg-gradient-to-r from-red-200 to-white bg-clip-text text-transparent"
                    >
                        HMIF
                    </span>
                </a>
            </div>
            <div class="hidden space-x-6 md:flex">
                <a
                    href="/"
                    class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-all duration-300 hover:bg-red-700 hover:text-white"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mr-1 h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                        />
                    </svg>
                    Home
                </a>
                <a
                    href="#about"
                    class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-all duration-300 hover:bg-red-700 hover:text-white"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mr-1 h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    About
                </a>
                <a
                    href="#activities"
                    class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-all duration-300 hover:bg-red-700 hover:text-white"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mr-1 h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />
                    </svg>
                    Event
                </a>
                <a
                    href="#gallery"
                    class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-all duration-300 hover:bg-red-700 hover:text-white"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mr-1 h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />
                    </svg>
                    Galery
                </a>
            </div>
            <div class="md:hidden">
                <button
                    id="menu-toggle"
                    class="rounded-md p-2 transition duration-300 hover:bg-red-700 focus:outline-none"
                >
                    <svg class="h-6 w-6" viewBox="0 0 24 24">
                        <path
                            class="fill-current text-white"
                            d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"
                        ></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div
        id="mobile-menu"
        class="hidden origin-top transform bg-red-900 transition-all duration-300 md:hidden"
    >
        <div class="container mx-auto space-y-1 px-4 py-2">
            <a
                href="#home"
                class="flex items-center rounded-md px-3 py-2 text-base font-medium transition hover:bg-red-800"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="mr-2 h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                    />
                </svg>
                Beranda
            </a>
            <a
                href="#about"
                class="flex items-center rounded-md px-3 py-2 text-base font-medium transition hover:bg-red-800"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="mr-2 h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                Tentang
            </a>
            <a
                href="#activities"
                class="flex items-center rounded-md px-3 py-2 text-base font-medium transition hover:bg-red-800"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="mr-2 h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                    />
                </svg>
                Acara
            </a>
            <a
                href="#gallery"
                class="flex items-center rounded-md px-3 py-2 text-base font-medium transition hover:bg-red-800"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="mr-2 h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                    />
                </svg>
                Galeri
            </a>
        </div>
    </div>
</nav>
