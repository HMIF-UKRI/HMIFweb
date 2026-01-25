<x-app-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Editing Article - ' . $blog->title,
            'description' => 'Sempurnakan narasi wawasan teknologi di HMIF Dashboard.',
        ])
    </x-slot>

    <x-slot name="header_title">Blogs / Edit Draft</x-slot>

    <div x-data="{
        imageUrl: '{{ $blog->getFirstMediaUrl('blog_thumbnails') }}',
        status: '{{ $blog->status }}'
    }" class="relative pb-32">

        @if (session('error'))
            <div
                class="bg-red-600/20 border border-red-600 text-red-500 px-6 py-4 rounded-2xl mb-8 text-xs font-bold uppercase tracking-widest">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.blogs.update', $blog->slug) }}" method="POST" enctype="multipart/form-data"
            id="blogForm">
            @csrf
            @method('PATCH')

            <input type="hidden" name="content" id="contentInput">

            <div
                class="sticky top-0 z-50 bg-gray-950/80 backdrop-blur-xl border-b border-white/5 -mx-8 px-8 py-4 mb-12 flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <a href="{{ route('admin.blogs.index') }}"
                        class="group flex items-center gap-2 text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] hover:text-white transition-all">
                        <ion-icon name="arrow-back-outline" class="text-lg"></ion-icon>
                        <span class="hidden md:inline">Exit Editor</span>
                    </a>
                    <div class="h-4 w-px bg-white/10"></div>
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Modifying
                            Article</span>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div
                        class="hidden sm:flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 rounded-xl">
                        <span class="text-[9px] font-black text-gray-500 uppercase tracking-widest">Status:</span>
                        <select name="status" x-model="status"
                            class="bg-transparent border-none text-[9px] font-black text-white uppercase tracking-widest focus:ring-0 p-0 cursor-pointer">
                            <option value="draft" class="bg-gray-950">Draft Concept</option>
                            <option value="published" class="bg-gray-950">Publish Live</option>
                        </select>
                    </div>

                    <button type="button" onclick="saveBlog()"
                        class="bg-red-600 hover:bg-red-700 text-white px-8 py-2.5 rounded-xl font-black text-[10px] uppercase tracking-[0.2em] transition-all shadow-lg shadow-red-600/20 active:scale-95">
                        Update Article
                    </button>
                </div>
            </div>

            <div class="writing-container space-y-12">

                <div class="relative group">
                    <div
                        class="relative h-100 w-full border-2 border-dashed border-white/10 rounded-[3rem] bg-white/1 flex items-center justify-center overflow-hidden transition-all group-hover:border-red-600/30">
                        <input type="file" name="thumbnail" class="absolute inset-0 opacity-0 z-20 cursor-pointer"
                            @change="const file = $event.target.files[0]; if(file) imageUrl = URL.createObjectURL(file)"
                            accept="image/*">

                        <template x-if="imageUrl">
                            <div class="contents">
                                <img :src="imageUrl"
                                    class="absolute inset-0 w-full h-full object-cover z-10 transition-transform duration-1000 group-hover:scale-105">
                                <div
                                    class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity z-15 flex items-center justify-center">
                                    <span
                                        class="px-6 py-2 bg-white/10 backdrop-blur-md rounded-full text-[10px] font-black text-white uppercase tracking-widest border border-white/20">
                                        Change Cover Image
                                    </span>
                                </div>
                            </div>
                        </template>

                        <div x-show="!imageUrl"
                            class="text-center opacity-20 group-hover:opacity-100 transition-all duration-500">
                            <ion-icon name="image-outline" class="text-6xl mb-4"></ion-icon>
                            <p class="text-[10px] font-black uppercase tracking-[0.4em]">Add Featured Image</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/2 border border-white/5 rounded-[4rem] p-8 md:p-20 shadow-2xl backdrop-blur-sm">
                    <div class="max-w-3xl mx-auto space-y-12">

                        <div class="flex flex-wrap items-center gap-4 border-b border-white/5 pb-8">
                            <div
                                class="flex items-center gap-2 px-4 py-2 bg-red-600/5 border border-red-600/20 rounded-full">
                                <span
                                    class="text-[9px] font-black text-red-500 uppercase tracking-widest">Category</span>
                                <select name="blog_category_id" required
                                    class="bg-transparent border-none text-[9px] font-black text-white uppercase tracking-widest focus:ring-0 p-0 cursor-pointer">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('blog_category_id', $blog->blog_category_id) == $category->id ? 'selected' : '' }}
                                            class="bg-gray-950">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="h-4 w-px bg-white/10"></div>
                            <span class="text-[9px] font-black text-gray-600 uppercase tracking-widest italic">
                                Author: Admin
                            </span>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-4 relative group">
                                <textarea name="title" rows="1" required
                                    class="title-textarea w-full bg-transparent border-none p-0 text-xl md:text-2xl font-black text-white placeholder-white/5 outline-none resize-none overflow-hidden leading-[1.1] italic tracking-tighter uppercase"
                                    placeholder="Enter Title..." oninput="this.style.height = '';this.style.height = this.scrollHeight + 'px'">{{ old('title', $blog->title) }}</textarea>
                                <div
                                    class="h-1 w-20 bg-red-600 rounded-full shadow-[0_0_15px_rgba(220,38,38,0.5)] transition-all duration-300 group-focus-within:w-full">
                                </div>
                            </div>

                            <textarea name="summary" rows="2" required maxlength="255"
                                class="summary-textarea w-full bg-transparent border-none p-0 text-base md:text-xl font-medium text-gray-400 placeholder-white/5 outline-none resize-none overflow-hidden leading-relaxed italic"
                                placeholder="Masukan ringkasan singkat artikel..."
                                oninput="this.style.height = '';this.style.height = this.scrollHeight + 'px'">{{ old('summary', $blog->summary) }}</textarea>
                        </div>

                        <div id="editorjs" data-upload-url="{{ route('admin.blogs.upload-image') }}"
                            data-initial='{!! $blog->content !!}' class="text-white min-h-100"></div>
                    </div>
                </div>

                <div class="text-center opacity-20 py-10">
                    <p class="text-[9px] font-black text-white uppercase tracking-[0.5em]">HMIF Dashboard &bull;
                        Metaforsa Editorial System</p>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
