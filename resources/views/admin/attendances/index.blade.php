<x-app-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Attendances - HMIF UKRI',
            'description' => '',
        ])
    </x-slot>

    <x-slot name="header_title">Organization / Monitoring Absensi</x-slot>

    <div class="space-y-6">
        @if (session('error'))
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl flex items-center gap-3 text-red-500">
                <ion-icon name="alert-circle-outline" class="text-xl"></ion-icon>
                <p class="text-xs font-bold uppercase tracking-widest">{{ session('error') }}</p>
            </div>
        @endif
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
                            <button type="button"
                                @click="$dispatch('open-modal', 'modal-form'); $dispatch('open-attendance-modal', {
        name: '{{ $event->title }}',
        exportUrl: '{{ route('admin.attendances.export_pdf', $event->slug) }}',
        data: [
            @foreach ($event->attendances as $att)
            {
                id: {{ $att->id }},
                check_in_time: '{{ $att->check_in_time->format('H:i') }}',
                name: '{{ $att->participant_type == 'internal' ? $att->member->full_name : $att->external_name }}',
                identifier: '{{ $att->participant_type == 'internal' ? $att->member->npm : $att->external_npm }}',
                type: '{{ $att->participant_type }}'
            }, @endforeach
        ]
    })"
                                class="text-[9px] font-black text-gray-500 hover:text-white uppercase tracking-widest transition-colors">
                                Cek Absensi
                            </button>
                            <a href="{{ route('admin.attendances.qrcode', $event->slug) }}" target="_blank"
                                class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 transition">
                                <i class="fa-solid fa-qrcode"></i> Buka Mode QR
                            </a>
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

        <x-modal-form>
            <div class="p-6 bg-gray-900 border border-white/10 rounded-2xl overflow-hidden">

                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-white" x-text="eventName"></h2>
                        <p class="text-[10px] text-gray-500 uppercase tracking-widest mt-1">Monitoring Data Absensi</p>
                    </div>

                    <a :href="exportUrl"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 transition">
                        <i class="fa-solid fa-file-pdf"></i> Generate PDF
                    </a>
                </div>

                <div class="overflow-x-auto custom-scrollbar max-h-100">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/5">
                                <th class="py-3 px-4 text-[10px] font-black text-gray-500 uppercase">Waktu</th>
                                <th class="py-3 px-4 text-[10px] font-black text-gray-500 uppercase">Nama</th>
                                <th class="py-3 px-4 text-[10px] font-black text-gray-500 uppercase">Identitas (NPM)
                                </th>
                                <th class="py-3 px-4 text-[10px] font-black text-gray-500 uppercase">Tipe</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            <template x-for="item in attendances" :key="item.id">
                                <tr class="hover:bg-white/2 transition-colors">
                                    <td class="py-3 px-4 text-xs text-gray-400" x-text="item.check_in_time"></td>
                                    <td class="py-3 px-4 text-xs font-bold text-white" x-text="item.name"></td>
                                    <td class="py-3 px-4 text-xs text-gray-400" x-text="item.identifier"></td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase"
                                            :class="item.type === 'internal' ? 'bg-blue-500/10 text-blue-400' :
                                                'bg-purple-500/10 text-purple-400'"
                                            x-text="item.type">
                                        </span>
                                    </td>
                                </tr>
                            </template>
                            <template x-if="attendances.length === 0">
                                <tr>
                                    <td colspan="4" class="py-10 text-center text-gray-500 text-xs italic">Belum ada
                                        data absensi.</td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </x-modal-form>
    </div>
</x-app-layout>
