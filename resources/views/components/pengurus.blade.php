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
            <div class="mx-auto h-1 w-24 rounded-full bg-linear-to-r from-red-900 to-red-600"></div>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($pengurus as $pgrs)
                <div
                    class="group relative rounded-2xl border border-red-900/30 bg-gray-900/50 backdrop-blur-sm transition duration-500 hover:-translate-y-2 hover:border-red-600 hover:shadow-[0_0_20px_rgba(220,38,38,0.4)]">
                    <div
                        class="relative aspect-[3/4] w-full overflow-hidden rounded-2xl border border-red-900/30 bg-gray-900/40">
                        @php
                            $photoUrl = $pgrs->getFirstMediaUrl('foto_pengurus', 'card');
                            $defaultPhoto =
                                'https://ui-avatars.com/api/?name=' .
                                urlencode($pgrs->member->full_name) .
                                '&background=1f2937&color=fff';
                        @endphp

                        <img src="{{ $photoUrl ?: $defaultPhoto }}" alt="{{ $pgrs->member->full_name }}"
                            class="h-full w-full object-contain object-center grayscale-30 transition duration-700 group-hover:scale-[1.04] group-hover:grayscale-0"
                            loading="lazy" />

                        <div
                            class="absolute inset-0 bg-linear-to-t from-gray-900 via-transparent to-transparent opacity-80">
                        </div>

                        <div
                            class="absolute bottom-0 left-0 h-1 w-full bg-red-900 transition-all duration-500 group-hover:bg-red-600">
                        </div>
                    </div>

                    <div class="relative p-6 text-center">
                        <div
                            class="absolute inset-0 rounded-b-2xl bg-linear-to-b from-transparent to-red-900/10 opacity-0 transition duration-500 group-hover:opacity-100">
                        </div>

                        <h3 class="relative text-lg font-bold text-white transition-colors group-hover:text-red-50">
                            {{ $pgrs->member->full_name }}
                        </h3>

                        <p
                            class="relative mt-1 text-sm font-medium tracking-wider text-red-500 uppercase group-hover:text-red-400">
                            {{ $pgrs->position }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-red-900/30 py-12 text-center">
                    <p class="text-gray-500">Belum ada data pengurus inti untuk periode ini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8 text-center">
            <a class="group relative inline-flex items-center overflow-hidden rounded-lg border-2 border-current bg-transparent px-8 py-3 text-white transition-colors duration-300 hover:text-red-500 focus:ring-3 focus:outline-none"
                href="{{ route('struktur-pengurus') }}">
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

    @if (!empty($departmentGroups) && $departmentGroups->count())
        <div class="relative container mx-auto mt-16 px-6 md:px-12">
            <div class="mb-10 text-center">
                <h2 class="mb-3 text-2xl font-bold tracking-tight text-white sm:text-3xl">
                    Struktur <span class="text-red-600">Bidang</span>
                </h2>
                <div class="mx-auto h-1 w-20 rounded-full bg-linear-to-r from-red-900 to-red-600"></div>
            </div>

            <div class="space-y-8">
                @foreach ($departmentGroups as $deptId => $group)
                    @php
                        $dept = $group['department'];
                        $deptHeads = $group['heads'];
                        $deptHead = $deptHeads->first();
                        $deptBidangGroups = $pengurusBidang
                            ->filter(function ($item) use ($deptId) {
                                return $item->department_id === $deptId;
                            })
                            ->groupBy(function ($item) {
                                return $item->bidang?->name ?? 'Bidang Lainnya';
                            });
                        $ring1Members = $pengurus
                            ? $pengurus->filter(function ($item) use ($deptId) {
                                return $item->department_id === $deptId;
                            })
                            : collect();
                    @endphp

                    <details
                        class="group rounded-3xl border border-red-900/30 bg-gray-900/40 backdrop-blur-sm transition duration-300 open:border-red-600/60 open:shadow-[0_0_30px_rgba(220,38,38,0.2)]">
                        <summary
                            class="flex cursor-pointer list-none items-center gap-4 px-6 py-5 text-left outline-none">
                            <div class="h-2.5 w-2.5 shrink-0 rounded-full bg-red-600 shadow-[0_0_10px_rgba(220,38,38,0.6)]">
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <div class="h-px w-8 bg-linear-to-r from-red-600 to-transparent"></div>
                                    <h3 class="text-lg font-black uppercase tracking-widest text-red-500">
                                        {{ $dept->name }}
                                    </h3>
                                    <div class="h-px flex-1 bg-linear-to-l from-red-600/60 to-transparent"></div>
                                </div>
                                @if ($dept->name === 'Ring 1' && $ring1Members->count())
                                    <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-gray-500">
                                        Anggota Ring 1
                                    </p>
                                @elseif ($deptHead)
                                    <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-gray-500">
                                        Kepala Departemen: {{ $deptHead->member->full_name }}
                                    </p>
                                @else
                                    <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-gray-500">
                                        Kepala Departemen belum terdata
                                    </p>
                                @endif
                            </div>
                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-full border border-red-900/40 text-red-500 transition duration-300 group-open:rotate-180 group-open:bg-red-600 group-open:text-white">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </summary>

                        <div class="px-6 pb-6">
                            @if ($dept->name === 'Ring 1' && $ring1Members->count())
                                <div class="mb-6 flex items-center gap-3">
                                    <div class="h-px w-10 bg-linear-to-r from-red-600 to-transparent"></div>
                                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-red-500">
                                        Anggota Ring 1
                                    </span>
                                    <div class="h-px flex-1 bg-linear-to-l from-red-600/40 to-transparent"></div>
                                </div>

                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                                    @foreach ($ring1Members as $pgrs)
                                        <div
                                            class="group relative rounded-2xl border border-red-900/30 bg-gray-900/50 backdrop-blur-sm transition duration-500 hover:-translate-y-1 hover:border-red-600 hover:shadow-[0_0_20px_rgba(220,38,38,0.4)]">
                                            <div
                                                class="relative aspect-[3/4] w-full overflow-hidden rounded-2xl border border-red-900/30 bg-gray-900/40">
                                                @php
                                                    $photoUrl = $pgrs->getFirstMediaUrl('foto_pengurus', 'card');
                                                    $defaultPhoto =
                                                        'https://ui-avatars.com/api/?name=' .
                                                        urlencode($pgrs->member->full_name) .
                                                        '&background=1f2937&color=fff';
                                                @endphp

                                                <img src="{{ $photoUrl ?: $defaultPhoto }}"
                                                    alt="{{ $pgrs->member->full_name }}"
                                                    class="h-full w-full object-contain object-center grayscale-30 transition duration-700 group-hover:scale-[1.04] group-hover:grayscale-0"
                                                    loading="lazy" />
                                            </div>
                                            <div class="relative p-4 text-center">
                                                <h4
                                                    class="text-sm font-bold text-white transition-colors group-hover:text-red-50">
                                                    {{ $pgrs->member->full_name }}
                                                </h4>
                                                <p
                                                    class="mt-1 text-[10px] font-bold tracking-wider text-red-500 uppercase group-hover:text-red-400">
                                                    {{ $pgrs->position }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif ($deptHead)
                                <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    <div
                                        class="group relative rounded-2xl border border-red-900/30 bg-gray-900/60 backdrop-blur-sm transition duration-500 hover:-translate-y-1 hover:border-red-600 hover:shadow-[0_0_20px_rgba(220,38,38,0.4)]">
                                        <div
                                            class="relative aspect-[3/4] w-full overflow-hidden rounded-2xl border border-red-900/30 bg-gray-900/40">
                                            @php
                                                $photoUrl = $deptHead->getFirstMediaUrl('foto_pengurus', 'card');
                                                $defaultPhoto =
                                                    'https://ui-avatars.com/api/?name=' .
                                                    urlencode($deptHead->member->full_name) .
                                                    '&background=1f2937&color=fff';
                                            @endphp

                                            <img src="{{ $photoUrl ?: $defaultPhoto }}"
                                                alt="{{ $deptHead->member->full_name }}"
                                                class="h-full w-full object-contain object-center grayscale-30 transition duration-700 group-hover:scale-[1.04] group-hover:grayscale-0"
                                                loading="lazy" />
                                        </div>
                                        <div class="relative p-4 text-center">
                                            <h4
                                                class="text-sm font-bold text-white transition-colors group-hover:text-red-50">
                                                {{ $deptHead->member->full_name }}
                                            </h4>
                                            <p
                                                class="mt-1 text-[10px] font-bold tracking-wider text-red-500 uppercase group-hover:text-red-400">
                                                {{ $deptHead->position }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($deptBidangGroups->count())
                                <div class="mb-6 flex items-center gap-3">
                                    <div class="h-px w-10 bg-linear-to-r from-red-600 to-transparent"></div>
                                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-red-500">
                                        Bidang Di Bawahnya
                                    </span>
                                    <div class="h-px flex-1 bg-linear-to-l from-red-600/40 to-transparent"></div>
                                </div>

                                <div class="space-y-8">
                                    @foreach ($deptBidangGroups as $bidangName => $members)
                                        <div class="rounded-2xl border border-red-900/30 bg-gray-900/40 p-4">
                                            <div class="mb-4 flex items-center gap-3">
                                                <div
                                                    class="h-2 w-2 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.6)]">
                                                </div>
                                                <h4 class="text-sm font-black uppercase tracking-widest text-red-500">
                                                    {{ $bidangName }}
                                                </h4>
                                            </div>

                                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                                                @foreach ($members as $pgrs)
                                                    <div
                                                        class="group relative rounded-2xl border border-red-900/30 bg-gray-900/50 backdrop-blur-sm transition duration-500 hover:-translate-y-1 hover:border-red-600 hover:shadow-[0_0_20px_rgba(220,38,38,0.4)]">
                                                        <div
                                                            class="relative aspect-[3/4] w-full overflow-hidden rounded-2xl border border-red-900/30 bg-gray-900/40">
                                                            @php
                                                                $photoUrl = $pgrs->getFirstMediaUrl('foto_pengurus', 'card');
                                                                $defaultPhoto =
                                                                    'https://ui-avatars.com/api/?name=' .
                                                                    urlencode($pgrs->member->full_name) .
                                                                    '&background=1f2937&color=fff';
                                                            @endphp

                                                            <img src="{{ $photoUrl ?: $defaultPhoto }}"
                                                                alt="{{ $pgrs->member->full_name }}"
                                                                class="h-full w-full object-contain object-center grayscale-30 transition duration-700 group-hover:scale-[1.04] group-hover:grayscale-0"
                                                                loading="lazy" />
                                                        </div>

                                                        <div class="relative p-4 text-center">
                                                            <h4
                                                                class="text-sm font-bold text-white transition-colors group-hover:text-red-50">
                                                                {{ $pgrs->member->full_name }}
                                                            </h4>
                                                            <p
                                                                class="mt-1 text-[10px] font-bold tracking-wider text-red-500 uppercase group-hover:text-red-400">
                                                                {{ $pgrs->position }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </details>
                @endforeach
            </div>
        </div>
    @endif
</section>
