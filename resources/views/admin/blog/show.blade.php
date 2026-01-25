<x-app-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => $blog->title . ' - Concept Preview',
            'description' => $blog->summary,
            'image' => $blog->getFirstMediaUrl('blog_thumbnails'),
        ])
    </x-slot>

    <x-slot name="header_title">Blogs / Article Preview</x-slot>

    <div class="max-w-5xl mx-auto space-y-12 pb-32">
        <a href="{{ route('admin.blogs.index') }}"
            class="inline-flex items-center gap-2 text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] hover:text-red-600 transition-colors">
            <ion-icon name="arrow-back-outline"></ion-icon> Return to Feed
        </a>

        <header class="space-y-10 text-center max-w-4xl mx-auto">
            <div class="flex justify-center items-center gap-3">
                <span
                    class="px-4 py-1.5 rounded-full bg-red-600/10 border border-red-600/20 text-[10px] font-black text-red-600 uppercase tracking-widest">
                    {{ $blog->category->name }}
                </span>
                <span class="w-1 h-1 rounded-full bg-gray-700"></span>
                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">
                    {{ $blog->status }}
                </span>
            </div>

            <h1
                class="text-xl md:text-3xl font-black text-white leading-tight italic tracking-tighter uppercase drop-shadow-2xl">
                {{ $blog->title }}
            </h1>

            <div
                class="flex flex-wrap justify-center items-center gap-8 text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">

                <div class="flex items-center gap-3">
                    <ion-icon name="calendar-outline" class="text-red-600 text-lg"></ion-icon>
                    {{ $blog->created_at->format('d F Y') }}
                </div>
                <div class="flex items-center gap-3 text-red-500">
                    <ion-icon name="eye-outline" class="text-lg"></ion-icon>
                    {{ $blog->views_count }} Views
                </div>
            </div>
        </header>

        @if ($blog->hasMedia('blog_thumbnails'))
            <div
                class="relative w-2xl mx-auto aspect-video rounded-[4rem] overflow-hidden border border-white/10 shadow-3xl shadow-black/50 group">
                <img src="{{ $blog->getFirstMediaUrl('blog_thumbnails') }}"
                    class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110">
                <div class="absolute inset-0 bg-linear-to-t from-gray-950/80 via-transparent to-transparent"></div>
            </div>
        @endif

        <div class="max-w-3xl mx-auto">
            <div class="p-8 md:p-12 border-l-4 border-red-600 bg-white/2 rounded-r-4xl">
                <p class="text-lg md:text-xl font-black text-white italic leading-tight opacity-90">
                    "{{ $blog->summary }}"
                </p>
            </div>
        </div>

        <article class="max-w-3xl mx-auto relative">
            <div id="editorjs-content"
                class="space-y-10 text-gray-400 leading-relaxed text-xl font-medium font-poppins">
            </div>
        </article>

        <footer
            class="max-w-3xl mx-auto pt-16 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 p-2">
                    <img src="{{ asset('images/logo.png') }}" class="w-full h-full object-contain">
                </div>
                <div>
                    <p class="text-[10px] font-black text-white uppercase tracking-widest">HMIF UKRI Editorial</p>
                    <p class="text-[9px] font-bold text-gray-600 uppercase tracking-tighter italic">Kabinet Metaforsa
                        &bull; Meta Editorial</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.blogs.edit', $blog->slug) }}"
                    class="px-8 py-3 rounded-2xl bg-white/5 border border-white/10 text-[10px] font-black text-white uppercase tracking-widest hover:bg-white/10 transition-all">
                    Modify Article
                </a>
            </div>
        </footer>
    </div>

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const rawData = {!! $blog->content !!};
                const container = document.getElementById('editorjs-content');

                if (rawData && rawData.blocks) {
                    rawData.blocks.forEach(block => {
                        let el;
                        switch (block.type) {
                            case 'header':
                                el = document.createElement(`h${block.data.level}`);
                                el.className =
                                    'text-3xl text-white font-black tracking-tight mt-12 mb-6 uppercase';
                                el.innerHTML = block.data.text;
                                break;
                            case 'paragraph':
                                el = document.createElement('p');
                                el.className = 'text-white text-lg md:text-xl leading-loose mb-4 opacity-80';
                                el.innerHTML = block.data.text;
                                break;
                            case 'list':
                                const isOrdered = block.data.style === 'ordered';
                                el = document.createElement(isOrdered ? 'ol' : 'ul');
                                el.className = 'space-y-4 text-gray-400 text-lg ' + (isOrdered ?
                                    'list-decimal ml-6' : 'list-disc ml-6');
                                block.data.items.forEach(item => {
                                    const li = document.createElement('li');
                                    li.innerHTML = item.content || item;
                                    el.appendChild(li);
                                });
                                break;
                            case 'quote':
                                const blockquote = document.createElement('blockquote');
                                blockquote.className =
                                    'relative p-8 md:p-12 border-l-4 border-red-600 bg-white/2 rounded-r-[2rem] my-12';
                                blockquote.innerHTML =
                                    `<p class="text-lg md:text-xl font-black text-white italic leading-tight">"${block.data.text}"</p>`;
                                if (block.data.caption) {
                                    blockquote.innerHTML +=
                                        `<cite class="block mt-4 text-[10px] font-black text-red-500 uppercase tracking-[0.2em]">— ${block.data.caption}</cite>`;
                                }
                                el = blockquote;
                                break;
                            case 'image':
                                const figure = document.createElement('figure');
                                figure.className = 'my-16 space-y-4';
                                const img = document.createElement('img');
                                img.src = block.data.file.url;
                                img.className =
                                    'w-full max-h-96 object-contain bg-center rounded-[3rem] border border-white/10 shadow-2xl';
                                figure.appendChild(img);
                                if (block.data.caption) {
                                    const figcaption = document.createElement('figcaption');
                                    figcaption.className =
                                        'text-center text-[10px] font-bold text-gray-600 uppercase tracking-widest italic';
                                    figcaption.innerHTML = block.data.caption;
                                    figure.appendChild(figcaption);
                                }
                                el = figure;
                                break;
                        }
                        if (el) container.appendChild(el);
                    });
                }
            });
        </script>
    </x-slot>
</x-app-layout>
