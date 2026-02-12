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

    <div x-data="{
        openModal: false,
        editMode: false,
        formAction: '',
        eventName: '',
        exportUrl: '',
        attendances: []
    }"
        @open-attendance-modal.window="
            eventName = $event.detail.name;
            exportUrl = $event.detail.exportUrl;
            attendances = $event.detail.data;
            openModal = true;
        ">
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

                        <a href="{{ route('admin.events.show', $event->slug) }}"
                            class="text-lg font-bold text-white leading-tight mb-2 line-clamp-2 group-hover:text-red-500 transition-colors">
                            {{ $event->title }}
                        </a>

                        <div class="flex items-center justify-between mt-6 pt-4 border-t border-white/5">
                            <button type="button"
                                @click="$dispatch('open-attendance-modal', {
        name: '{{ $event->title }}',
        exportUrl: '{{ route('admin.attendances.export_pdf', $event->slug) }}',
        data: [
            @foreach ($event->attendances as $att)
            {
                id: {{ $att->id }},
                check_in_time: '{{ $att->check_in_time->format('H:i') }}',
                name: '{{ $att->participant_type == 'internal' ? $att->member->full_name ?? 'N/A' : $att->external_name }}',
                identifier: '{{ $att->participant_type == 'internal' ? $att->member->npm ?? '-' : $att->external_npm }}',
                type: '{{ $att->participant_type }}'
            }, @endforeach
        ]
    })"
                                class="text-[9px] font-black text-gray-500 hover:text-white uppercase tracking-widest transition-colors">
                                Cek Absensi
                            </button>
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

            <x-modal name="attendance-modal" maxWidth="3xl">
                <div class="p-8 bg-gray-900 border border-white/10 rounded-4xl overflow-hidden" x-data="{
                    eventName: '',
                    exportUrl: '',
                    attendances: []
                }"
                    @open-attendance-modal.window="
            eventName = $event.detail.name;
            exportUrl = $event.detail.exportUrl;
            attendances = $event.detail.data;
            show = true;
        ">

                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-white" x-text="eventName"></h2>
                            <p class="text-[10px] text-gray-500 uppercase tracking-[0.2em] mt-1">Monitoring Data Absensi
                                Real-time</p>
                        </div>

                        <a :href="exportUrl"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest flex items-center justify-center gap-2 transition-all active:scale-95">
                            <i class="fa-solid fa-file-pdf"></i> Generate Laporan PDF
                        </a>
                    </div>

                    <div class="overflow-x-auto custom-scrollbar max-h-[50vh] border border-white/5 rounded-2xl">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-white/2 border-b border-white/10">
                                    <th
                                        class="py-4 px-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                        Waktu</th>
                                    <th
                                        class="py-4 px-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                        Nama Lengkap</th>
                                    <th
                                        class="py-4 px-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                        Identitas (NPM)</th>
                                    <th
                                        class="py-4 px-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
                                        Tipe</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                <template x-for="item in attendances" :key="item.id">
                                    <tr class="hover:bg-white/2 transition-colors group">
                                        <td class="py-4 px-6 text-xs text-gray-400" x-text="item.check_in_time"></td>
                                        <td class="py-4 px-6 text-xs font-bold text-white group-hover:text-red-500 transition-colors"
                                            x-text="item.name"></td>
                                        <td class="py-4 px-6 text-xs text-gray-500 font-mono" x-text="item.identifier">
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span
                                                class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-tighter"
                                                :class="item.type === 'internal' ?
                                                    'bg-blue-500/10 text-blue-400 border border-blue-500/20' :
                                                    'bg-red-500/10 text-red-400 border border-red-500/20'"
                                                x-text="item.type">
                                            </span>
                                        </td>
                                    </tr>
                                </template>
                                <template x-if="attendances.length === 0">
                                    <tr>
                                        <td colspan="4" class="py-20 text-center">
                                            <div class="flex flex-col items-center gap-2">
                                                <ion-icon name="clipboard-outline"
                                                    class="text-3xl text-gray-700"></ion-icon>
                                                <p class="text-gray-500 text-xs italic uppercase tracking-widest">Belum
                                                    ada data absensi masuk</p>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button @click="show = false"
                            class="text-[10px] font-black text-gray-500 hover:text-white uppercase tracking-widest transition-colors">
                            Tutup Jendela
                        </button>
                    </div>
                </div>
            </x-modal>
        </div>

        <div class="my-8">
            {{ $events->links() }}
        </div>
</x-app-layout>
