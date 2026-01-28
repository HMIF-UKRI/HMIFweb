<x-app-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Pengurus - HMIF UKRI',
            'description' =>
                'Portal Internal Pengurus HMIF UKRI untuk mengelola konten dan kegiatan organisasi secara efisien.',
            'keywords' => 'hmif, ukri, himatif, hima, informatika, kegiatan, agenda, seminar, workshop',
            'image' => asset('images/banner-kegiatan.png'),
            'url' => url()->current(),
        ])
    </x-slot>

    <x-slot name="header_title">Organization / Pengurus</x-slot>

    <div class="space-y-6" x-data="pengurusForm">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-white/5 pb-6">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-red-600 font-black uppercase text-[10px] tracking-[0.3em]">
                    <span class="w-8 h-0.5 bg-red-600 shadow-[0_0_10px_rgba(220,38,38,0.5)]"></span>
                    <span>HMIF UKRI</span>
                </div>
                <h3 class="text-2xl font-black text-white uppercase tracking-tighter">
                    Data <span class="text-red-600 italic">Pengurus</span>
                </h3>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">
                    {{ $pengurus->total() }} Data Pengurus</p>
            </div>
            <button @click="setCreate()"
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-red-600/20 active:scale-95">
                Add Member
            </button>
        </div>

        <div class="">
            <form method="GET" action="{{ route('admin.managements.index') }}" class="flex items-center gap-3">
                <label for="period_id" class="text-[9px] font-black text-gray-500 uppercase tracking-widest">Filter By
                    Period:</label>
                <select name="period_id" id="period_id" onchange="this.form.submit()"
                    class="bg-white/5 border border-white/10 rounded-xl py-2 px-4 text-xs text-white outline-none focus:border-red-600 appearance-none">
                    <option value="" class="bg-gray-950" {{ request('period_id') == '' ? 'selected' : '' }}>All
                        Periods</option>
                    @foreach ($periods as $p)
                        <option value="{{ $p->id }}" class="bg-gray-950"
                            {{ request('period_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->cabinet_name }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4">
            @forelse($pengurus as $item)
                <div
                    class="group relative bg-white/2 border border-white/5 rounded-2xl overflow-hidden hover:bg-white/4 transition-all duration-300 flex">

                    <div class="w-32 h-32 flex-shrink-0 overflow-hidden border-r border-white/5">
                        <img src="{{ $item->preview_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($item->member->full_name) . '&background=dc2626&color=fff' }}"
                            class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300">
                    </div>

                    <div class="flex-1 p-4 flex flex-col">
                        <div class="flex-1 flex flex-col">
                            <h4 class="text-sm font-black text-white line-clamp-2 italic tracking-tighter">
                                {{ $item->member->full_name }}</h4>
                            <p class="text-[9px] text-red-600 font-bold uppercase line-clamp-2 tracking-tight mt-1">
                                {{ $item->position }}</p>
                            <p class="text-[8px] text-gray-500 font-medium line-clamp-2 mt-1">
                                {{ $item->bidang->name ?? $item->department->name }}</p>
                        </div>

                        <div class="w-full mt-3 flex items-center justify-between border-t border-white/5 pt-3">
                            <span
                                class="text-[8px] font-black px-2 py-0.5 rounded bg-white/5 text-gray-400 uppercase tracking-widest">
                                Lvl {{ $item->hierarchy_level }}
                            </span>
                            <div class="flex gap-3">
                                <button @click="setEdit({{ $item->toJson() }})"
                                    class="h-7 w-7 flex items-center justify-center rounded-lg bg-white/5 hover:bg-red-600 hover:text-white transition-colors">
                                    <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                </button>
                                <form action="{{ route('admin.managements.destroy', $item->id) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Hapus pengurus ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="h-8 w-8 flex items-center justify-center rounded-lg bg-white/5 hover:bg-red-600 hover:text-white transition-colors border border-white/5">
                                        <ion-icon name="trash-outline" class="text-xs"></ion-icon>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full py-12 text-center border-2 border-dashed border-white/5 rounded-3xl opacity-30">
                    <p class="text-[10px] font-black uppercase tracking-[0.4em]">Empty Structural List</p>
                </div>
            @endforelse
        </div>

        {{ $pengurus->links() }}

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
            <input type="hidden" name="member_mode" :value="member_mode">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="space-y-1.5" x-show="!editMode">
                        <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Mode
                            Anggota</label>
                        <div class="flex gap-2">
                            <button type="button" @click="member_mode = 'existing'"
                                :class="member_mode === 'existing' ? 'bg-red-600 text-white' : 'bg-white/5 text-gray-400'"
                                class="px-3 py-2 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all">
                                Pilih Anggota
                            </button>
                            <button type="button" @click="member_mode = 'new'"
                                :class="member_mode === 'new' ? 'bg-red-600 text-white' : 'bg-white/5 text-gray-400'"
                                class="px-3 py-2 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all">
                                Buat Anggota Baru
                            </button>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Anggota
                            HMIF</label>
                        <select name="member_id" x-model="member_id"
                            x-show="member_mode === 'existing' || editMode"
                            :required="member_mode === 'existing' || editMode"
                            class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600 appearance-none">
                            <option value="" class="bg-gray-950">Select Member</option>
                            @foreach ($members as $m)
                                <option value="{{ $m->id }}" class="bg-gray-950">{{ $m->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-3" x-show="member_mode === 'new' && !editMode">
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Nama
                                Lengkap</label>
                            <input type="text" name="new_member_full_name" x-model="new_member_full_name"
                                :required="member_mode === 'new'"
                                class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">NPM</label>
                                <input type="text" name="new_member_npm" x-model="new_member_npm"
                                    :required="member_mode === 'new'"
                                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600">
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Angkatan</label>
                                <select name="new_member_generation_id" x-model="new_member_generation_id"
                                    :required="member_mode === 'new'"
                                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600 appearance-none">
                                    <option value="" class="bg-gray-950">Pilih</option>
                                    @foreach ($generations as $gen)
                                        <option value="{{ $gen->id }}" class="bg-gray-950">{{ $gen->year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Email</label>
                            <input type="email" name="new_member_email" x-model="new_member_email"
                                :required="member_mode === 'new'"
                                class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="space-y-1.5">
                                <label
                                    class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Password</label>
                                <input type="password" name="new_member_password" x-model="new_member_password"
                                    placeholder="Optional"
                                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Role</label>
                                <select name="new_member_role" x-model="new_member_role"
                                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600 appearance-none">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" class="bg-gray-950">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1.5">
                            <label
                                class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Hierarchy</label>
                            <select name="hierarchy_level" x-model="hierarchy_level"
                                class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white appearance-none outline-none">
                                @for ($i = 1; $i <= 3; $i++)
                                    <option value="{{ $i }}" class="bg-gray-950">{{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Periode
                                Kepengurusan</label>
                            <select name="period_id" x-model="period_id"
                                class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white appearance-none outline-none">
                                @foreach ($periods as $p)
                                    <option value="{{ $p->id }}" class="bg-gray-950">{{ $p->cabinet_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Foto
                            Pengurus</label>
                        <div
                            class="relative h-28 border-2 border-dashed border-white/10 rounded-2xl flex items-center justify-center bg-white/1 overflow-hidden group">
                            <input type="file" name="card" class="absolute inset-0 opacity-0 z-20 cursor-pointer"
                                @change="imageUrl = URL.createObjectURL($event.target.files[0])" accept="image/*">

                            <template x-if="imageUrl">
                                <img :src="imageUrl"
                                    class="absolute inset-0 w-full h-full object-contain z-10 transition-all">
                            </template>

                            <div x-show="!imageUrl" class="text-center opacity-30">
                                <i class="fa-solid fa-camera text-xl mb-1"></i>
                                <p class="text-[7px] font-black uppercase">Upload Photo</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 border-t border-white/5 pt-4">
                <div class="space-y-1.5">
                    <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Jabatan</label>
                    <input type="text" name="position" x-model="position" placeholder="Contoh: Kepala Departemen"
                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white">
                </div>
                <div class="space-y-1.5">
                    <label
                        class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Departemen</label>
                    <select name="department_id" x-model="department_id"
                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white appearance-none outline-none">
                        @foreach ($departments as $d)
                            <option value="{{ $d->id }}" class="bg-gray-950">{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Bidang
                        (Optional)</label>
                    <select name="bidang_id" x-model="bidang_id" :disabled="hierarchy_level != 3"
                        :required="hierarchy_level == 3"
                        :class="hierarchy_level != 3 ? 'opacity-50 cursor-not-allowed' : ''"
                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white appearance-none outline-none transition-opacity">
                        <option value="" class="bg-gray-950">Select Bidang</option>
                        @foreach ($bidangs as $b)
                            <option value="{{ $b->id }}" class="bg-gray-950">{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </x-modal-form>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('pengurusForm', () => ({
                openModal: @json($errors->any()),
                editMode: false,
                formAction: @json(route('admin.managements.store')),
                imageUrl: null,

                member_mode: @json(old('member_id') ? 'existing' : (old('new_member_full_name') ? 'new' : 'existing')),
                member_id: @json(old('member_id')),
                period_id: @json(old('period_id')),
                department_id: @json(old('department_id')),
                bidang_id: @json(old('bidang_id')),
                hierarchy_level: @json(old('hierarchy_level')),
                position: @json(old('position')),

                new_member_full_name: @json(old('new_member_full_name')),
                new_member_npm: @json(old('new_member_npm')),
                new_member_email: @json(old('new_member_email')),
                new_member_password: '',
                new_member_generation_id: @json(old('new_member_generation_id')),
                new_member_role: @json(old('new_member_role') ?? 'pengurus'),

                setEdit(item) {
                    this.editMode = true;
                    this.formAction = `/admin/managements/${item.id}`;
                    this.member_id = item.member_id;
                    this.period_id = item.period_id;
                    this.department_id = item.department_id;
                    this.bidang_id = item.bidang_id || '';
                    this.hierarchy_level = item.hierarchy_level;
                    this.position = item.position;

                    this.member_mode = 'existing';
                    this.new_member_full_name = '';
                    this.new_member_npm = '';
                    this.new_member_email = '';
                    this.new_member_password = '';
                    this.new_member_generation_id = '';
                    this.new_member_role = 'pengurus';

                    this.imageUrl = item.preview_url;
                    this.openModal = true;
                },

                setCreate() {
                    this.editMode = false;
                    this.formAction = @json(route('admin.managements.store'));
                    this.member_mode = 'existing';
                    this.member_id = '';
                    this.period_id = '';
                    this.department_id = '';
                    this.bidang_id = '';
                    this.hierarchy_level = '';
                    this.position = '';
                    this.new_member_full_name = '';
                    this.new_member_npm = '';
                    this.new_member_email = '';
                    this.new_member_password = '';
                    this.new_member_generation_id = '';
                    this.new_member_role = 'pengurus';
                    this.imageUrl = null;
                    this.openModal = true;
                },
            }));
        });
    </script>
</x-app-layout>
