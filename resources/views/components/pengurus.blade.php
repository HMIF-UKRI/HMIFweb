<section id="board" class="relative overflow-hidden bg-black py-20 text-white">
    <div
        class="pointer-events-none absolute top-1/2 left-1/2 h-full max-h-96 w-full max-w-4xl -translate-x-1/2 -translate-y-1/2 rounded-full bg-red-900/10 blur-[100px]">
    </div>

    <div class="relative container mx-auto px-6 md:px-12">
        <div class="mb-16 text-center">
            <h2 class="mb-3 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                Struktur Badan
                <span class="text-red-600">Pengurus</span>
            </h2>
            <div class="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-red-900 to-red-600"></div>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($members as $member)
                <div
                    class="group relative rounded-2xl border border-red-900/30 bg-gray-900/50 backdrop-blur-sm transition duration-500 hover:-translate-y-2 hover:border-red-600 hover:shadow-[0_0_20px_rgba(220,38,38,0.4)]">
                    <div class="relative h-72 w-full overflow-hidden rounded-t-2xl">
                        <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}"
                            class="h-full w-full object-cover object-center grayscale-[30%] transition duration-700 group-hover:scale-110 group-hover:grayscale-0"
                            loading="lazy" />

                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-80">
                        </div>

                        <div
                            class="absolute bottom-0 left-0 h-1 w-full bg-red-900 transition-all duration-500 group-hover:bg-red-600">
                        </div>
                    </div>

                    <div class="relative p-6 text-center">
                        <div
                            class="absolute inset-0 rounded-b-2xl bg-gradient-to-b from-transparent to-red-900/10 opacity-0 transition duration-500 group-hover:opacity-100">
                        </div>

                        <h3 class="relative text-lg font-bold text-white transition-colors group-hover:text-red-50">
                            {{ $member->name }}
                        </h3>

                        <p
                            class="relative mt-1 text-sm font-medium tracking-wider text-red-500 uppercase group-hover:text-red-400">
                            {{ $member->position }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-red-900/30 py-12 text-center">
                    <p class="text-gray-500">Belum ada data pengurus.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8 text-center">
            <a class="group relative inline-flex items-center overflow-hidden rounded-lg border-2 border-current bg-transparent px-8 py-3 text-white transition-colors duration-300 hover:text-red-500 focus:ring-3 focus:outline-none"
                href="/struktur-pengurus">
                <span
                    class="absolute top-0 left-0 z-0 h-full w-0 bg-white transition-all duration-300 group-hover:w-full"></span>
                <span class="absolute -end-full transition-all group-hover:end-4">
                    <svg class="size-5 shadow-sm rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </span>

                <span class="z-10 text-sm font-medium transition-all group-hover:me-4">
                    Lihat Semua Badan Pengurus
                </span>
            </a>
        </div>
    </div>
</section>
