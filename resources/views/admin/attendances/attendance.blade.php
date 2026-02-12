<x-app-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Attendances - HMIF UKRI',
            'description' => '',
        ])
    </x-slot>

    <x-slot name="header_title">Organization / Monitoring Absensi</x-slot>

    <div class="space-y-4">
        <div class="flex justify-between items-end">
            <h3 class="text-sm font-black text-white uppercase tracking-[0.2em] italic flex items-center gap-2">
                <span class="w-8 h-px bg-blue-600"></span> Log Kehadiran:
                {{ $event->title }}
            </h3>
        </div>
        <div class="bg-black/40 border border-white/5 rounded-2xl overflow-hidden shadow-2xl">
            <table class="w-full text-left">
                <thead class="bg-white/3 border-b border-white/5">
                    <tr>
                        <th class="px-6 py-4 text-[9px] font-black text-gray-500 uppercase tracking-widest">
                            Waktu
                        </th>
                        <th class="px-6 py-4 text-[9px] font-black text-gray-500 uppercase tracking-widest">
                            Identitas</th>
                        <th class="px-6 py-4 text-[9px] font-black text-gray-500 uppercase tracking-widest">
                            Instansi/Prodi</th>
                        <th class="px-6 py-4 text-[9px] font-black text-gray-500 uppercase tracking-widest">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($attendances as $item)
                        <tr class="hover:bg-white/1 transition">
                            <td class="px-6 py-4 text-xs font-mono text-red-500">
                                {{ $item->check_in_time->format('H:i:s') }}</td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-white uppercase italic">
                                    {{ $item->participant_type == 'internal' ? $item->member->full_name : $item->external_name }}
                                </p>
                                <p class="text-[10px] text-gray-500 font-mono">
                                    {{ $item->participant_type == 'internal' ? $item->member->npm : $item->external_npm }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-400 font-medium">
                                {{ $item->participant_type == 'internal' ? 'Informatika (Internal)' : $item->external_prodi }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-tighter 
                                    {{ $item->participant_type == 'internal' ? 'bg-red-500/10 text-red-500' : 'bg-blue-500/10 text-blue-500' }}">
                                    {{ $item->participant_type }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4"
                                class="px-6 py-20 text-center text-gray-600 text-[10px] font-black uppercase tracking-[0.3em]">
                                Belum ada aktivitas presensi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
