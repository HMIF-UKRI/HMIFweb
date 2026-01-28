<x-app-layout>
    <x-slot name="header_title">Organization / Departemen</x-slot>

    <div class="space-y-6" x-data="{
        openModal: {{ $errors->any() ? 'true' : 'false' }},
        editMode: false,
        formAction: '{{ route('admin.departments.store') }}',
        name: @js(old('name')),
        description: @js(old('description')),

        setCreate() {
            this.editMode = false;
            this.formAction = '{{ route('admin.departments.store') }}';
            this.name = '';
            this.description = '';
            this.openModal = true;
        },

        setEdit(item) {
            this.editMode = true;
            this.formAction = `/admin/departments/${item.id}`;
            this.name = item.name;
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
                    Data <span class="text-red-600 italic">Departemen</span>
                </h3>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">
                    {{ $departments->total() }} Data Departemen</p>
            </div>
            <button @click="setCreate()"
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-red-600/20 active:scale-95">
                Add Departemen
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse ($departments as $item)
                <div
                    class="group relative bg-white/2 border border-white/5 rounded-2xl p-4 hover:bg-white/4 transition-all duration-300">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <h4 class="text-sm font-black text-white tracking-tighter truncate">{{ $item->name }}</h4>
                            @if ($item->description)
                                <p class="text-[9px] text-gray-400 mt-2 line-clamp-2">{{ $item->description }}</p>
                            @endif
                            <p class="text-[9px] text-red-600 font-bold uppercase tracking-widest mt-2">
                                {{ $item->members_count }} Anggota
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" @click="setEdit(@js($item))"
                                class="h-8 w-8 flex items-center justify-center rounded-lg bg-white/5 hover:bg-red-600 hover:text-white transition-colors border border-white/5">
                                <ion-icon name="create-outline" class="text-xs"></ion-icon>
                            </button>
                            <form action="{{ route('admin.departments.destroy', $item->id) }}" method="POST"
                                class="inline" onsubmit="return confirm('Hapus departemen ini?')">
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
                    <p class="text-[10px] font-black uppercase tracking-[0.4em]">Tidak ada data departemen</p>
                </div>
            @endforelse
        </div>

        <div class="pt-4">
            {{ $departments->links() }}
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
                    <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Nama
                        Departemen</label>
                    <input type="text" name="name" x-model="name" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600">
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
