<x-guest-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => $blog->title . ' - HMIF UKRI',
            'description' => $blog->summary,
            'keywords' => 'blog hmif, ' . $blog->category->name . ', ' . $blog->author->full_name,
            'image' => $blog->getFirstMediaUrl('blog_thumbnails'),
            'url' => url()->current(),
        ])
    </x-slot>

    <div x-data="{
        percent: 0,
        updateProgress() {
            let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            this.percent = (winScroll / height) * 100;
        }
    }" x-init="window.addEventListener('scroll', () => updateProgress())" class="fixed top-0 left-0 z-60 h-1.5 w-full bg-gray-900">
        <div class="h-full bg-red-600 transition-all duration-150" :style="'width: ' + percent + '%'"></div>
    </div>

    <article class="min-h-screen bg-gray-950 pb-20 selection:bg-red-500 selection:text-white" x-data="{ showZoom: false, zoomSrc: '' }">

        <template x-if="showZoom">
            <div class="fixed inset-0 z-100 flex items-center justify-center bg-black/95 p-4 backdrop-blur-sm"
                @click="showZoom = false" x-transition>
                <img :src="zoomSrc" class="max-h-full max-w-full rounded-lg shadow-2xl">
                <button class="absolute top-6 right-6 text-white text-2xl">&times;</button>
            </div>
        </template>

        <header class="relative h-[60vh] min-h-100 w-full overflow-hidden">
            <img src="{{ $blog->getFirstMediaUrl('blog_thumbnails') }}"
                class="absolute inset-0 h-full w-full object-cover opacity-40">
            <div class="absolute inset-0 bg-linear-to-t from-gray-950 via-gray-950/60 to-transparent"></div>

            <div class="relative z-10 container mx-auto flex h-full flex-col justify-end px-6 pb-12">
                <nav class="mb-6 flex items-center gap-2 text-sm text-gray-400">
                    <a href="/" class="hover:text-red-500">Home</a>
                    <span>/</span>
                    <a href="/blog" class="hover:text-red-500">Blog</a>
                    <span>/</span>
                    <span class="text-red-500">{{ $blog->category->name }}</span>
                </nav>

                <h1 class="mb-6 max-w-4xl text-3xl font-extrabold text-white md:text-5xl lg:text-6xl leading-tight">
                    {{ $blog->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-6 text-sm text-gray-300">
                    <div class="flex items-center gap-3">
                        <img src="{{ $blog->author->getFirstMediaUrl('avatars') ?: 'https://ui-avatars.com/api/?name=' . urlencode($blog->author->full_name) }}"
                            class="h-10 w-10 rounded-full border border-red-600/50">
                        <div>
                            <p class="font-bold text-white">{{ $blog->author->full_name }}</p>
                            <p class="text-[11px] text-gray-500 uppercase tracking-widest">{{ $blog->author->npm }}
                            </p>
                        </div>
                    </div>
                    <div class="h-8 w-px bg-gray-800 hidden md:block"></div>
                    <div class="flex flex-col">
                        <span class="text-gray-500 text-[10px] uppercase">Diterbitkan</span>
                        <span class="font-medium">{{ $blog->created_at->format('d F, Y') }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-500 text-[10px] uppercase">Waktu Baca</span>
                        <span class="font-medium text-red-500 tracking-wide">
                            <i class="fa-regular fa-clock mr-1"></i>
                            {{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} Menit
                        </span>
                    </div>
                </div>
            </div>
        </header>

        <div class="container mx-auto px-6 mt-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                <div class="lg:col-span-1 hidden lg:block">
                    <div class="sticky top-32 flex flex-col gap-4 text-gray-500">
                        <span class="text-[10px] uppercase font-bold tracking-tighter mb-2">Share</span>
                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" target="_blank"
                            class="hover:text-white transition-colors"><i
                                class="fa-brands fa-x-twitter text-xl"></i></a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}"
                            target="_blank" class="hover:text-blue-500 transition-colors"><i
                                class="fa-brands fa-linkedin text-xl"></i></a>
                        <a href="https://api.whatsapp.com/send?text={{ url()->current() }}" target="_blank"
                            class="hover:text-green-500 transition-colors"><i
                                class="fa-brands fa-whatsapp text-xl"></i></a>
                    </div>
                </div>

                <div class="lg:col-span-8">
                    <div class="prose prose-invert prose-red max-w-none 
                                prose-headings:font-extrabold prose-p:text-gray-300 prose-p:leading-relaxed prose-p:text-lg
                                prose-img:rounded-2xl prose-img:cursor-zoom-in"
                        @click="if($event.target.tagName === 'IMG') { showZoom = true; zoomSrc = $event.target.src }">

                        {!! $blog->content !!}

                    </div>
                </div>

                <div class="lg:col-span-3">
                    <div class="sticky top-32">
                        <h4 class="text-white font-bold mb-6 flex items-center gap-2">
                            <span class="h-4 w-1 bg-red-600 rounded-full"></span>
                            Artikel Terkait
                        </h4>
                        <div class="space-y-6">
                            @foreach ($relatedBlogs as $related)
                                <a href="/blog/{{ $related->slug }}" class="group block">
                                    <div class="relative h-32 w-full overflow-hidden rounded-xl mb-3">
                                        <img src="{{ $related->getFirstMediaUrl('blog_thumbnails', 'thumb') }}"
                                            class="h-full w-full object-cover transition duration-500 group-hover:scale-110">
                                    </div>
                                    <h5
                                        class="text-sm font-bold text-gray-300 group-hover:text-red-500 transition-colors line-clamp-2">
                                        {{ $related->title }}
                                    </h5>
                                    <span
                                        class="text-[10px] text-gray-500">{{ $related->created_at->format('d M, Y') }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </article>
</x-guest-layout>
