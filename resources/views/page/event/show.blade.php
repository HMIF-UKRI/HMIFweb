@extends("layouts.app")

@section("meta")
    @include(
        "components._meta",
        [
            "title" => $event->title . " - HMIF UKRI",
            "description" => $event->short_description,
            "keywords" =>
                "hmif, ukri, himatif, hima, informatika, " .
                strtolower(str_replace(" ", ", ", $event->title)),
            "image" => asset("storage/" . $event->thumbnail_path),
            "url" => url()->current(),
        ]
    )
@endsection

@section("content")
    <div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <div class="mt-16 mb-6">
            <a
                href="/kegiatan"
                class="inline-flex items-center font-semibold text-red-600 transition duration-300 ease-in-out hover:text-red-700"
            >
                <svg
                    class="mr-2 h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"
                    ></path>
                </svg>
                Kembali ke Daftar Program
            </a>
        </div>

        <main class="mb-8 grid grid-cols-1 gap-8 lg:grid-cols-3">
            {{-- Left Column: Thumbnail, Title, Short Description, Main Description --}}
            <div
                class="rounded-xl border border-gray-100 bg-white p-6 drop-shadow-xl drop-shadow-red-600 md:p-8 lg:col-span-2"
            >
                <!-- Thumbnail & Title Section -->
                <div class="relative mb-6 overflow-hidden rounded-lg shadow-md">
                    <!-- Thumbnail -->
                    <img
                        src="{{ asset("storage/" . $event->thumbnail_path) }}"
                        alt="Thumbnail Kegiatan {{ $event->title }} HMIF UKRI"
                        class="h-72 w-full transform object-cover transition duration-500 ease-in-out hover:scale-105 sm:h-96"
                        onerror="this.onerror=null; this.src='https://placehold.co/1200x500/cccccc/333333?text=Gambar+Tidak+Tersedia';"
                    />

                    <!-- Title Overlay -->
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent opacity-80"
                    ></div>
                    <div class="absolute bottom-0 left-0 w-full p-6 text-white">
                        <span
                            class="mb-3 inline-block rounded-full bg-red-600 px-4 py-2 text-xs font-bold tracking-wide text-white uppercase"
                        >
                            {{ $event->eventCategory->name ?? "Tidak Berkategori" }}
                        </span>
                        <h1
                            class="text-4xl leading-tight font-extrabold drop-shadow-lg sm:text-5xl lg:text-6xl"
                        >
                            {{ $event->title }}
                        </h1>
                        <p class="mt-2 text-lg text-gray-200">
                            {{ $event->short_description }}
                        </p>
                    </div>
                </div>

                <!-- Full Description -->
                <div
                    class="prose mt-8 max-w-none leading-relaxed text-gray-800"
                >
                    <h2 class="mb-4 text-2xl font-bold text-black">
                        Deskripsi Lengkap
                    </h2>
                    {!! $event->description !!}

                    {{-- Share Section --}}
                    <div
                        class="mt-8 flex items-center space-x-4 border-t border-gray-200 pt-4 text-gray-600"
                    >
                        <span class="font-semibold">Bagikan:</span>
                        <a
                            href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                            target="_blank"
                            class="transition duration-200 hover:text-red-600"
                        >
                            <img
                                src="https://img.icons8.com/ios-filled/24/000000/facebook-new.png"
                                alt="Facebook"
                                class="h-6 w-6"
                            />
                        </a>
                        <a
                            href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ urlencode($event->title) }}"
                            target="_blank"
                            class="transition duration-200 hover:text-red-600"
                        >
                            <img
                                src="https://img.icons8.com/ios-filled/24/000000/twitterx.png"
                                alt="Twitter"
                                class="h-6 w-6"
                            />
                        </a>
                        <a
                            href="https://wa.me/?text={{ urlencode($event->title . " - " . url()->current()) }}"
                            target="_blank"
                            class="transition duration-200 hover:text-red-600"
                        >
                            <img
                                src="https://img.icons8.com/ios-filled/24/000000/whatsapp--v1.png"
                                alt="WhatsApp"
                                class="h-6 w-6"
                            />
                        </a>
                    </div>
                </div>
            </div>

            {{-- Right Column: Event Details Card & Related Events --}}
            <div class="flex flex-col gap-8 lg:col-span-1">
                <!-- Event Details Card -->
                <div
                    class="shadow-custom-lg rounded-xl border border-gray-100 bg-white p-6 drop-shadow-xl drop-shadow-red-600"
                >
                    <h2
                        class="mb-5 border-b border-gray-200 pb-3 text-xl font-bold text-black"
                    >
                        Detail Kegiatan
                    </h2>
                    <div class="space-y-4">
                        <!-- Date -->
                        <div class="flex items-start">
                            <svg
                                class="mr-4 h-6 w-6 flex-shrink-0 text-red-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                ></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Tanggal</p>
                                <p class="font-semibold text-black">
                                    {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat("d F Y") }}
                                </p>
                            </div>
                        </div>
                        <!-- Location -->
                        <div class="flex items-start">
                            <svg
                                class="mr-4 h-6 w-6 flex-shrink-0 text-red-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.657 16.727A8 8 0 0120 18a8 8 0 01-2.343 5.657M16 12V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v8m-1 8h.01M6 20h.01M6 16h.01M6 12h.01M6 8h.01M6 4h.01M4 20h.01M4 16h.01M4 12h.01M4 8h.01M4 4h.01M2 20h.01M2 16h.01M2 12h.01M2 8h.01M2 4h.01"
                                ></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Lokasi</p>
                                <p class="font-semibold text-black">
                                    {{ $event->location }}
                                </p>
                            </div>
                        </div>
                        <!-- Status -->
                        <div class="flex items-start">
                            <svg
                                class="mr-4 h-6 w-6 flex-shrink-0 text-red-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <p class="font-semibold text-black">
                                    {{ $event->status }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Related Events Section --}}
                <div
                    class="shadow-custom-lg rounded-xl border border-gray-100 bg-white p-6 drop-shadow-xl drop-shadow-red-600"
                >
                    <h2
                        class="mb-5 border-b border-gray-200 pb-3 text-xl font-bold text-black"
                    >
                        Kegiatan Terkait
                    </h2>
                    <div class="space-y-4">
                        @forelse ($relatedEvents as $relatedEvent)
                            <a
                                href="{{ route("event.show", $relatedEvent->slug) }}"
                                class="group flex items-center space-x-4 rounded-lg p-3 transition duration-200 hover:bg-gray-50"
                            >
                                <img
                                    src="{{ asset("storage/" . $relatedEvent->thumbnail_path) }}"
                                    alt="{{ $relatedEvent->title }}"
                                    class="h-16 w-16 flex-shrink-0 rounded-md object-cover group-hover:shadow-md"
                                    onerror="this.onerror=null; this.src='https://placehold.co/120x80/cccccc/333333?text=No+Image';"
                                />
                                <div>
                                    <h3
                                        class="text-base font-semibold text-black group-hover:text-red-600"
                                    >
                                        {{ $relatedEvent->title }}
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($relatedEvent->event_date)->translatedFormat("d F Y") }}
                                    </p>
                                </div>
                            </a>
                        @empty
                            <p class="text-center text-sm text-gray-500">
                                Tidak ada kegiatan terkait lainnya.
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
