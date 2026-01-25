<x-app-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Events - HMIF UKRI',
            'description' =>
                'Portal Internal Pengurus HMIF UKRI untuk mengelola konten dan kegiatan organisasi secara efisien.',
            'keywords' => 'hmif, ukri, himatif, hima, informatika, kegiatan, agenda, seminar, workshop',
            'image' => asset('images/banner-kegiatan.png'),
            'url' => url()->current(),
        ])
    </x-slot>

    <x-slot name="header_title">
        Core Content / Event
    </x-slot>

    <div>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-black text-white tracking-tight uppercase">Daftar Kegiatan</h1>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">
                    Manage semua kegiatan yang telah dibuat di HMIF UKRI
                </p>
            </div>

            <div class="flex gap-3">
                <form method="GET" action="{{ route('admin.events.index') }}" class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="SEARCH EVENT..."
                        class="bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 pl-10 text-[10px] font-bold text-white  tracking-widest focus:border-red-600 focus:w-64 w-40 transition-all outline-none placeholder-gray-700">
                    <ion-icon name="search-outline"
                        class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-600 group-focus-within:text-red-600 transition-colors"></ion-icon>
                </form>

                <a href="{{ route('admin.events.create') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-red-900/20 transition-all hover:scale-105 flex items-center gap-2">
                    <ion-icon name="add-circle-outline" class="text-base"></ion-icon>
                    <span>New Event</span>
                </a>
            </div>
        </div>

        <div class="flex gap-2 mb-6 overflow-x-auto pb-2 scrollbar-hide">
            <a href="{{ route('admin.events.index') }}"
                class="px-4 py-2 rounded-lg border {{ !request('category_id') ? 'bg-red-600/10 border-red-600 text-red-500' : 'bg-white/5 border-white/5 text-gray-500 hover:bg-white/10' }} text-[9px] font-black uppercase tracking-widest transition-all whitespace-nowrap">
                All Categories
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('admin.events.index', ['category_id' => $cat->id]) }}"
                    class="px-4 py-2 rounded-lg border {{ request('category_id') == $cat->id ? 'bg-red-600/10 border-red-600 text-red-500' : 'bg-white/5 border-white/5 text-gray-500 hover:bg-white/10' }} text-[9px] font-black uppercase tracking-widest transition-all whitespace-nowrap">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($events as $event)
                <div
                    class="group relative bg-gray-900/40 border border-white/5 hover:border-red-600/30 rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1">

                    <div class="relative h-48 overflow-hidden">
                        <div class="absolute inset-0 bg-linear-to-t from-gray-900 to-transparent z-10 opacity-90">
                        </div>
                        <img src="{{ $event->getFirstMediaUrl('thumbnails', 'thumb') ?: 'https://via.placeholder.com/640x360.png?text=No+Image' }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                        <div class="absolute top-4 left-4 z-20 flex gap-2">
                            <span
                                class="px-2 py-1 bg-black/60 backdrop-blur-md border border-white/10 rounded-md text-[8px] font-black uppercase tracking-widest text-white">
                                {{ $event->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>
                        <div class="absolute top-4 right-4 z-20">
                            @php
                                $statusColors = [
                                    'upcoming' => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
                                    'ongoing' => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30',
                                    'completed' => 'bg-gray-500/20 text-gray-400 border-gray-500/30',
                                    'cancelled' => 'bg-red-500/20 text-red-400 border-red-500/30',
                                ];
                                $colorClass = $statusColors[$event->status] ?? 'bg-white/10 text-white';
                            @endphp
                            <span
                                class="px-2 py-1 border rounded-md text-[8px] font-black uppercase tracking-widest backdrop-blur-md {{ $colorClass }}">
                                {{ $event->status }}
                            </span>
                        </div>
                    </div>

                    <div class="relative p-6 -mt-10 z-20">
                        <div
                            class="flex items-center gap-2 mb-3 text-[9px] font-bold text-gray-400 uppercase tracking-wider">
                            <span class="flex items-center gap-1">
                                <ion-icon name="calendar-outline" class="text-red-500"></ion-icon>
                                {{ $event->event_date->format('d M Y') }}
                            </span>
                            <span class="w-1 h-1 rounded-full bg-gray-600"></span>
                            <span class="flex items-center gap-1 truncate max-w-25">
                                <ion-icon name="location-outline" class="text-red-500"></ion-icon>
                                {{ $event->location }}
                            </span>
                        </div>

                        <h3
                            class="text-lg font-bold text-white leading-tight mb-2 line-clamp-2 group-hover:text-red-500 transition-colors">
                            {{ $event->title }}
                        </h3>

                        <div class="flex items-center justify-between mt-6 pt-4 border-t border-white/5">
                            <a href="{{ route('admin.events.show', $event->slug) }}"
                                class="text-[9px] font-black text-gray-500 hover:text-white uppercase tracking-widest transition-colors">
                                View Details
                            </a>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.events.edit', $event->slug) }}"
                                    class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 hover:border-yellow-500/50 hover:text-yellow-500 flex items-center justify-center transition-all">
                                    <ion-icon name="create-outline"></ion-icon>
                                </a>
                                <form action="{{ route('admin.events.destroy', $event->slug) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this event?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 hover:border-red-500/50 hover:text-red-500 flex items-center justify-center transition-all">
                                        <ion-icon name="trash-outline"></ion-icon>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="inline-flex p-4 rounded-full bg-white/5 text-gray-600 mb-4">
                        <ion-icon name="calendar-clear-outline" class="text-3xl"></ion-icon>
                    </div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">No Events Found</p>
                </div>
            @endforelse
        </div>

        <div class="my-8">
            {{ $events->links() }}
        </div>
</x-app-layout>
