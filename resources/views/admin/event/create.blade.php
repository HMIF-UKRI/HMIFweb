<x-app-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Create Event - HMIF UKRI',
            'description' =>
                'Portal Internal Pengurus HMIF UKRI untuk mengelola konten dan kegiatan organisasi secara efisien.',
            'keywords' => 'hmif, ukri, himatif, hima, informatika, kegiatan, agenda, seminar, workshop',
            'image' => asset('images/banner-kegiatan.png'),
            'url' => url()->current(),
        ])
    </x-slot>

    <x-slot name="header_title">Content / Events / Create</x-slot>

    <div x-data="{ imageUrl: null, status: 'upcoming' }" class="relative pb-24">
        <a href="{{ route('admin.events.index') }}"
            class="inline-flex items-center gap-2 text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] hover:text-red-600 transition-colors">
            <ion-icon name="arrow-back-outline"></ion-icon>
            Back to Events
        </a>
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" id="eventForm">
            @csrf
            <input type="hidden" name="description" id="descriptionInput">

            <div class="flex flex-col lg:flex-row gap-8 items-start">

                <div
                    class="flex-1 w-full bg-white/2 border border-white/5 rounded-[3rem] p-8 md:p-16 shadow-2xl backdrop-blur-sm min-h-200">
                    <div class="max-w-3xl mx-auto space-y-4">

                        <div class="space-y-4">
                            <div class="group relative">
                                <label
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1 mb-2 block">Judul
                                    Kegiatan</label>
                                <textarea name="title" rows="1" required
                                    class="w-full bg-transparent border-none p-0 text-3xl md:text-4xl font-black text-white placeholder:text-white/10 outline-none resize-none overflow-hidden"
                                    placeholder="Judul Kegiatan..." oninput="this.style.height = '';this.style.height = this.scrollHeight + 'px'">{{ old('title', $event->title ?? '') }}</textarea>
                                <div
                                    class="h-1 w-20 bg-red-600 rounded-full shadow-[0_0_15px_rgba(220,38,38,0.5)] transition-all group-focus-within:w-full">
                                </div>
                            </div>

                            <div class="group relative">
                                <label
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1 mb-2 block">Deskripsi
                                    Singkat (Gausah panjang panjang)</label>
                                <textarea name="short_description" rows="2" required maxlength="255"
                                    class="w-full bg-transparent border-none p-0 text-base md:text-lg font-medium text-gray-400 placeholder:text-white/5 outline-none resize-none overflow-hidden"
                                    placeholder="Masukan deskripsi singkat...">{{ old('short_description', $event->short_description ?? '') }}</textarea>
                            </div>
                        </div>
                        <label
                            class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1 mb-2 block">Deskripsi</label>
                        <div id="editorjs" data-upload-url="{{ route('admin.events.upload-image') }}"
                            class="text-white"></div>
                    </div>
                </div>

                <div class="w-full lg:w-95 space-y-6 sticky top-24">
                    <div class="bg-gray-900 border border-white/10 rounded-[2.5rem] p-8 space-y-8 shadow-2xl">
                        <div class="space-y-6">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-red-600 rounded-full"></span>
                                <h4 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.3em]">Event
                                    Identity</h4>
                            </div>

                            <div class="space-y-5">
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">Kategori</label>
                                    <select name="event_category_id" required
                                        class="w-full bg-white/5 border border-white/10 rounded-2xl py-3.5 px-6 text-xs text-white focus:border-red-600 outline-none transition-all appearance-none">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('event_category_id') == $category->id ? 'selected' : '' }}
                                                class="bg-gray-950">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="space-y-1.5">
                                    <label
                                        class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">Status
                                        Publikasi</label>
                                    <select name="status" x-model="status" required
                                        class="w-full bg-white/5 border border-white/10 rounded-2xl py-3.5 px-6 text-xs text-white outline-none appearance-none focus:border-red-600">
                                        <option value="upcoming" class="bg-gray-950">UPCOMING</option>
                                        <option value="ongoing" class="bg-gray-950">ONGOING</option>
                                        <option value="completed" class="bg-gray-950">COMPLETED</option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">Tanggal</label>
                                        <input type="date" name="event_date" value="{{ old('event_date') }}" required
                                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-3.5 px-4 text-[10px] text-white outline-none">
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">Lokasi</label>
                                        <input type="text" name="location" value="{{ old('location') }}" required
                                            placeholder="e.g. Ruang Multimedia"
                                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-3.5 px-4 text-[10px] text-white outline-none">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 pt-4 border-t border-white/5">
                            <h4 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.3em]">Featured Media
                            </h4>
                            <div
                                class="relative h-48 border-2 border-dashed border-white/10 rounded-4xl bg-white/1 flex items-center justify-center overflow-hidden group hover:border-red-600/30 transition-all cursor-pointer">
                                <input type="file" name="thumbnail"
                                    class="absolute inset-0 opacity-0 z-20 cursor-pointer"
                                    @change="const file = $event.target.files[0]; if(file) imageUrl = URL.createObjectURL(file)"
                                    accept="image/*">
                                <template x-if="imageUrl">
                                    <img :src="imageUrl"
                                        class="absolute inset-0 w-full h-full object-cover z-10 transition-transform duration-500 group-hover:scale-110">
                                </template>
                                <div x-show="!imageUrl"
                                    class="text-center opacity-20 group-hover:opacity-100 transition-opacity">
                                    <ion-icon name="cloud-upload-outline" class="text-4xl mb-1"></ion-icon>
                                    <p class="text-[8px] font-black uppercase tracking-widest">Main Thumbnail</p>
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="saveEvent()"
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-5 rounded-3xl font-black text-[11px] uppercase tracking-[0.3em] transition-all shadow-2xl shadow-red-600/30 active:scale-95 border border-red-500/50">
                            Launch Event
                        </button>
                    </div>

                    <div class="text-center opacity-20">
                        <p class="text-[9px] font-black text-white uppercase tracking-[0.4em]">HMIF System Engine</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
