<x-app-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Member Directory - HMIF UKRI',
            'description' => 'Manajemen basis data anggota Himpunan Mahasiswa Teknik Informatika UKRI.',
        ])
    </x-slot>

    <x-slot name="header_title">Organization / Members</x-slot>

    <div class="space-y-6" x-data="{
        openModal: false,
        editMode: false,
        formAction: '',
        imageUrl: null,
    
        full_name: '',
        npm: '',
        email: '',
        password: '',
        role: '',
        generation_id: '',
        instagram_url: '',
        linkedin_url: '',
        is_active: true,
    
        setEdit(item) {
            this.editMode = true;
            this.formAction = `/admin/members/${item.id}`;
    
            this.full_name = item.full_name;
            this.npm = item.npm;
            this.email = item.user ? item.user.email : '';
            this.password = '';
    
            this.role = (item.user && item.user.roles.length > 0) ? item.user.roles[0].name : 'Member';
    
            this.generation_id = item.generation_id;
            this.instagram_url = item.instagram_url || '';
            this.linkedin_url = item.linkedin_url || '';
    
            this.imageUrl = item.preview_url || null;
            this.is_active = item.is_active == 1;
    
            this.openModal = true;
        },
    
        setCreate() {
            this.editMode = false;
            this.formAction = '{{ route('admin.members.store') }}';
            this.full_name = '';
            this.npm = '';
            this.email = '';
            this.password = '';
            this.role = 'Member';
            this.generation_id = '';
            this.instagram_url = '';
            this.linkedin_url = '';
            this.imageUrl = null;
            this.is_active = true;
            this.openModal = true;
        },
    }">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-white/5 pb-6">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-red-600 font-black uppercase text-[10px] tracking-[0.3em]">
                    <span class="w-8 h-0.5 bg-red-600 shadow-[0_0_10px_rgba(220,38,38,0.5)]"></span>
                    <span>HMIF UKRI</span>
                </div>
                <h3 class="text-3xl font-black text-white uppercase tracking-tighter leading-none">
                    Data <span
                        class="text-transparent bg-clip-text bg-linear-to-r from-red-600 to-red-400 italic">Anggota</span>
                </h3>
            </div>

            <div class="flex items-center gap-3">
                <form action="{{ route('admin.members.index') }}" method="GET" class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama/NPM..."
                        class="bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 pl-10 text-[10px] text-white focus:ring-2 focus:ring-red-600/50 outline-none w-48 transition-all group-hover:w-64 uppercase tracking-widest font-bold">
                    <ion-icon name="search-outline"
                        class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></ion-icon>
                </form>

                <button @click="setCreate()"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-red-600/20 active:scale-95">
                    Create Member
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse($members as $item)
                <div
                    class="group relative bg-white/2 border border-white/5 rounded-2xl p-4 hover:bg-white/4 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="relative h-14 w-14 shrink-0 rounded-xl overflow-hidden border border-white/10">
                            <img src="{{ $item->preview_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($item->full_name) . '&background=dc2626&color=fff' }}"
                                class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                        </div>

                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-black text-white truncate italic tracking-tighter">
                                {{ $item->full_name }}</h4>
                            <p class="text-[9px] text-red-600 font-bold uppercase tracking-widest mt-0.5">
                                {{ $item->npm }}</p>
                            <div class="flex items-center justify-between gap-2 mt-1">
                                <span
                                    class="text-[8px] px-1.5 py-0.5 rounded bg-white/5 text-gray-400 font-black uppercase">{{ $item->generation?->year ?? 'N/A' }}</span>

                                <div>
                                    @if ($item->is_active)
                                        <span
                                            class="flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-green-500/10 border border-green-500/20 text-[7px] font-black text-green-500 uppercase tracking-widest">
                                            <span class="w-1 h-1 rounded-full bg-green-500 animate-pulse"></span> Active
                                        </span>
                                    @else
                                        <span
                                            class="flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-orange-500/10 border border-orange-500/20 text-[7px] font-black text-orange-500 uppercase tracking-widest">
                                            <span class="w-1 h-1 rounded-full bg-orange-500"></span> Alumnus
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-between border-t border-white/5 pt-3">
                        <div class="flex gap-3 text-gray-500">
                            @if ($item->instagram_url)
                                <a href="{{ $item->instagram_url }}" target="_blank"
                                    class="hover:text-red-500 transition-colors"><ion-icon name="logo-instagram"
                                        class="text-sm"></ion-icon></a>
                            @endif
                            @if ($item->linkedin_url)
                                <a href="{{ $item->linkedin_url }}" target="_blank"
                                    class="hover:text-red-500 transition-colors"><ion-icon name="logo-linkedin"
                                        class="text-sm"></ion-icon></a>
                            @endif
                        </div>
                        <div class="flex gap-1">
                            <button @click="setEdit(@js($item))"
                                class="h-8 w-8 flex items-center justify-center rounded-lg bg-white/5 hover:bg-red-600 hover:text-white transition-colors border border-white/5">
                                <ion-icon name="create-outline" class="text-xs"></ion-icon>
                            </button>
                            <form action="{{ route('admin.members.destroy', $item->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Hapus anggota ini?')">
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
                    <p class="text-[10px] font-black uppercase tracking-[0.4em]">Tidak ada data anggota ditemukan</p>
                </div>
            @endforelse
        </div>

        <div class="pt-6">
            {{ $members->links() }}
        </div>

        <x-modal-form>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-5">
                    <div class="space-y-1.5">
                        <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Nama
                            Lengkap</label>
                        <input type="text" name="full_name" x-model="full_name" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 px-6 text-xs text-white focus:border-red-600 outline-none transition-all font-bold tracking-tighter italic">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label
                                class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">NPM</label>
                            <input type="text" name="npm" x-model="npm" required
                                class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 px-6 text-xs text-white focus:border-red-600 outline-none transition-all font-mono">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Role
                                Akses</label>
                            <select name="role" x-model="role" required
                                class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 px-6 text-xs text-white outline-none focus:border-red-600 appearance-none">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" class="bg-gray-950">{{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1.5 pt-2 border-t border-white/5">
                        <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Email</label>
                        <input type="email" name="email" x-model="email" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 px-6 text-xs text-white focus:border-red-600 outline-none">
                    </div>

                    <div class="space-y-1.5">
                        <label
                            class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Password</label>
                        <input type="password" name="password" x-model="password" :required="!editMode"
                            class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 px-6 text-xs text-white focus:border-red-600 outline-none"
                            :placeholder="editMode ? 'Kosongkan jika tidak ingin mengubah' : 'Minimal 8 karakter'">
                    </div>
                </div>

                <div class="space-y-5">
                    <div class="grid grid-cols-1 gap-4">

                        <div class="space-y-1.5">
                            <label
                                class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Angkatan</label>
                            <select name="generation_id" x-model="generation_id" required
                                class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 px-6 text-xs text-white outline-none focus:border-red-600 appearance-none">
                                <option value="" class="bg-gray-950">PILIH</option>
                                @foreach ($generations as $gen)
                                    <option value="{{ $gen->id }}" class="bg-gray-950">{{ $gen->year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Status
                            Keanggotaan</label>
                        <label
                            class="flex items-center justify-between px-4 py-3 rounded-xl bg-white/2 border border-white/5 cursor-pointer hover:border-red-600/30 transition-all">
                            <span class="text-[8px] font-bold text-gray-400 uppercase"
                                x-text="is_active ? 'Aktif' : 'Alumni'"></span>
                            <div class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="is_active" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-0.5 after:bg-gray-500 after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600 peer-checked:after:bg-white">
                                </div>
                            </div>
                        </label>
                        <input type="hidden" name="is_active" :value="is_active ? 1 : 0">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Foto Profil
                            (Optional)</label>
                        <div
                            class="relative h-32 border-2 border-dashed border-white/10 rounded-3xl bg-white/1 flex items-center justify-center overflow-hidden group hover:border-red-600/30 transition-all">
                            <input type="file" name="avatar"
                                class="absolute inset-0 opacity-0 z-20 cursor-pointer"
                                @change="imageUrl = URL.createObjectURL($event.target.files[0])" accept="image/*">
                            <template x-if="imageUrl">
                                <img :src="imageUrl" class="absolute inset-0 w-full h-full object-cover z-10">
                            </template>
                            <div x-show="!imageUrl"
                                class="text-center opacity-30 group-hover:opacity-60 transition-opacity">
                                <ion-icon name="camera-outline" class="text-2xl mb-1"></ion-icon>
                                <p class="text-[8px] font-black uppercase tracking-widest">Klik / Drop Foto</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="relative">
                            <ion-icon class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm"
                                name="logo-instagram"></ion-icon>
                            <input type="text" name="instagram_url" x-model="instagram_url"
                                class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-10 text-xs text-white focus:border-red-600 outline-none transition-all"
                                placeholder="Link Instagram (Optional)">
                        </div>
                        <div class="relative">
                            <ion-icon class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm"
                                name="logo-linkedin"></ion-icon>
                            <input type="text" name="linkedin_url" x-model="linkedin_url"
                                class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-10 text-xs text-white focus:border-red-600 outline-none transition-all"
                                placeholder="Link Linkedin (Optional)">
                        </div>
                    </div>
                </div>
            </div>
        </x-modal-form>
    </div>
</x-app-layout>
