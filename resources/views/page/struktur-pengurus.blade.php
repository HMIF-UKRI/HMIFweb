<x-guest-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Struktur Pengurus - HMIF UKRI',
            'description' => 'Struktur organisasi dan fungsionaris Himpunan Mahasiswa Teknik Informatika UKRI.',
            'keywords' => 'struktur, pengurus, hmif, ukri, himatif, hima, informatika, organisasi',
            'image' => asset('images/banner.png'),
            'url' => url()->current(),
        ])
    </x-slot>

    <div class="min-h-screen bg-gray-950 pb-20 font-sans text-white selection:bg-red-500 selection:text-white">
        <div class="pointer-events-none fixed inset-0 z-0 opacity-[0.03]"
            style="
                background-image: url('https://grainy-gradients.vercel.app/noise.svg');
            ">
        </div>
        <div
            class="pointer-events-none fixed top-0 left-1/2 z-0 h-125 w-full max-w-7xl -translate-x-1/2 rounded-full bg-red-900/20 blur-[120px]">
        </div>

        <div class="relative z-10 px-8 pt-32 pb-10 text-center sm:px-6">

            <div class="flex flex-col items-center mb-8">
                <h1 class="text-3xl font-black tracking-[0.2em] text-white md:text-5xl uppercase">
                    Struktur <span class="italic text-red-600">Pengurus</span>
                </h1>
                <div class="mt-2 h-0.5 w-12 bg-linear-to-r from-transparent via-red-600 to-transparent"></div>
            </div>

            <div
                class="mx-auto max-w-4xl flex flex-col md:flex-row items-center justify-center gap-6 md:gap-12 bg-white/2 border border-white/5 p-4 rounded-4xl backdrop-blur-sm">

                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-600/10 text-red-500">
                        <i class="fa-solid fa-layer-group text-sm"></i>
                    </div>
                    <div class="flex-1 text-left min-w-37.5">
                        <form action="{{ url()->current() }}" method="GET" class="relative">
                            <select name="period" onchange="this.form.submit()"
                                class="w-full cursor-pointer appearance-none bg-transparent text-xs font-black uppercase tracking-widest text-white focus:outline-none pr-8">
                                @foreach ($currentPeriod as $period)
                                    <option value="{{ $period->id }}" class="bg-gray-950 text-white"
                                        {{ request('period') == $period->id || ($period->is_current && !request('period')) ? 'selected' : '' }}>
                                        {{ $period->cabinet_name ?: $period->period_range }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute right-0 top-1/2 -translate-y-1/2 text-red-600">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="hidden md:block h-8 w-px bg-white/10"></div>

                <div class="flex items-center gap-4">
                    @if ($activePeriod->preview_url)
                        <img src="{{ $activePeriod->preview_url }}" alt="Logo Kabinet"
                            class="h-12 w-auto object-contain drop-shadow-[0_0_8px_rgba(220,38,38,0.3)]" />
                        <div class="text-left">
                            <p class="text-[8px] font-black text-gray-500 uppercase tracking-widest leading-none">
                                Kabinet</p>
                            <h2 class="text-sm font-black text-white uppercase tracking-tighter italic">
                                {{ $activePeriod->cabinet_name }}
                            </h2>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/logo.png') }}"
                                class="h-12 w-auto object-contain drop-shadow-[0_0_8px_rgba(220,38,38,0.3)]" />
                            <span class="text-sm font-black text-white uppercase tracking-tighter italic">HMIF
                                UKRI</span>
                        </div>
                    @endif
                </div>
            </div>

            <p
                class="mt-8 mx-auto max-w-lg text-[11px] font-medium text-gray-500 uppercase tracking-[0.2em] leading-relaxed">
                Fungsionaris Terpilih &bull; Periode Kepengurusan
                <span class="text-gray-300">{{ $activePeriod->period_range }}</span>
            </p>
        </div>

        <div class="relative z-10 container mx-auto px-8">
            <div class="mb-16 flex w-full items-center justify-center">
                <div class="h-px w-16 bg-linear-to-r from-transparent to-red-600"></div>
                <span
                    class="rounded-full border border-red-900/30 bg-gray-900 px-6 py-2 text-sm font-bold tracking-widest text-red-500 uppercase shadow-lg shadow-red-900/10">
                    Badan Pengurus
                </span>
                <div class="h-px w-16 bg-linear-to-l from-transparent to-red-600"></div>
            </div>

            <div class="flex flex-col items-center justify-center px-12 sm:px-0">
                @forelse ($pengurus->filter(function ($member) {
        return $member->hierarchy_level === 1;
    }) as $index => $pgrs)
                    <div
                        class="{{ $index % 2 == 0 ? 'sm:flex-row' : 'sm:flex-row-reverse' }} relative mb-16 flex w-full max-w-5xl flex-col items-center sm:mb-12 sm:items-start sm:gap-12 lg:gap-20">
                        <div class="group perspective-1000 relative z-10 w-full sm:w-[36%]">
                            <div
                                class="relative h-full w-full overflow-hidden rounded-2xl border border-white/5 bg-gray-900/50 p-3 backdrop-blur-sm transition-all duration-300 hover:border-red-500/50 hover:bg-gray-900/80 hover:shadow-[0_0_30px_rgba(220,38,38,0.1)]">

                                <div class="relative aspect-3/4 overflow-hidden rounded-xl bg-gray-800">
                                    @php
                                        $photoUrl = $pgrs->getFirstMediaUrl('foto_pengurus', 'card');
                                        $defaultPhoto =
                                            'https://ui-avatars.com/api/?name=' .
                                            urlencode($pgrs->member->full_name) .
                                            '&background=0D0D0D&color=fff';
                                    @endphp
                                    <img src="{{ $photoUrl ?: $defaultPhoto }}" alt="{{ $pgrs->member->full_name }}"
                                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                        onerror="this.src='https://placehold.co/300x400/111111/666666?text=No+Photo';" />

                                    <div
                                        class="absolute inset-0 flex items-end justify-center bg-linear-to-t from-black/90 via-black/20 to-transparent p-4 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                        <div class="flex gap-3">
                                            <a href="{{ $pgrs->member->instagram_url }}"
                                                class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white backdrop-blur hover:bg-red-600">
                                                <i class="fa-brands fa-instagram text-sm"></i>
                                            </a>
                                            <a href="{{ $pgrs->member->linkedin_url }}"
                                                class="flex
                                                h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white
                                                backdrop-blur hover:bg-blue-600">
                                                <i class="fa-brands fa-linkedin-in text-sm"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 px-2 pb-2">
                                    <h3
                                        class="line-clamp-1 text-base font-bold text-white transition-colors group-hover:text-red-400">
                                        {{ $pgrs->member->full_name }}
                                    </h3>

                                    <div class="mt-2 flex items-center justify-between">
                                        <span
                                            class="rounded-md px-2 py-0.5 text-[10px] font-bold tracking-wider uppercase bg-red-500/20 text-red-500">
                                            {{ $pgrs->position }}
                                        </span>

                                        <i
                                            class="fa-solid fa-id-card text-gray-600 opacity-0 transition-opacity group-hover:opacity-100"></i>
                                    </div>
                                </div>

                                <div
                                    class="absolute bottom-0 left-0 h-1 w-0 bg-linear-to-r from-red-600 to-red-900 transition-all duration-500 group-hover:w-full">
                                </div>
                            </div>
                        </div>

                        @if ($index % 2 == 0)
                            @if (!$loop->last)
                                <img src="{{ asset('images/garis-1.png') }}" alt="connector"
                                    class="absolute right-[18%] -bottom-12 hidden w-[50%] opacity-50 invert sm:block lg:right-[15%]"
                                    style="
                                    filter: invert(1) drop-shadow(0 0 5px red);
                                "
                                    draggable="false" />
                            @endif
                        @else
                            <img src="{{ asset('images/garis-1.png') }}" alt="connector"
                                class="absolute -bottom-10 left-[23.6%] hidden w-[50%] scale-x-[-1] opacity-50 invert sm:block lg:left-[25.4%] xl:left-[20%] xl:-bottom-9"
                                style="
                                    filter: invert(1) drop-shadow(0 0 5px red);
                                "
                                draggable="false" />
                        @endif

                        @if ($loop->last)
                            <img src="{{ asset('images/garis-2.png') }}" alt="connector" width="20" height="20"
                                class="absolute right-12 -bottom-30 hidden w-[82%] md:block lg:right-12 lg:-bottom-37 xl:right-24 xl:-bottom-37 xl:w-[83%] 2xl:right-11 2xl:-bottom-41 2xl:w-[89%]"
                                draggable="false"
                                style="
                                    filter: invert(1) drop-shadow(0 0 5px red);
                                " />
                        @endif
                    </div>
                @empty
                    <div class="w-full rounded-2xl border border-dashed border-white/10 bg-white/5 py-20 text-center">
                        <p class="text-gray-400">
                            Data pengurus untuk periode ini belum tersedia.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-12 mb-12 flex w-full items-center justify-center md:hidden">
            <div class="h-px w-16 bg-linear-to-r from-transparent to-red-600"></div>
            <span
                class="rounded-full border border-red-900/30 bg-gray-900 px-6 py-2 text-sm font-bold tracking-widest text-red-500 uppercase shadow-lg shadow-red-900/10">
                Departemen
            </span>
            <div class="h-px w-16 bg-linear-to-l from-transparent to-red-600"></div>
        </div>

        <div class="relative z-10 container mx-auto md:mt-16 lg:mt-28 px-8">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 xl:gap-8 px-12 md:px-0">
                @foreach ($pengurus->filter(function ($member) {
        return $member->hierarchy_level === 2;
    }) as $pgrs)
                    <div class="group relative flex flex-col items-center">
                        <div
                            class="relative h-full w-full overflow-hidden rounded-2xl border border-white/5 bg-gray-900/50 p-3 backdrop-blur-sm transition-all duration-300 hover:border-red-500/50 hover:bg-gray-900/80 hover:shadow-[0_0_30px_rgba(220,38,38,0.1)]">

                            <div class="relative aspect-3/4 overflow-hidden rounded-xl bg-gray-800">
                                @php
                                    $photoUrlDept = $pgrs->getFirstMediaUrl('foto_pengurus', 'card');
                                    $defaultPhotoDept =
                                        'https://ui-avatars.com/api/?name=' .
                                        urlencode($pgrs->member->full_name) .
                                        '&background=0D0D0D&color=fff';
                                @endphp
                                <img src="{{ $photoUrlDept ?: $defaultPhotoDept }}"
                                    alt="{{ $pgrs->member->full_name }}"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                    onerror="this.src='https://placehold.co/300x400/111111/666666?text=No+Photo';" />

                                <div
                                    class="absolute inset-0 flex items-end justify-center bg-linear-to-t from-black/90 via-black/20 to-transparent p-4 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                    <div class="flex gap-3">
                                        <a href="{{ $pgrs->instagram_url }}"
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white backdrop-blur hover:bg-red-600">
                                            <i class="fa-brands fa-instagram text-sm"></i>
                                        </a>
                                        <a href="{{ $pgrs->linkedin_url }}"
                                            class="flex
                                                h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white
                                                backdrop-blur hover:bg-blue-600">
                                            <i class="fa-brands fa-linkedin-in text-sm"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 px-2 pb-2">
                                <h3
                                    class="line-clamp-1 text-base font-bold text-white transition-colors group-hover:text-red-400">
                                    {{ $pgrs->member->full_name }}
                                </h3>

                                <div class="mt-2 flex items-center justify-between">
                                    <span @class([
                                        'rounded-md px-2 py-0.5 text-[8px] lg:text-[10px] font-bold tracking-wider uppercase',
                                        'bg-red-500/20 text-red-500' =>
                                            str_contains(strtolower($pgrs->position), 'kepala') ||
                                            str_contains(strtolower($pgrs->position), 'koordinator'),
                                        'bg-gray-500/10 text-gray-400' =>
                                            !str_contains(strtolower($pgrs->position), 'kepala') &&
                                            !str_contains(strtolower($pgrs->position), 'koordinator'),
                                    ])>
                                        {{ $pgrs->position }}
                                    </span>

                                    <i
                                        class="fa-solid fa-id-card text-gray-600 opacity-0 transition-opacity group-hover:opacity-100"></i>
                                </div>
                            </div>

                            <div
                                class="absolute bottom-0 left-0 h-1 w-0 bg-linear-to-r from-red-600 to-red-900 transition-all duration-500 group-hover:w-full">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if($pengurus->where('hierarchy_level', 3)->count() > 0)
            <div class="mt-32 mb-12 flex w-full items-center justify-center">
            <div class="h-px w-16 bg-linear-to-r from-transparent to-red-600"></div>
            <span
                class="rounded-full border border-red-900/30 bg-gray-900 px-6 py-2 text-sm font-bold tracking-widest text-red-500 uppercase shadow-lg shadow-red-900/10">
                Bidang
            </span>
            <div class="h-px w-16 bg-linear-to-l from-transparent to-red-600"></div>
        </div>
        @endif

        <div class="relative z-10 container mx-auto md:mt-16 lg:mt-28 px-8">
            @php
                $nonDepartmentHeads = $pengurus->filter(function ($member) {
                    return $member->hierarchy_level === 3;
                });
            @endphp

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:gap-8 px-12 md:px-0">
                @foreach ($nonDepartmentHeads as $pgrs)
                    <div class="group relative flex flex-col items-center">
                        <div
                            class="relative h-full w-full overflow-hidden rounded-2xl border border-white/5 bg-gray-900/50 p-3 backdrop-blur-sm transition-all duration-300 hover:border-red-500/50 hover:bg-gray-900/80 hover:shadow-[0_0_30px_rgba(220,38,38,0.1)]">

                            <div class="relative aspect-3/4 overflow-hidden rounded-xl bg-gray-800">
                                @php
                                    $photoUrl = $pgrs->getFirstMediaUrl('foto_pengurus', 'card');
                                    $defaultPhoto =
                                        'https://ui-avatars.com/api/?name=' .
                                        urlencode($pgrs->member->full_name) .
                                        '&background=0D0D0D&color=fff';
                                @endphp
                                <img src="{{ $photoUrl ?: $defaultPhoto }}" alt="{{ $pgrs->member->full_name }}"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                    onerror="this.src='https://placehold.co/300x400/111111/666666?text=No+Photo';" />

                                <div
                                    class="absolute inset-0 flex items-end justify-center bg-linear-to-t from-black/90 via-black/20 to-transparent p-4 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                    <div class="flex gap-3">
                                        <a href="{{ $pgrs->member->instagram_url }}"
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white backdrop-blur hover:bg-red-600">
                                            <i class="fa-brands fa-instagram text-sm"></i>
                                        </a>
                                        <a href="{{ $pgrs->member->linkedin_url }}"
                                            class="flex
                                                h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white
                                                backdrop-blur hover:bg-blue-600">
                                            <i class="fa-brands fa-linkedin-in text-sm"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 px-2 pb-2">
                                <h3
                                    class="line-clamp-1 text-base font-bold text-white transition-colors group-hover:text-red-400">
                                    {{ $pgrs->member->full_name }}
                                </h3>

                                <div class="mt-2 flex items-center justify-between">
                                    <span
                                        class="rounded-md px-2 py-0.5 text-[8px] lg:text-[10px] font-bold tracking-wider uppercase bg-red-500/20 text-red-500">
                                        {{ $pgrs->bidang->name ?? $pgrs->department->name }}
                                    </span>

                                    <i
                                        class="fa-solid fa-id-card text-gray-600 opacity-0 transition-opacity group-hover:opacity-100"></i>
                                </div>
                            </div>

                            <div
                                class="absolute bottom-0 left-0 h-1 w-0 bg-linear-to-r from-red-600 to-red-900 transition-all duration-500 group-hover:w-full">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-guest-layout>
