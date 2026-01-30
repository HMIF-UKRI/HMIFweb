<x-guest-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'HMIF Insight - Berita & Artikel',
            'description' =>
                'Eksplorasi wawasan teknologi dan berita terbaru dari Himpunan Mahasiswa Teknik Informatika UKRI.',
        ])
    </x-slot>

    <div class="min-h-screen bg-gray-950 pb-32 selection:bg-red-500 selection:text-white" x-data="{ selectedCategory: 'all' }">
        <div class="pointer-events-none fixed inset-0 z-0 opacity-[0.03]"
            style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>
        <div class="absolute top-0 left-0 right-0 h-125 bg-linear-to-b from-red-950/20 to-transparent"></div>

        <div class="relative z-10 container mx-auto px-6 pt-40 max-w-7xl">
            <div class="mb-20 space-y-4 text-center">
                <h4 class="text-xs font-black uppercase tracking-[0.5em] text-red-600 italic">Official Journal</h4>
                <h1 class="text-5xl font-black tracking-tighter text-white md:text-7xl">
                    HMIF <span
                        class="italic text-transparent bg-clip-text bg-linear-to-r from-red-600 to-red-400">Insight</span>
                </h1>
                <p class="mx-auto max-w-xl text-sm font-medium leading-relaxed text-gray-500 uppercase tracking-widest">
                    Pusat Informasi, Edukasi, dan Dokumentasi Digital Teknik Informatika UKRI
                </p>
            </div>

            <div
                class="mb-16 flex flex-col gap-8 md:flex-row md:items-end md:justify-between border-b border-white/5 pb-10">
                <div class="space-y-4">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-gray-600">Filter Kategori</span>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('blog.index') }}"
                            class="rounded-full px-6 py-2.5 text-[11px] font-black uppercase tracking-widest transition-all {{ !request('category') ? 'bg-red-600 text-white shadow-lg shadow-red-600/20' : 'bg-white/5 text-gray-400 hover:bg-white/10 border border-white/5' }}">
                            Semua
                        </a>
                        @foreach ($categories as $cat)
                            <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                                class="rounded-full px-6 py-2.5 text-[11px] font-black uppercase tracking-widest transition-all {{ request('category') == $cat->slug ? 'bg-red-600 text-white shadow-lg shadow-red-600/20' : 'bg-white/5 text-gray-400 hover:bg-white/10 border border-white/5' }}">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <form action="{{ route('blog.index') }}" method="GET" class="relative w-full md:w-80 group">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari pembahasan..."
                        class="w-full rounded-2xl border border-white/10 bg-white/2 py-4 pl-12 pr-6 text-xs text-white transition-all focus:border-red-600 focus:ring-0 group-hover:border-white/20">
                    <i
                        class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-gray-600 group-focus-within:text-red-600"></i>
                </form>
            </div>

            <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($blogs as $blog)
                    <article
                        class="group relative flex flex-col overflow-hidden rounded-2xl border border-white/5 bg-gray-900/30 backdrop-blur-md transition-all duration-500 hover:-translate-y-3 hover:border-red-600/30">
                        <div class="relative h-64 overflow-hidden">
                            <img src="{{ $blog->getFirstMediaUrl('blog_thumbnails', 'thumb') ?: 'https://placehold.co/800x600/030712/ffffff?text=HMIF+INSIGHT' }}"
                                alt="{{ $blog->title }}"
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110 group-hover:rotate-2">
                            <div
                                class="absolute inset-0 bg-linear-to-t from-gray-950 via-transparent to-transparent opacity-60">
                            </div>
                            <span
                                class="absolute left-6 top-6 rounded-xl bg-red-600 px-4 py-1.5 text-[9px] font-black uppercase tracking-[0.2em] text-white">
                                {{ $blog->category?->name ?? 'Update' }}
                            </span>
                        </div>

                        <div class="flex flex-1 flex-col p-8">
                            <div
                                class="mb-4 flex items-center gap-4 text-[10px] font-bold uppercase tracking-widest text-gray-500">
                                <span class="flex items-center gap-2"><i
                                        class="fa-regular fa-calendar-check text-red-600"></i>
                                    {{ $blog->created_at->locale('id')->translatedFormat('d F Y') }}</span>
                                <span class="h-1 w-1 rounded-full bg-gray-800"></span>
                            </div>

                            <h3
                                class="mb-4 text-2xl font-black leading-tight text-white transition-colors group-hover:text-red-500 tracking-tighter">
                                <a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                            </h3>

                            <p class="mb-8 line-clamp-3 text-sm leading-loose text-gray-400 font-medium italic">
                                {{ $blog->summary }}
                            </p>

                            <div class="mt-auto pt-6 border-t border-white/5">
                                <a href="{{ route('blog.show', $blog->slug) }}"
                                    class="inline-flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] text-white group-hover:text-red-500 transition-all">
                                    Baca Selengkapnya <i
                                        class="fa-solid fa-arrow-right-long text-red-600 transition-transform group-hover:translate-x-2"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div
                        class="col-span-full py-32 text-center border-2 border-dashed border-white/5 rounded-[3rem] opacity-20">
                        <i class="fa-solid fa-box-open text-5xl mb-4"></i>
                        <p class="text-[10px] font-black uppercase tracking-[0.4em]">No Articles Published Yet</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-20">
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
</x-guest-layout>
