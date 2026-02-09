<x-app-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Angkatan - HMIF UKRI',
            'description' =>
                'Portal Internal Pengurus HMIF UKRI untuk mengelola data angkatan yang ada di HMIF UKRI.',
            'keywords' => 'hmif, ukri, himatif, hima, informatika, kegiatan, agenda, seminar, workshop',
            'image' => asset('images/banner-kegiatan.png'),
            'url' => url()->current(),
        ])
    </x-slot>

    <x-slot name="header_title">Master Data / Angkatan</x-slot>

    <div class="space-y-8 max-w-7xl mx-auto" x-data="{
        openModal: false,
        editMode: false,
        formAction: '{{ route('admin.generations.store') }}',
        year: '',
        description: '',
        search: '',
    
        setEdit(item) {
            this.editMode = true;
            this.formAction = `/admin/generations/${item.id}`;
            this.year = item.year;
            this.description = item.description;
            this.openModal = true;
        },
        setCreate() {
            this.editMode = false;
            this.formAction = '{{ route('admin.generations.store') }}';
            this.year = '';
            this.description = '';
            this.openModal = true;
        }
    }">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-red-600 font-black uppercase text-[10px] tracking-[.3em]">
                    <span class="w-8 h-0.5 bg-red-600"></span>
                    Master Repository
                </div>
                <h3 class="text-4xl font-black text-white uppercase tracking-tighter leading-none">
                    Data <span class="text-transparent bg-clip-text bg-linear-to-r from-red-600 to-red-400">
                        Angkatan</span>
                </h3>
                <p class="text-sm text-gray-500 font-medium">Monitoring persebaran mahasiswa Teknik Informatika
                    berdasarkan tahun masuk.</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="relative group">
                    <input type="text" x-model="search" placeholder="Cari tahun..."
                        class="bg-white/5 border border-white/10 rounded-xl px-4 py-3 pl-10 text-xs text-white focus:ring-2 focus:ring-red-600/50 outline-none w-48 transition-all group-hover:w-64">
                    <i
                        class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
                </div>
                <button @click="setCreate()"
                    class="group flex items-center gap-3 bg-red-600 hover:bg-red-700 text-white px-6 py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all shadow-xl shadow-red-600/20 active:scale-95">
                    <i class="fa-solid fa-plus transition-transform group-hover:rotate-90"></i>
                    Register New
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div
                class="relative overflow-hidden bg-linear-to-br from-white/5 to-transparent border border-white/5 p-6 rounded-3xl group">
                <div
                    class="absolute -right-4 -top-4 text-white/2 text-8xl transition-transform group-hover:scale-110 group-hover:-rotate-12 font-black italic">
                    #</div>
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Archived Years</p>
                <div class="flex items-baseline gap-2">
                    <h4 class="text-4xl font-black text-white italic tracking-tighter">{{ $generations->total() }}</h4>
                    <span class="text-[10px] font-bold text-red-600 uppercase">Records</span>
                </div>
            </div>
        </div>

        <div class="bg-black/40 border border-white/5 rounded-[2.5rem] overflow-hidden backdrop-blur-md">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/2 border-b border-white/5">
                        <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Generation Year
                        </th>
                        <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
                            Density</th>
                        <th class="p-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">
                            Control Panel</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($generations as $item)
                        <tr class="group transition-all hover:bg-red-600/2 relative"
                            x-show="search === '' || '{{ $item->year }}'.includes(search)">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="h-12 w-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center font-black text-red-600 italic group-hover:bg-red-600 group-hover:text-white transition-all duration-500">
                                        {{ substr($item->year, -2) }}
                                    </div>
                                    <div>
                                        <p class="font-black text-xl text-white tracking-tighter italic leading-none">
                                            {{ $item->year }}</p>
                                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">
                                            Academic Year</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6 text-center">
                                <div class="inline-flex flex-col items-center">
                                    <span
                                        class="text-white font-black italic text-lg tracking-tighter">{{ $item->members_count }}</span>
                                    <div class="h-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.5)]"
                                        style="width: {{ min(($item->members_count / 100) * 100, 100) }}%"></div>
                                </div>
                                <span
                                    class="text-[9px] text-gray-600 font-bold uppercase tracking-tighter mt-1">Students
                                    Registered</span>
                            </td>
                            <td class="p-6 text-right">
                                <div
                                    class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 -translate-x-4 group-hover:translate-x-0">
                                    <button @click="setEdit({{ $item }})"
                                        class="h-10 w-10 rounded-xl bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white flex items-center justify-center transition-all border border-white/10 shadow-lg active:scale-90">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </button>
                                    <form action="{{ route('admin.generations.destroy', $item->id) }}" method="POST"
                                        class="inline">
                                        @csrf @method('DELETE')
                                        <button
                                            onclick="return confirm('Sistem akan menghapus data permanen. Lanjutkan?')"
                                            class="h-10 w-10 rounded-xl bg-white/5 hover:bg-red-600 text-gray-400 hover:text-white flex items-center justify-center transition-all border border-white/10 shadow-lg active:scale-90">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-20 text-center">
                                <div class="flex flex-col items-center gap-4 opacity-20">
                                    <i class="fa-solid fa-database text-6xl"></i>
                                    <p class="italic uppercase text-xs tracking-[0.5em] font-black">Archive Database is
                                        Empty</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MODAL BOX --}}
        <x-modal-form>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Tahun
                    Angkatan</label>
                <input type="number" name="year" x-model="year" required
                    class="w-full bg-black/50 border border-white/5 rounded-2xl py-4 px-6 text-white focus:border-red-600 transition-all outline-none"
                    placeholder="Contoh: 2025">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Tahun
                    Angkatan</label>
                <input type="number" name="year" x-model="year" required
                    class="w-full bg-black/50 border border-white/5 rounded-2xl py-4 px-6 text-white focus:border-red-600 transition-all outline-none"
                    placeholder="Contoh: 2025">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Tahun
                    Angkatan</label>
                <input type="number" name="year" x-model="year" required
                    class="w-full bg-black/50 border border-white/5 rounded-2xl py-4 px-6 text-white focus:border-red-600 transition-all outline-none"
                    placeholder="Contoh: 2025">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Tahun
                    Angkatan</label>
                <input type="number" name="year" x-model="year" required
                    class="w-full bg-black/50 border border-white/5 rounded-2xl py-4 px-6 text-white focus:border-red-600 transition-all outline-none"
                    placeholder="Contoh: 2025">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Tahun
                    Angkatan</label>
                <input type="number" name="year" x-model="year" required
                    class="w-full bg-black/50 border border-white/5 rounded-2xl py-4 px-6 text-white focus:border-red-600 transition-all outline-none"
                    placeholder="Contoh: 2025">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Tahun
                    Angkatan</label>
                <input type="number" name="year" x-model="year" required
                    class="w-full bg-black/50 border border-white/5 rounded-2xl py-4 px-6 text-white focus:border-red-600 transition-all outline-none"
                    placeholder="Contoh: 2025">
            </div>
        </x-modal-form>
    </div>
</x-app-layout>
