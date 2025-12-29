@extends("layouts.app")

@section("meta")
    @include(
        "components._meta",
        [
            "title" => "Struktur Pengurus - HMIF UKRI",
            "description" =>
                "Struktur organisasi dan fungsionaris Himpunan Mahasiswa Teknik Informatika UKRI.",
            "keywords" =>
                "struktur, pengurus, hmif, ukri, himatif, hima, informatika, organisasi",
            "image" => asset("images/banner.png"),
            "url" => url()->current(),
        ]
    )
@endsection

@section("content")
    <div
        class="min-h-screen bg-gray-950 pb-20 font-sans text-white selection:bg-red-500 selection:text-white"
    >
        <div
            class="pointer-events-none fixed inset-0 z-0 opacity-[0.03]"
            style="
                background-image: url('https://grainy-gradients.vercel.app/noise.svg');
            "
        ></div>
        <div
            class="pointer-events-none fixed top-0 left-1/2 z-0 h-[500px] w-full max-w-7xl -translate-x-1/2 rounded-full bg-red-900/20 blur-[120px]"
        ></div>

        <div class="relative z-10 px-4 pt-32 pb-12 text-center sm:px-6 lg:px-8">
            <h1
                class="mb-6 text-4xl font-extrabold tracking-tight text-white drop-shadow-2xl md:text-5xl"
            >
                Struktur
                <span
                    class="bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent"
                >
                    Pengurus
                </span>
            </h1>

            <p class="mx-auto mb-10 max-w-2xl text-gray-400">
                Mengenal lebih dekat fungsionaris yang berdedikasi untuk
                memajukan HMIF UKRI pada setiap periodenya.
            </p>

            <div class="group relative mx-auto inline-block w-full max-w-sm">
                <div
                    class="absolute -inset-1 rounded-xl bg-gradient-to-r from-red-600 to-red-900 opacity-25 blur transition duration-200 group-hover:opacity-50"
                ></div>
                <div
                    class="relative flex items-center rounded-xl border border-white/10 bg-gray-900 p-1"
                >
                    <div class="pl-4 text-red-500">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>

                    <form
                        action="{{ url()->current() }}"
                        method="GET"
                        class="w-full"
                    >
                        <select
                            name="period"
                            onchange="this.form.submit()"
                            class="w-full cursor-pointer appearance-none rounded-lg bg-transparent px-4 py-3 text-center font-bold text-white focus:ring-0 focus:outline-none sm:text-left"
                        >
                            @foreach ($currentPeriod as $period)
                                <option
                                    value="{{ $period->id }}"
                                    class="bg-gray-900 text-left"
                                    {{ request("period") == $period->id ? "selected" : "" }}
                                >
                                    Kabinet {{ $period->name }}
                                    ({{ $period->start_date }} -
                                    {{ $period->is_current }})
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <div class="pointer-events-none pr-4 text-gray-400">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            @if (isset($activePeriod) && $activePeriod->logo)
                <div class="animate-fade-in-up mt-12 mb-8">
                    <img
                        src="{{ asset("storage/" . $activePeriod->logo) }}"
                        alt="Logo Kabinet {{ $activePeriod->name }}"
                        class="mx-auto h-32 w-auto object-contain drop-shadow-[0_0_15px_rgba(255,255,255,0.1)] transition duration-500 hover:scale-105 md:h-40"
                        draggable="false"
                    />
                    <h2
                        class="mt-4 text-xl font-bold tracking-widest text-red-500 uppercase"
                    >
                        Kabinet {{ $activePeriod->name }}
                    </h2>
                </div>
            @else
                <div class="mt-12 mb-8">
                    <img
                        src="{{ asset("images/logo.png") }}"
                        alt="HMIF Logo"
                        class="mx-auto h-24 w-auto object-contain opacity-50 grayscale"
                        draggable="false"
                    />
                </div>
            @endif
        </div>

        <div class="relative z-10 container mx-auto px-4">
            <div class="mb-16 flex w-full items-center justify-center">
                <div
                    class="h-px w-16 bg-gradient-to-r from-transparent to-red-600"
                ></div>
                <span
                    class="rounded-full border border-red-900/30 bg-gray-900 px-6 py-2 text-sm font-bold tracking-widest text-red-500 uppercase shadow-lg shadow-red-900/10"
                >
                    Badan Pengurus Harian
                </span>
                <div
                    class="h-px w-16 bg-gradient-to-l from-transparent to-red-600"
                ></div>
            </div>

            <div class="flex flex-col items-center justify-center px-4 md:px-0">
                @forelse ($members as $index => $member)
                    <div
                        class="{{ $index % 2 == 0 ? "md:flex-row" : "md:flex-row-reverse" }} relative mb-16 flex w-full max-w-5xl flex-col items-center md:mb-12 md:items-start md:gap-12 lg:gap-20"
                    >
                        <div
                            class="group perspective-1000 relative z-10 w-full md:w-[40%]"
                        >
                            <div
                                class="absolute -inset-1 rounded-2xl bg-gradient-to-br from-red-600 to-black opacity-20 blur transition duration-500 group-hover:opacity-40"
                            ></div>

                            <div
                                class="relative overflow-hidden rounded-xl border border-white/10 bg-gray-900 shadow-2xl transition-transform duration-500 group-hover:rotate-y-2 group-hover:transform"
                            >
                                <img
                                    src="{{ asset("storage/" . $member->image) }}"
                                    alt="{{ $member->name }}"
                                    class="h-auto w-full transform object-cover transition duration-700 group-hover:scale-105"
                                    draggable="false"
                                    onerror="this.onerror=null; this.src='https://placehold.co/400x500/1a1a1a/cccccc?text=No+Photo';"
                                />

                                <div
                                    class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black via-black/80 to-transparent p-4 pt-12 text-center md:text-left"
                                >
                                    <h3 class="text-lg font-bold text-white">
                                        {{ $member->name }}
                                    </h3>
                                    <p
                                        class="text-sm font-medium tracking-wide text-red-400 uppercase"
                                    >
                                        {{ $member->position }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if ($index % 2 == 0)
                            <img
                                src="{{ asset("images/garis-1.png") }}"
                                alt="connector"
                                class="absolute right-[10%] -bottom-12 hidden w-[50%] opacity-50 invert md:block lg:right-[15%]"
                                style="
                                    filter: invert(1) drop-shadow(0 0 5px red);
                                "
                                draggable="false"
                            />
                        @else
                            <img
                                src="{{ asset("images/garis-1.png") }}"
                                alt="connector"
                                class="absolute -bottom-10 left-[10%] hidden w-[50%] scale-x-[-1] opacity-50 invert md:block lg:left-[15%]"
                                style="
                                    filter: invert(1) drop-shadow(0 0 5px red);
                                "
                                draggable="false"
                            />
                        @endif

                        @if ($member->position == "Sekretaris" || $index == 0)
                            {{-- <div class="absolute ..."></div> --}}
                        @endif
                    </div>
                @empty
                    <div
                        class="w-full rounded-2xl border border-dashed border-white/10 bg-white/5 py-20 text-center"
                    >
                        <p class="text-gray-400">
                            Data pengurus untuk periode ini belum tersedia.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="relative z-10 container mx-auto mt-20 px-4">
            <div class="mb-12 flex w-full items-center justify-center">
                <div
                    class="h-px w-16 bg-gradient-to-r from-transparent to-red-600"
                ></div>
                <span
                    class="rounded-full border border-red-900/30 bg-gray-900 px-6 py-2 text-sm font-bold tracking-widest text-red-500 uppercase shadow-lg shadow-red-900/10"
                >
                    Departemen & Divisi
                </span>
                <div
                    class="h-px w-16 bg-gradient-to-l from-transparent to-red-600"
                ></div>
            </div>

            <div class="grid grid-cols-1 gap-8 px-4 md:grid-cols-3 lg:px-12">
                <div
                    class="group relative rounded-2xl border border-white/10 bg-gray-900 p-2 transition hover:-translate-y-2 hover:border-red-600/50"
                >
                    <div class="relative overflow-hidden rounded-xl bg-black">
                        <img
                            src="{{ asset("images/pengurus/ristek.png") }}"
                            alt="Ristek"
                            class="h-64 w-full object-contain object-center transition duration-500 group-hover:scale-110"
                            draggable="false"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-60"
                        ></div>
                        <div class="absolute bottom-4 left-4">
                            <h3
                                class="text-xl font-bold text-white transition group-hover:text-red-500"
                            >
                                RISTEK
                            </h3>
                            <p class="text-xs text-gray-400">
                                Riset & Teknologi
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="group relative rounded-2xl border border-white/10 bg-gray-900 p-2 transition hover:-translate-y-2 hover:border-red-600/50"
                >
                    <div class="relative overflow-hidden rounded-xl bg-black">
                        <img
                            src="{{ asset("images/pengurus/psdm.png") }}"
                            alt="PSDM"
                            class="h-64 w-full object-contain object-center transition duration-500 group-hover:scale-110"
                            draggable="false"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-60"
                        ></div>
                        <div class="absolute bottom-4 left-4">
                            <h3
                                class="text-xl font-bold text-white transition group-hover:text-red-500"
                            >
                                PSDM
                            </h3>
                            <p class="text-xs text-gray-400">
                                Pengembangan Sumber Daya Mahasiswa
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="group relative rounded-2xl border border-white/10 bg-gray-900 p-2 transition hover:-translate-y-2 hover:border-red-600/50"
                >
                    <div class="relative overflow-hidden rounded-xl bg-black">
                        <img
                            src="{{ asset("images/pengurus/kominfo.png") }}"
                            alt="Kominfo"
                            class="h-64 w-full object-contain object-center transition duration-500 group-hover:scale-110"
                            draggable="false"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-60"
                        ></div>
                        <div class="absolute bottom-4 left-4">
                            <h3
                                class="text-xl font-bold text-white transition group-hover:text-red-500"
                            >
                                KOMINFO
                            </h3>
                            <p class="text-xs text-gray-400">
                                Komunikasi & Informasi
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .perspective-1000 {
            perspective: 1000px;
        }
        .rotate-y-2 {
            transform: rotateY(5deg);
        }
    </style>

    <script>
        // Opsional: Jika ingin animasi atau logic tambahan saat ganti periode
    </script>
@endsection
