<x-app-layout>
    <div x-data="{
        openModal: false,
        editMode: false,
        activeTab: 'blog',
        formAction: '',
    
        name: '',
        description: '',
    
        initEdit(item, type) {
            this.editMode = true;
            this.activeTab = type;
            this.formAction = `/admin/categories/${item.slug}`;
            this.name = item.name;
            this.openModal = true;
        },
    
        initCreate(type) {
            this.editMode = false;
            this.activeTab = type;
            this.formAction = '{{ route('admin.categories.store') }}';
            this.name = '';
            this.openModal = true;
        },
    
    
    }" class="space-y-6">

        <div class="flex items-center justify-between bg-black/40 p-2 rounded-2xl border border-white/5">
            <div class="flex gap-2">
                @foreach (['blog' => 'Blog', 'event' => 'Event', 'porto' => 'Portofolio'] as $key => $label)
                    <button @click="activeTab = '{{ $key }}'"
                        :class="activeTab === '{{ $key }}' ? 'bg-red-600 text-white' :
                            'text-gray-500 hover:text-gray-300'"
                        class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <button @click="initCreate(activeTab)"
                class="flex items-center gap-2 px-6 py-2.5 bg-white/5 hover:bg-white/10 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all border border-white/10">
                <i class="fa-solid fa-plus text-red-600"></i> New Category
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($blogCategory as $cat)
                <div x-show="activeTab === 'blog'"
                    class="group relative bg-gray-900/40 border border-white/5 rounded-4xl p-6 backdrop-blur-sm transition-all hover:border-red-600/30 hover:shadow-2xl hover:shadow-red-600/10">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 bg-red-600/10 rounded-2xl text-red-600">
                            <ion-icon name="newspaper-outline" class="text-2xl"></ion-icon>
                        </div>
                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="initEdit({{ $cat }}, 'blog')"
                                class="p-2 text-gray-400 hover:text-white"><ion-icon
                                    name="pencil-outline"></ion-icon></button>
                            <form action="{{ route('admin.categories.destroy', $cat->slug) }}" method="POST"
                                onsubmit="return confirm('Hapus Categori ini?')">
                                @csrf @method('DELETE')
                                <input type="hidden" name="type" :value="activeTab">
                                <button class="p-2 text-gray-400 hover:text-red-500" type="submit"><ion-icon
                                        name="trash-outline"></ion-icon></button>
                            </form>
                        </div>
                    </div>
                    <h3 class="text-white font-black uppercase tracking-widest text-sm mb-1">{{ $cat->name }}</h3>
                    <p class="text-[10px] text-gray-500 font-bold italic mb-4">{{ $cat->slug }}</p>
                    <div class="flex items-center gap-2 py-2 px-4 bg-black/40 rounded-full w-fit">
                        <span class="text-[9px] font-black text-red-600">{{ $cat->blogs_count }}</span>
                        <span class="text-[9px] font-black text-gray-600 uppercase tracking-widest">Articles
                            Attached</span>
                    </div>
                </div>
            @endforeach

            @foreach ($eventCategory as $cat)
                <div x-show="activeTab === 'event'"
                    class="group relative bg-gray-900/40 border border-white/5 rounded-4xl p-6 transition-all hover:border-red-600/30">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 bg-red-600/10 rounded-2xl text-red-600"><ion-icon name="calendar-outline"
                                class="text-2xl"></ion-icon></div>
                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="initEdit({{ $cat }}, 'event')"
                                class="p-2 text-gray-400 hover:text-white"><ion-icon
                                    name="pencil-outline"></ion-icon></button>
                            <form action="{{ route('admin.categories.destroy', $cat->slug) }}" method="POST"
                                onsubmit="return confirm('Hapus Categori ini?')">
                                @csrf @method('DELETE')
                                <input type="hidden" name="type" :value="activeTab">
                                <button class="p-2 text-gray-400 hover:text-red-500" type="submit"><ion-icon
                                        name="trash-outline"></ion-icon></button>
                            </form>
                        </div>
                    </div>
                    <h3 class="text-white font-black uppercase tracking-widest text-sm mb-1">{{ $cat->name }}</h3>
                    <p class="text-[10px] text-gray-500 font-bold italic mb-4">{{ $cat->slug }}</p>
                    <div class="flex items-center gap-2 py-2 px-4 bg-black/40 rounded-full w-fit">
                        <span class="text-[9px] font-black text-red-600">{{ $cat->events_count }}</span>
                        <span class="text-[9px] font-black text-gray-600 uppercase tracking-widest">Events Listed</span>
                    </div>
                </div>
            @endforeach

            @foreach ($portofolioCategory as $cat)
                <div x-show="activeTab === 'porto'"
                    class="group relative bg-gray-900/40 border border-white/5 rounded-4xl p-6 transition-all hover:border-red-600/30">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 bg-red-600/10 rounded-2xl text-red-600"><ion-icon name="briefcase-outline"
                                class="text-2xl"></ion-icon></div>
                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="initEdit({{ $cat }}, 'porto')"
                                class="p-2 text-gray-400 hover:text-white"><ion-icon
                                    name="pencil-outline"></ion-icon></button>
                            <form action="{{ route('admin.categories.destroy', $cat->slug) }}" method="POST"
                                onsubmit="return confirm('Hapus Categori ini?')">
                                @csrf @method('DELETE')
                                <input type="hidden" name="type" :value="activeTab">
                                <button class="p-2 text-gray-400 hover:text-red-500" type="submit"><ion-icon
                                        name="trash-outline"></ion-icon></button>
                            </form>
                        </div>
                    </div>
                    <h3 class="text-white font-black uppercase tracking-widest text-sm mb-1">{{ $cat->name }}</h3>
                    <div class="flex items-center gap-2 py-2 px-4 bg-black/40 rounded-full w-fit">
                        <span class="text-[9px] font-black text-red-600">{{ $cat->portofolios_count }}</span>
                        <span class="text-[9px] font-black text-gray-600 uppercase tracking-widest">Projects
                            Showcased</span>
                    </div>
                </div>
            @endforeach

        </div>

        <x-modal-form>
            <template x-if="editMode"><input type="hidden" name="_method" value="PATCH"></template>
            <input type="hidden" name="type" :value="activeTab">

            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-600 uppercase tracking-widest ml-1">Category
                        Title</label>
                    <input type="text" name="name" x-model="name" required
                        class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-sm text-white focus:border-red-600 outline-none transition-all placeholder:text-gray-800"
                        placeholder="e.g. Workshop, Seminar, Web Tech">
                </div>
            </div>
        </x-modal-form>

    </div>
</x-app-layout>
