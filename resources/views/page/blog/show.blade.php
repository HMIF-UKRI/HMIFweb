<x-guest-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => $blog->title . ' - Insight',
            'description' => $blog->summary,
            'image' => $blog->getFirstMediaUrl('blog_thumbnails'),
        ])
    </x-slot>

    <div x-data="{
        percent: 0,
        updateProgress() {
            let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            this.percent = (winScroll / height) * 100;
        }
    }" x-init="window.addEventListener('scroll', () => updateProgress())" class="fixed top-0 left-0 z-100 h-1 w-full bg-transparent">
        <div class="h-full bg-linear-to-r from-red-600 to-red-400 shadow-[0_0_15px_rgba(220,38,38,0.5)] transition-all duration-150"
            :style="'width: ' + percent + '%'"></div>
    </div>

    <article class="min-h-screen bg-gray-950 pb-32 selection:bg-red-500 selection:text-white">
        <header class="relative h-[80vh] min-h-150 max-w-7xl mx-auto overflow-hidden">
            <img src="{{ $blog->getFirstMediaUrl('blog_thumbnails') }}"
                class="absolute inset-0 h-full w-full object-cover opacity-60 scale-105">
            <div class="absolute inset-0 bg-linear-to-t from-gray-950 via-gray-950/80 to-transparent"></div>

            <div class="relative z-10 container mx-auto flex h-full flex-col justify-end px-6 pb-20">
                <div class="max-w-4xl space-y-8">
                    <nav
                        class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">
                        <a href="/" class="hover:text-red-500 transition-colors">Home</a>
                        <span class="w-1 h-1 rounded-full bg-gray-800"></span>
                        <a href="/blog" class="hover:text-red-500 transition-colors">Insight</a>
                        <span class="w-1 h-1 rounded-full bg-gray-800"></span>
                        <span class="text-red-600 italic">{{ $blog->category->name }}</span>
                    </nav>

                    <h1 class="text-xl font-black leading-[1.1] text-white md:text-2xl lg:text-4xl tracking-tight">
                        {{ $blog->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-8 border-t border-white/10 pt-8">
                        <div class="h-10 w-px bg-white/10 hidden md:block"></div>

                        <div class="flex flex-col">
                            <span class="text-gray-600 text-[9px] font-black uppercase tracking-widest">Released
                                On</span>
                            <span
                                class="text-xs font-bold text-gray-300">{{ $blog->created_at->format('d F, Y') }}</span>
                        </div>

                        <div class="flex flex-col">
                            <span class="text-gray-600 text-[9px] font-black uppercase tracking-widest">Reading
                                Time</span>
                            <span class="text-xs font-bold text-red-500 tracking-wide uppercase italic">
                                <i class="fa-regular fa-clock mr-1.5"></i>
                                {{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} Mins Read
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container mx-auto px-6 mt-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                <div class="lg:col-span-1 hidden lg:block">
                    <div class="sticky top-40 flex flex-col items-center gap-6">
                        <span
                            class="text-[9px] uppercase font-black tracking-[0.2em] text-gray-700 [writing-mode:vertical-lr] rotate-180">Spread
                            Insight</span>
                        <div class="w-px h-12 bg-white/5"></div>
                        <a href="#"
                            class="h-10 w-10 flex items-center justify-center rounded-xl bg-white/5 text-gray-500 hover:bg-red-600 hover:text-white transition-all"><i
                                class="fa-brands fa-x-twitter"></i></a>
                        <a href="#"
                            class="h-10 w-10 flex items-center justify-center rounded-xl bg-white/5 text-gray-500 hover:bg-blue-600 hover:text-white transition-all"><i
                                class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#"
                            class="h-10 w-10 flex items-center justify-center rounded-xl bg-white/5 text-gray-500 hover:bg-green-600 hover:text-white transition-all"><i
                                class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <div class="lg:col-span-8">
                    <div class="max-w-3xl mx-auto">

                        <div
                            class="mb-12 text-xl font-semibold italic leading-relaxed text-white border-l-2 border-red-600 pl-8">
                            {{ $blog->summary }}
                        </div>

                        <div id="editorjs-content"
                            class="space-y-10 text-gray-400 leading-relaxed text-xl font-medium font-poppins">
                        </div>
                    </div>

                    <div class="mt-20 h-px w-full bg-linear-to-r from-transparent via-red-600/50 to-transparent">
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <div class="sticky top-40 space-y-12">
                        <div class="space-y-6">
                            <h4 class="text-sm font-black text-white uppercase tracking-widest flex items-center gap-3">
                                <span class="h-1 w-8 bg-red-600 rounded-full"></span>
                                Next Read
                            </h4>
                            <div class="space-y-8">
                                @foreach ($relatedBlogs as $related)
                                    <a href="/blog/{{ $related->slug }}" class="group block space-y-3">
                                        <div
                                            class="relative aspect-video w-full overflow-hidden rounded-2xl border border-white/5">
                                            <img src="{{ $related->getFirstMediaUrl('blog_thumbnails', 'thumb') }}"
                                                class="h-full w-full object-cover transition duration-500 group-hover:scale-110 opacity-60 group-hover:opacity-100">
                                        </div>
                                        <h5
                                            class="text-sm font-black text-gray-400 group-hover:text-red-500 transition-colors leading-tight tracking-tight">
                                            {{ $related->title }}
                                        </h5>
                                        <div
                                            class="flex items-center gap-2 text-[9px] font-bold uppercase text-gray-600">
                                            <span>{{ $related->created_at->format('M Y') }}</span>
                                            <span>•</span>
                                            <span class="italic text-red-900">{{ $related->category->name }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>

    @push('script')
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
                                    `<p class="text-lg md:text-xl font-black text-white italic leading-tight">${block.data.text}</p>`;
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
    @endpush
</x-guest-layout>
