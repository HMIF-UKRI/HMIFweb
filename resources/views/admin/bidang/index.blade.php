<x-app-layout>
    <x-slot name="header_title">Organization / Bidang</x-slot>

    <div class="space-y-6" x-data="{
        openModal: false,
        editMode: false,
        formAction: '',
        name: '',
        department_id: '',
        description: '',

        setCreate() {
            this.editMode = false;
            this.formAction = '{{ route('admin.bidangs.store') }}';
            this.name = '';
            this.department_id = '';
            this.description = '';
            this.openModal = true;
        },

        setEdit(item) {
            this.editMode = true;
            this.formAction = `/admin/bidangs/${item.id}`;
            this.name = item.name;
            this.department_id = item.department_id;
            this.description = item.description || '';
            this.openModal = true;
        }
    }">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-white/5 pb-6">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-red-600 font-black uppercase text-[10px] tracking-[0.3em]">
                    <span class="w-8 h-0.5 bg-red-600 shadow-[0_0_10px_rgba(220,38,38,0.5)]"></span>
                    <span>HMIF UKRI</span>
                </div>
                <h3 class="text-2xl font-black text-white uppercase tracking-tighter">
                    Data <span class="text-red-600 italic">Bidang</span>
                </h3>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">
                    {{ $bidangs->total() }} Data Bidang</p>
            </div>
            <button @click="setCreate()"
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-red-600/20 active:scale-95">
                Add Bidang
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse ($bidangs as $item)
                    <div
                        class="group relative bg-white/2 border border-white/5 rounded-2xl p-4 hover:bg-white/4 transition-all duration-300">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <h4 class="text-sm font-black text-white tracking-tighter truncate">
                                    {{ $item->name }}</h4>
                                <p class="text-[9px] text-red-600 font-bold uppercase tracking-widest mt-1">
                                    {{ $item->department?->name ?? 'Tanpa Departemen' }}</p>
                                @if ($item->description)
                                    <p class="text-[9px] text-gray-400 mt-2 line-clamp-2">
                                        {{ $item->description }}</p>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <button type="button" @click="setEdit(@js($item))"
                                    class="h-8 w-8 flex items-center justify-center rounded-lg bg-white/5 hover:bg-red-600 hover:text-white transition-colors border border-white/5">
                                    <ion-icon name="create-outline" class="text-xs"></ion-icon>
                                </button>
                                <form action="{{ route('admin.bidangs.destroy', $item->id) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Hapus bidang ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="h-8 w-8 flex items-center justify-center rounded-lg bg-white/5 hover:bg-red-600 hover:text-white transition-colors border border-white/5">
                                        <ion-icon name="trash-outline" class="text-xs"></ion-icon>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full py-20 text-center border-2 border-dashed border-white/5 rounded-[2.5rem] opacity-20">
                        <p class="text-[10px] font-black uppercase tracking-[0.4em]">Tidak ada data bidang</p>
                    </div>
                @endforelse
            </div>

            <div class="bg-white/2 border border-white/5 rounded-2xl p-6 h-fit">
                <h4 class="text-xs font-black text-white uppercase tracking-widest mb-4">Panduan</h4>
                <p class="text-[9px] text-gray-400">
                    Klik <span class="text-white font-bold">Add Bidang</span> untuk membuat bidang baru,
                    atau ikon pensil untuk mengubah data.
                </p>
            </div>
        </div>

        <div class="pt-4">
            {{ $bidangs->links() }}
        </div>

        <x-modal-form>
        @if ($errors->any())
            <div class="rounded-2xl border border-red-500/30 bg-red-500/10 p-4 text-[10px] text-red-300">
                <div class="mb-2 font-black uppercase tracking-widest">Gagal menyimpan</div>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-4">
            <div class="space-y-1.5">
                <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Nama Bidang</label>
                <input type="text" name="name" x-model="name" required
                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600">
            </div>

            <div class="space-y-1.5">
                <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Departemen</label>
                <select name="department_id" x-model="department_id" required
                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600 appearance-none">
                    <option value="" class="bg-gray-950">Pilih Departemen</option>
                    @foreach ($departments as $d)
                        <option value="{{ $d->id }}" class="bg-gray-950">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Deskripsi
                    (Optional)</label>
                <textarea name="description" rows="3" x-model="description"
                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600"></textarea>
            </div>
        </div>
        </x-modal-form>
    </div>
</x-app-layout>
