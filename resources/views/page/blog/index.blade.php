<x-guest-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Blog - HMIF UKRI',
            'description' =>
                'Halaman ini berisi blog HMIF UKRI untuk menambah wawasan mahasiswa teknik informatika dalam bidang informatika dan umum',
            'keywords' => 'blog hmif, hmif, hmif artikel, artikel',
            'url' => url()->current(),
        ])
    </x-slot>

    <div class="min-h-screen bg-gray-950 pb-20 selection:bg-red-500 selection:text-white" x-data="{ selectedCategory: 'all' }">

        <div class="pointer-events-none fixed inset-0 z-0 opacity-[0.03]"
            style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>

        <div class="relative z-10 container mx-auto px-6 pt-32">
            <div class="mb-16 text-center">
                <h1 class="text-4xl font-extrabold text-white md:text-5xl">HMIF <span class="text-red-600">Insight</span>
                </h1>
            </div>

            <div class="mb-12 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('blog.index') }}"
                        class="{{ !request('category') ? 'bg-red-600 text-white' : 'bg-gray-900 text-gray-400' }} rounded-full px-5 py-2 text-sm font-medium border border-white/5 transition-all">
                        Semua
                    </a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                            class="{{ request('category') == $cat->slug ? 'bg-red-600 text-white' : 'bg-gray-900 text-gray-400' }} rounded-full px-5 py-2 text-sm font-medium border border-white/5 transition-all">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>

                <form action="{{ route('blog.index') }}" method="GET" class="relative w-full md:w-72">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel..."
                        class="w-full rounded-xl border-white/5 bg-gray-900 py-3 pl-10 pr-4 text-sm text-white focus:ring-red-600">
                    <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($blogs as $blog)
                    <article
                        class="group relative flex flex-col overflow-hidden rounded-2xl border border-white/5 bg-gray-900/50 backdrop-blur-sm transition-all duration-500 hover:-translate-y-2 hover:border-red-600/50">
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ $blog->getFirstMediaUrl('blog_thumbnails', 'thumb') ?: 'https://placehold.co/600x400/1a1a1a/ffffff?text=HMIF' }}"
                                alt="{{ $blog->title }}"
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <span
                                class="absolute left-4 top-4 rounded-lg bg-red-600/90 px-3 py-1 text-[10px] font-bold uppercase text-white">
                                {{ $blog->category?->name ?? 'Uncategorized' }}
                            </span>
                        </div>

                        <div class="flex flex-1 flex-col p-6">
                            <div class="mb-3 flex items-center gap-3 text-[11px] text-gray-500">
                                <span class="flex items-center gap-1"><i
                                        class="fa-regular fa-user text-red-500"></i>{{ $blog->author?->full_name ?? 'Anonymous' }}</span>
                                <span class="h-1 w-1 rounded-full bg-gray-700"></span>
                                <span>{{ $blog->created_at->format('d M, Y') }}</span>
                            </div>

                            <h3 class="mb-3 text-xl font-bold text-white transition-colors group-hover:text-red-500">
                                <a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                            </h3>

                            <p class="mb-6 line-clamp-3 text-sm text-gray-400">{{ $blog->summary }}</p>

                            <div class="mt-auto pt-6 border-t border-white/5">
                                <a href="{{ route('blog.show', $blog->slug) }}"
                                    class="flex items-center gap-2 text-sm font-semibold text-white group-hover:text-red-500">
                                    Baca Selengkapnya <i class="fa-solid fa-arrow-right-long text-red-600"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <p class="text-gray-500">Tidak ada artikel yang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            @if ($blogs->hasPages())
                <div class="mt-20 flex items-center justify-center gap-2">
                    @if ($blogs->onFirstPage())
                        <span
                            class="cursor-not-allowed rounded-xl border border-white/5 bg-gray-900/50 px-4 py-2 text-gray-600">
                            <i class="fa-solid fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $blogs->previousPageUrl() }}"
                            class="rounded-xl border border-white/10 bg-gray-900 px-4 py-2 text-white transition-all hover:border-red-500 hover:text-red-500">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    @endif

                    <div
                        class="flex items-center gap-2 rounded-2xl border border-white/5 bg-gray-900/30 p-1 backdrop-blur-md">
                        @foreach ($blogs->getUrlRange(max(1, $blogs->currentPage() - 2), min($blogs->lastPage(), $blogs->currentPage() + 2)) as $page => $url)
                            <a href="{{ $url }}"
                                class="flex h-10 w-10 items-center justify-center rounded-xl text-sm font-bold transition-all {{ $page == $blogs->currentPage() ? 'bg-red-600 text-white shadow-lg shadow-red-900/40' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                                {{ $page }}
                            </a>
                        @endforeach
                    </div>

                    @if ($blogs->hasMorePages())
                        <a href="{{ $blogs->nextPageUrl() }}"
                            class="rounded-xl border border-white/10 bg-gray-900 px-4 py-2 text-white transition-all hover:border-red-500 hover:text-red-500">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    @else
                        <span
                            class="cursor-not-allowed rounded-xl border border-white/5 bg-gray-900/50 px-4 py-2 text-gray-600">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>
