<x-app-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Blog Management - HMIF UKRI',
            'description' => 'Kelola artikel dan publikasi wawasan HMIF Insight.',
        ])
    </x-slot>

    <x-slot name="header_title">Core Content / Blog</x-slot>

    <div class="space-y-8">
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-white/5 pb-8">
            <div class="space-y-1">
                <h3 class="text-3xl font-black text-white uppercase tracking-tighter leading-none">
                    Blog <span
                        class="text-transparent bg-clip-text bg-linear-to-r from-red-600 to-red-400 italic">HMIF</span>
                </h3>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-[0.3em] mt-2">Manage semua postingan
                    artikel & jurnal HMIF.</p>
            </div>

            <div class="flex items-center gap-3">
                <form action="{{ route('admin.blogs.index') }}" method="GET" class="relative group hidden lg:block">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title..."
                        class="bg-black/20 border border-white/10 rounded-xl px-4 py-2.5 pl-10 text-[10px] text-white focus:border-red-600 focus:w-64 w-48 transition-all outline-none font-bold tracking-widest">
                    <ion-icon name="search-outline"
                        class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-600 group-focus-within:text-red-600"></ion-icon>
                </form>
                <a href="{{ route('admin.blogs.create') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-red-600/20 active:scale-95 flex items-center gap-2">
                    <ion-icon name="add-circle-outline" class="text-sm"></ion-icon>
                    New Article
                </a>
            </div>
        </div>

        <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
            <a href="{{ route('admin.blogs.index') }}"
                class="px-5 py-2.5 rounded-xl border {{ !request('category_id') ? 'bg-red-600/10 border-red-600 text-red-500' : 'bg-white/5 border-white/5 text-gray-500 hover:bg-white/10' }} text-[9px] font-black uppercase tracking-widest transition-all whitespace-nowrap">
                All Categories
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('admin.blogs.index', ['category_id' => $cat->id]) }}"
                    class="px-5 py-2.5 rounded-xl border {{ request('category_id') == $cat->id ? 'bg-red-600/10 border-red-600 text-red-500' : 'bg-white/5 border-white/5 text-gray-500 hover:bg-white/10' }} text-[9px] font-black uppercase tracking-widest transition-all whitespace-nowrap">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($blogs as $blog)
                <div
                    class="group relative bg-white/2 border border-white/5 rounded-3xl overflow-hidden hover:bg-white/4 transition-all duration-500 hover:-translate-y-2">
                    <div class="absolute top-4 right-4 z-20">
                        @if ($blog->status == 'published')
                            <span
                                class="px-3 py-1 rounded-full bg-green-500/10 border border-green-500/20 text-[8px] font-black text-green-500 uppercase tracking-widest backdrop-blur-md">
                                <span class="w-1 h-1 bg-green-500 rounded-full inline-block mr-1 animate-pulse"></span>
                                Published
                            </span>
                        @else
                            <span
                                class="px-3 py-1 rounded-full bg-yellow-500/10 border border-yellow-500/20 text-[8px] font-black text-yellow-500 uppercase tracking-widest backdrop-blur-md">
                                Draft
                            </span>
                        @endif
                    </div>

                    <div class="relative h-52 overflow-hidden">
                        <img src="{{ $blog->getFirstMediaUrl('blog_thumbnails', 'thumb') ?: 'https://placehold.co/800x450/030712/ffffff?text=HMIF+INSIGHT' }}"
                            class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-linear-to-t from-gray-950 via-gray-950/20 to-transparent">
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="space-y-2">
                            <p class="text-[9px] font-black text-red-600 uppercase tracking-[0.2em] italic">
                                {{ $blog->category->name ?? 'Uncategorized' }}</p>
                            <h4
                                class="text-lg font-black text-white leading-tight line-clamp-2 uppercase tracking-tighter italic">
                                {{ $blog->title }}</h4>
                        </div>

                        <div
                            class="flex items-center gap-4 text-[10px] text-gray-500 font-bold uppercase tracking-widest border-t border-white/5 pt-4">
                            <span class="flex items-center gap-2"><ion-icon name="calendar-outline"
                                    class="text-red-600"></ion-icon> {{ $blog->created_at->format('d M Y') }}</span>
                            <span class="flex items-center gap-2"><ion-icon name="eye-outline"
                                    class="text-red-600"></ion-icon> {{ $blog->views_count }} Views</span>
                        </div>

                        <div class="flex items-center justify-between pt-4">
                            <a href="{{ route('admin.blogs.show', $blog->slug) }}"
                                class="text-[9px] font-black text-gray-400 hover:text-white uppercase tracking-[0.2em] transition-colors flex items-center gap-2">
                                Read Concept <ion-icon name="arrow-forward-outline"></ion-icon>
                            </a>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.blogs.edit', $blog->slug) }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 hover:bg-yellow-500/20 hover:text-yellow-500 transition-all border border-white/5">
                                    <ion-icon name="create-outline"></ion-icon>
                                </a>
                                <form action="{{ route('admin.blogs.destroy', $blog->slug) }}" method="POST"
                                    onsubmit="return confirm('Hapus artikel ini permanen?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 hover:bg-red-600 hover:text-white transition-all border border-white/5">
                                        <ion-icon name="trash-outline"></ion-icon>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full py-20 text-center border-2 border-dashed border-white/5 rounded-[3rem] opacity-20">
                    <ion-icon name="newspaper-outline" class="text-5xl mb-3 text-red-600"></ion-icon>
                    <p class="text-[10px] font-black uppercase tracking-[0.4em]">No Articles Written Yet</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $blogs->links() }}
        </div>
    </div>
</x-app-layout>
