<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Dashboard' }} | HMIF UKRI</title>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://kit.fontawesome.com/a9ea8e1647.js" crossorigin="anonymous"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-950 text-gray-200 antialiased overflow-x-hidden font-poppins" x-data="{ sidebarOpen: true }">
    <div class="flex relative w-full min-h-screen">
        <nav class="fixed h-full bg-black border-r border-white/5 transition-all duration-500 z-50 shadow-2xl"
            :class="sidebarOpen ? 'w-64' : 'w-20'">

            <div class="px-6 py-3 mb-2">
                <a href="{{ route('home') }}" class="flex items-center no-underline">
                    <img src="{{ asset('images/logo.png') }}" alt="HMIF LOGO" width="30" height="30"
                        class="w-20 h-20 object-contain">
                    <span x-show="sidebarOpen" x-transition
                        class="font-black text-lg tracking-wide leading-6 text-white uppercase">
                        HMIF <span class="text-red-600 italic">Dashboard</span>
                    </span>
                </a>
            </div>

            @php
                $menuGroups = [
                    'Main Core' => [['icon' => 'grid-outline', 'title' => 'Dashboard', 'route' => 'dashboard']],
                    'Master Data' => [
                        ['icon' => 'school-outline', 'title' => 'Angkatan', 'route' => 'admin.generations.index'],
                        ['icon' => 'business-outline', 'title' => 'Departement', 'route' => 'admin.departments.index'],
                        ['icon' => 'git-branch-outline', 'title' => 'Bidang', 'route' => 'admin.bidangs.index'],
                        ['icon' => 'time-outline', 'title' => 'Periode', 'route' => 'admin.periods.index'],
                        ['icon' => 'list-outline', 'title' => 'Categories', 'route' => 'admin.categories.index'],
                    ],
                    'Organization' => [
                        ['icon' => 'people-outline', 'title' => 'Member', 'route' => 'admin.members.index'],
                        [
                            'icon' => 'shield-checkmark-outline',
                            'title' => 'Pengurus',
                            'route' => 'admin.pengurus.index',
                        ],
                        [
                            'icon' => 'calendar-number-outline',
                            'title' => 'Attendances',
                            'route' => 'admin.attendances.index',
                        ],
                    ],
                    'Core Content' => [
                        ['icon' => 'newspaper-outline', 'title' => 'Blog Posts', 'route' => 'admin.blogs.index'],
                        ['icon' => 'calendar-outline', 'title' => 'Events', 'route' => 'admin.events.index'],
                        ['icon' => 'briefcase-outline', 'title' => 'Portofolio', 'route' => 'admin.portofolios.index'],
                    ],
                    'Media Assets' => [
                        ['icon' => 'images-outline', 'title' => 'Gallery', 'route' => 'admin.galleries.index'],
                        [
                            'icon' => 'document-attach-outline',
                            'title' => 'Doc Events',
                            'route' => 'admin.administrations.index',
                        ],
                    ],
                ];
            @endphp

            <div class="sidebar-menu-container">
                @foreach ($menuGroups as $label => $menus)
                    <p x-show="sidebarOpen"
                        class="px-8 text-[9px] font-black text-gray-600 uppercase tracking-[0.3em] mb-2 mt-6">
                        {{ $label }}
                    </p>

                    <ul class="relative w-full pl-3">
                        @foreach ($menus as $menu)
                            @php
                                $isActive =
                                    Route::has($menu['route']) &&
                                    (request()->routeIs($menu['route']) ||
                                        request()->routeIs(explode('.', $menu['route'])[0] . '.*'));
                            @endphp
                            <li class="nav-item relative w-full list-none {{ $isActive ? 'active' : '' }}">
                                <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#' }}"
                                    class="nav-link">
                                    <span class="inline-block min-w-12.5 h-12.5 leading-13.75 text-center text-xl">
                                        <ion-icon name="{{ $menu['icon'] }}"></ion-icon>
                                    </span>
                                    <span x-show="sidebarOpen"
                                        class="px-2 h-12.5 leading-12.5 whitespace-nowrap font-bold tracking-widest text-[10px] uppercase">
                                        {{ $menu['title'] }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </nav>

        <main class="relative transition-all duration-500 bg-gray-950 min-h-screen flex-1 flex flex-col"
            :class="sidebarOpen ? 'ml-64' : 'ml-20'">

            <header
                class="w-full h-17.5 flex justify-between items-center px-8 sticky top-0 bg-gray-950/50 backdrop-blur-xl border-b border-white/5 z-40">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="text-2xl text-gray-400 hover:text-red-500 transition-colors">
                        <ion-icon :name="sidebarOpen ? 'chevron-back-outline' : 'menu-outline'"></ion-icon>
                    </button>
                    <h2 class="text-sm font-bold text-white uppercase tracking-widest hidden md:block">
                        {{ $header_title ?? 'System Overview' }}
                    </h2>
                </div>

                <div class="flex items-center gap-6">
                    <div class="relative hidden sm:block">
                        <input type="text" placeholder="Quick search..."
                            class="w-64 h-9 rounded-full bg-white/5 border border-white/10 py-1 pl-10 pr-4 text-xs text-white outline-none focus:border-red-600/50 transition-all">
                        <ion-icon name="search-outline"
                            class="absolute top-1/2 -translate-y-1/2 left-3 text-gray-500 text-lg"></ion-icon>
                    </div>

                    <div class="flex items-center gap-3 pl-6 border-l border-white/10">
                        <div class="text-right hidden lg:block">
                            <p class="text-xs font-bold text-white">{{ Auth::user()->member?->full_name ?? 'Admin' }}
                            </p>
                            <p class="text-[10px] text-red-500 font-medium uppercase tracking-tighter italic">
                                {{ Auth::user()->getRoleNames()->first() ?? 'Member' }}
                            </p>
                        </div>
                        <div
                            class="w-10 h-10 rounded-xl overflow-hidden border border-white/10 shadow-lg group cursor-pointer">
                            <img src="{{ Auth::user()->member?->getFirstMediaUrl('avatars') ?: 'https://ui-avatars.com/api/?name=' . Auth::user()->email . '&background=dc2626&color=fff' }}"
                                class="w-full h-full object-cover transition-transform group-hover:scale-110">
                        </div>
                    </div>
                </div>
            </header>

            <div class="p-8">
                <div class="pointer-events-none fixed inset-0 z-0 opacity-[0.02]"
                    style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>

                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>

            <footer class="mt-auto p-8 border-t border-white/5 text-center">
                <p class="text-[10px] uppercase tracking-[0.3em] text-gray-600 font-bold">
                    HMIF Dashboard &bull; Core System v2.0 &bull; 2026
                </p>
            </footer>
        </main>
    </div>

    @stack('scripts')
</body>

</html>
