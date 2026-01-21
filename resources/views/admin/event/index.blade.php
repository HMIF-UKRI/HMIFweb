<x-app-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Events - HMIF UKRI',
            'description' =>
                'Portal Internal Pengurus HMIF UKRI untuk mengelola konten dan kegiatan organisasi secara efisien.',
            'keywords' => 'hmif, ukri, himatif, hima, informatika, kegiatan, agenda, seminar, workshop',
            'image' => asset('images/banner-kegiatan.png'),
            'url' => url()->current(),
        ])
    </x-slot>

    <x-slot name="header_title">
        Events Management
    </x-slot>

    <div x-data="eventHandler()">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-black text-white tracking-tight uppercase">Daftar Kegiatan</h1>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">
                    Manage your organization events
                </p>
            </div>

            <div class="flex gap-3">
                <form method="GET" action="{{ route('admin.events.index') }}" class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="SEARCH EVENT..."
                        class="bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 pl-10 text-[10px] font-bold text-white uppercase tracking-widest focus:border-red-600 focus:w-64 w-40 transition-all outline-none placeholder-gray-700">
                    <ion-icon name="search-outline"
                        class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-600 group-focus-within:text-red-600 transition-colors"></ion-icon>
                </form>

                <a href="{{ route('admin.events.create') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-red-900/20 transition-all hover:scale-105 flex items-center gap-2">
                    <ion-icon name="add-circle-outline" class="text-base"></ion-icon>
                    <span>New Event</span>
                </a>
            </div>
        </div>

        {{-- Filters (Optional, based on Controller) --}}
        <div class="flex gap-2 mb-6 overflow-x-auto pb-2 scrollbar-hide">
            <a href="{{ route('admin.events.index') }}"
                class="px-4 py-2 rounded-lg border {{ !request('category_id') ? 'bg-red-600/10 border-red-600 text-red-500' : 'bg-white/5 border-white/5 text-gray-500 hover:bg-white/10' }} text-[9px] font-black uppercase tracking-widest transition-all whitespace-nowrap">
                All Categories
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('admin.events.index', ['category_id' => $cat->id]) }}"
                    class="px-4 py-2 rounded-lg border {{ request('category_id') == $cat->id ? 'bg-red-600/10 border-red-600 text-red-500' : 'bg-white/5 border-white/5 text-gray-500 hover:bg-white/10' }} text-[9px] font-black uppercase tracking-widest transition-all whitespace-nowrap">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        {{-- Events Grid Card --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($events as $event)
                <div
                    class="group relative bg-gray-900/40 border border-white/5 hover:border-red-600/30 rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1">

                    {{-- Thumbnail Image --}}
                    <div class="relative h-48 overflow-hidden">
                        <div class="absolute inset-0 bg-linear-to-t from-gray-900 to-transparent z-10 opacity-90">
                        </div>
                        <img src="{{ $event->getFirstMediaUrl('thumbnails', 'thumb') ?: 'https://via.placeholder.com/640x360.png?text=No+Image' }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                        {{-- Badges --}}
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

                    {{-- Content --}}
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

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-between mt-6 pt-4 border-t border-white/5">
                            <a href="{{ route('admin.events.show', $event->id) }}"
                                class="text-[9px] font-black text-gray-500 hover:text-white uppercase tracking-widest transition-colors">
                                View Details
                            </a>
                            <div class="flex items-center gap-2">
                                <button @click='setEdit(@json($event))'
                                    class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 hover:border-yellow-500/50 hover:text-yellow-500 flex items-center justify-center transition-all">
                                    <ion-icon name="create-outline"></ion-icon>
                                </button>
                                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this event?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 hover:border-red-500/50 hover:text-red-500 flex items-center justify-center transition-all">
                                        <ion-icon name="trash-outline"></ion-icon>
                                    </button>
                                </form>
                            </div>
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

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $events->links() }}
        </div>

        {{-- Modal Form --}}
        <x-modal-form>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left Column: Image & Basic Info --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Thumbnail Upload --}}
                    <div class="space-y-2">
                        <label
                            class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Thumbnail</label>
                        <div
                            class="relative aspect-video border-2 border-dashed border-white/10 rounded-2xl bg-white/2 flex items-center justify-center overflow-hidden group hover:border-red-600/30 transition-all">
                            <input type="file" name="thumbnail"
                                class="absolute inset-0 opacity-0 z-20 cursor-pointer" @change="fileChosen"
                                accept="image/*" :required="!editMode">

                            <template x-if="imageUrl">
                                <img :src="imageUrl" class="absolute inset-0 w-full h-full object-cover z-10">
                            </template>

                            <div x-show="!imageUrl"
                                class="text-center opacity-30 group-hover:opacity-60 transition-opacity">
                                <ion-icon name="image-outline" class="text-3xl mb-2"></ion-icon>
                                <p class="text-[8px] font-black uppercase tracking-widest">Upload Image</p>
                                <p class="text-[8px] text-gray-500 mt-1">Max 2MB</p>
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="space-y-1.5">
                        <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Status</label>
                        <select name="status" x-model="status" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600 appearance-none uppercase font-bold">
                            <option value="upcoming" class="bg-gray-950 text-blue-400">Upcoming</option>
                            <option value="ongoing" class="bg-gray-950 text-emerald-400">Ongoing</option>
                            <option value="completed" class="bg-gray-950 text-gray-400">Completed</option>
                            <option value="cancelled" class="bg-gray-950 text-red-400">Cancelled</option>
                        </select>
                    </div>

                    {{-- Category --}}
                    <div class="space-y-1.5">
                        <label
                            class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Kategori</label>
                        <select name="event_category_id" x-model="event_category_id" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600 appearance-none">
                            <option value="" class="bg-gray-950">Select Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" class="bg-gray-950">
                                    {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Right Column: Details --}}
                <div class="lg:col-span-2 space-y-5">
                    <div class="space-y-1.5">
                        <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Nama
                            Kegiatan</label>
                        <input type="text" name="title" x-model="title" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 px-6 text-sm font-bold text-white focus:border-red-600 outline-none transition-all placeholder-gray-600"
                            placeholder="Contoh: Workshop Laravel 2026">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label
                                class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Tanggal</label>
                            <input type="datetime-local" name="event_date" x-model="event_date" required
                                class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white focus:border-red-600 outline-none transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Lokasi</label>
                            <input type="text" name="location" x-model="location" required
                                class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white focus:border-red-600 outline-none transition-all"
                                placeholder="Contoh: Aula Kampus A">
                        </div>
                    </div>

                    <div class="space-y-1.5" wire:ignore>
                        <label
                            class="text-[9px] font-black text-gray-500 uppercase tracking-widest ml-1">Deskripsi</label>
                        <div class="prose-editor">
                            <textarea id="description" name="description"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </x-modal-form>
    </div>

    @push('styles')
        <style>
            .ck-editor__editable_inline {
                min-height: 200px;
                background-color: rgba(255, 255, 255, 0.05) !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
                border-radius: 0 0 0.75rem 0.75rem !important;
                color: #e5e7eb !important;
                padding: 1rem !important;
            }

            .ck-toolbar {
                background-color: rgba(255, 255, 255, 0.05) !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
                border-radius: 0.75rem 0.75rem 0 0 !important;
            }

            .ck.ck-button {
                color: #d1d5db !important;
            }

            .ck.ck-button:hover,
            .ck.ck-button.ck-on {
                background-color: rgba(255, 255, 255, 0.1) !important;
                color: #fff !important;
            }

            /* Hide scrollbar for category filter */
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

        <script>
            let editorInstance;

            ClassicEditor
                .create(document.querySelector('#description'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote',
                        'undo', 'redo'
                    ],
                    placeholder: 'Tulis deskripsi kegiatan di sini...'
                })
                .then(editor => {
                    editorInstance = editor;

                    editor.model.document.on('change:data', () => {
                        document.querySelector('#description').value = editor.getData();
                    });
                })
                .catch(error => {
                    console.error(error);
                });

            function eventHandler() {
                return {
                    openModal: false,
                    editMode: false,
                    formAction: '',

                    title: '',
                    location: '',
                    status: 'upcoming',
                    event_date: '',
                    event_category_id: '',
                    imageUrl: null,

                    setCreate() {
                        this.editMode = false;
                        this.openModal = true;
                        this.formAction = "{{ route('admin.events.store') }}";

                        this.title = '';
                        this.location = '';
                        this.status = 'upcoming';
                        this.event_date = '';
                        this.event_category_id = '';
                        this.imageUrl = null;

                        // Reset CKEditor
                        if (editorInstance) {
                            editorInstance.setData('');
                        }
                    },

                    setEdit(item) {
                        this.editMode = true;
                        this.openModal = true;
                        this.formAction = `/admin/events/${item.id}`;

                        this.title = item.title;
                        this.location = item.location;
                        this.status = item.status;
                        this.event_category_id = item.event_category_id;

                        let date = new Date(item.event_date);
                        this.event_date = item.event_date.substring(0, 16);

                        this.imageUrl = null;

                        if (editorInstance) {
                            editorInstance.setData(item.description || '');
                        }
                    },

                    fileChosen(event) {
                        this.fileToDataUrl(event, src => this.imageUrl = src)
                    },

                    fileToDataUrl(event, callback) {
                        if (!event.target.files.length) return
                        let file = event.target.files[0],
                            reader = new FileReader()
                        reader.readAsDataURL(file)
                        reader.onload = e => callback(e.target.result)
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
