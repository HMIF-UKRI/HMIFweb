<x-app-layout>
    <x-slot name="header_title">Master Data / Periode</x-slot>

    <div class="space-y-8" x-data="{
        openModal: false,
        editMode: false,
        formAction: '',
        imageUrl: null,
    
        cabinet_name: '',
        period_range: '',
        vision: '',
        mission: '',
        start_date: '',
        end_date: '',
        is_current: false,
    
        setEdit(item) {
            this.editMode = true;
            this.formAction = `/admin/periods/${item.id}`;
            this.cabinet_name = item.cabinet_name;
            this.period_range = item.period_range;
            this.vision = item.vision || '';
            this.mission = item.mission || '';
            this.start_date = item.start_date;
            this.end_date = item.end_date;
            this.is_current = !!item.is_current;
            this.imageUrl = item.logo_url;
            this.openModal = true;
        },
    
        setCreate() {
            this.editMode = false;
            this.formAction = '{{ route('admin.periods.store') }}';
            this.cabinet_name = '';
            this.period_range = '';
            this.vision = '';
            this.mission = '';
            this.start_date = '';
            this.end_date = '';
            this.is_current = false;
            this.imageUrl = null;
            this.openModal = true;
        },
    
        fileChosen(event) {
            const file = event.target.files[0];
            if (!file) return;
            this.imageUrl = URL.createObjectURL(file);
        }
    }">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
            <div class="space-y-1">
                <h3 class="text-4xl font-black text-white uppercase tracking-tighter">
                    Kepengurusan <span class="text-red-600 italic">History</span>
                </h3>
                <p class="text-sm text-gray-500 font-medium">Manajemen periode aktif dan arsip kabinet HMIF.</p>
            </div>
            <button @click="setCreate()"
                class="bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-red-600/20 transition-all active:scale-95">
                New Cabinet
            </button>
        </div>

        <div class="bg-black/40 border border-white/5 rounded-[2.5rem] overflow-hidden backdrop-blur-md">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/2 border-b border-white/5">
                        <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Cabinet</th>
                        <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
                            Duration</th>
                        <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
                            Status</th>
                        <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($periods as $item)
                        <tr class="group hover:bg-red-600/2 transition-all">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="h-12 w-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center overflow-hidden">
                                        @if ($item->getFirstMediaUrl('cabinet_logos'))
                                            <img src="{{ $item->getFirstMediaUrl('cabinet_logos') }}"
                                                class="w-full h-full object-contain p-2">
                                        @else
                                            <i class="fa-solid fa-shield-halved text-gray-700"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-black text-lg text-white tracking-tighter italic leading-none">
                                            {{ $item->cabinet_name }}</p>
                                        <p class="text-[9px] text-gray-500 font-bold uppercase mt-1 tracking-widest">
                                            {{ $item->period_range }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6 text-center">
                                <p class="text-xs text-gray-400 font-medium">
                                    {{ $item->start_date ? date('M Y', strtotime($item->start_date)) : '-' }} &mdash;
                                    {{ $item->end_date ? date('M Y', strtotime($item->end_date)) : 'Present' }}</p>
                            </td>
                            <td class="p-6 text-center">
                                @if ($item->is_current)
                                    <span
                                        class="px-4 py-1.5 rounded-full bg-red-600/10 border border-red-600/30 text-[9px] font-black text-red-500 uppercase tracking-widest animate-pulse">
                                        Active Now
                                    </span>
                                @else
                                    <span
                                        class="px-4 py-1.5 rounded-full bg-white/5 border border-white/10 text-[9px] font-black text-gray-600 uppercase tracking-widest">
                                        Archived
                                    </span>
                                @endif
                            </td>
                            <td class="p-6 text-right">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                    <button @click="setEdit({{ $item->toJson() }})"
                                        class="h-10 w-10 rounded-xl bg-white/5 hover:bg-white/10 text-gray-400 flex items-center justify-center border border-white/10">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-20 text-center opacity-20">
                                <p class="italic uppercase text-xs tracking-widest font-black">No Database Records</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-modal-form>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] ml-1">Cabinet
                            Name</label>
                        <input type="text" name="cabinet_name" x-model="cabinet_name" required
                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white focus:border-red-600 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] ml-1">Period Range
                            (e.g. 2025-2026)</label>
                        <input type="text" name="period_range" x-model="period_range" required
                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white focus:border-red-600 outline-none transition-all">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] ml-1">Start
                                Date</label>
                            <input type="date" name="start_date" x-model="start_date"
                                class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white focus:border-red-600 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] ml-1">End
                                Date</label>
                            <input type="date" name="end_date" x-model="end_date"
                                class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white focus:border-red-600 outline-none transition-all">
                        </div>
                    </div>
                    <label
                        class="flex items-center gap-4 p-5 rounded-2xl bg-white/2 border border-white/5 cursor-pointer hover:border-red-600/50 transition-all">
                        <input type="checkbox" name="is_current" value="1" x-model="is_current"
                            class="w-6 h-6 rounded-lg border-white/10 text-red-600 bg-gray-950 focus:ring-red-600/20">
                        <div>
                            <p class="text-[10px] font-black text-white uppercase tracking-tighter">Set as Current
                                Cabinet</p>
                            <p class="text-[8px] text-gray-500 uppercase font-bold tracking-widest">Active System Period
                            </p>
                        </div>
                    </label>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] ml-1">Cabinet Official
                        Logo</label>
                    <div
                        class="relative h-full min-h-62.5 border-2 border-dashed border-white/10 rounded-4xl bg-white/1 flex items-center justify-center overflow-hidden group hover:border-red-600/30 transition-all">
                        <input type="file" name="logo" class="absolute inset-0 opacity-0 z-20 cursor-pointer"
                            @change="fileChosen">
                        <template x-if="imageUrl">
                            <img :src="imageUrl" class="absolute inset-0 w-full h-full object-contain p-8 z-10">
                        </template>
                        <div x-show="!imageUrl" class="text-center opacity-40">
                            <i class="fa-solid fa-cloud-arrow-up text-4xl mb-3"></i>
                            <p class="text-[10px] font-black uppercase tracking-widest">Upload Visual</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6 pt-4">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] ml-1">Strategic
                        Vision</label>
                    <textarea name="vision" x-model="vision" rows="3"
                        class="w-full bg-white/5 border border-white/10 rounded-3xl py-4 px-6 text-sm text-gray-300 focus:border-red-600 transition-all outline-none resize-none"
                        placeholder="Define the future goal..."></textarea>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] ml-1">Operational
                        Mission</label>
                    <textarea name="mission" x-model="mission" rows="6"
                        class="w-full bg-white/5 border border-white/10 rounded-3xl py-4 px-6 text-sm text-gray-300 focus:border-red-600 transition-all outline-none resize-none"
                        placeholder="List the tactical steps..."></textarea>
                </div>
            </div>
        </x-modal-form>
    </div>
</x-app-layout>
