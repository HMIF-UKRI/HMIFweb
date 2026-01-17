<x-guest-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'HMIF UKRI - Home',
            'description' =>
                'Selamat datang di website resmi Himpunan Mahasiswa Teknik Informatika UKRI. Temukan informasi terbaru tentang kegiatan, pengurus, dan visi misi kami.',
            'keywords' => 'hmif,ukri,himatif,hima,informatika,teknik informatika',
            'url' => url()->current(),
        ])
    </x-slot>

    <div class="bg-white">
        @include('components.hero')

        <div class="relative overflow-hidden bg-linear-to-r from-red-950 via-red-900 to-red-950 py-6">
            <div class="absolute inset-0 opacity-20">
                <div class="animate-slide absolute h-full w-1 bg-white" style="left: 20%; animation-delay: 0s"></div>
                <div class="animate-slide absolute h-full w-1 bg-white" style="left: 40%; animation-delay: 0.5s"></div>
                <div class="animate-slide absolute h-full w-1 bg-white" style="left: 60%; animation-delay: 1s"></div>
                <div class="animate-slide absolute h-full w-1 bg-white" style="left: 80%; animation-delay: 1.5s"></div>
            </div>

            <div class="absolute top-0 right-0 left-0 h-px bg-linear-to-r from-transparent via-red-400 to-transparent">
            </div>

            <div class="relative flex overflow-hidden">
                <div class="animate-marquee flex whitespace-nowrap">
                    <div class="flex items-center gap-8 px-4">
                        <span class="flex items-center gap-3 text-lg font-bold text-white">
                            <svg class="h-5 w-5 text-red-300" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            HIMPUNAN MAHASISWA TEKNIK INFORMATIKA
                        </span>
                        <span class="flex items-center gap-3 text-lg font-bold text-white">
                            <div class="flex gap-1">
                                <div class="h-2 w-2 animate-pulse rounded-full bg-red-400"></div>
                                <div class="h-2 w-2 animate-pulse rounded-full bg-white" style="animation-delay: 0.2s">
                                </div>
                                <div class="h-2 w-2 animate-pulse rounded-full bg-red-400"
                                    style="animation-delay: 0.4s">
                                </div>
                            </div>
                            ONE FAMILY • ONE GOAL
                        </span>
                        <span class="flex items-center gap-3 text-lg font-bold text-white">
                            <svg class="h-5 w-5 text-red-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                    clip-rule="evenodd" />
                            </svg>
                            INNOVATE • COLLABORATE • ACHIEVE
                        </span>
                        <span class="flex items-center gap-3 text-lg font-bold text-white">
                            <svg class="h-5 w-5 text-red-300" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                            </svg>
                            KABINET METAFORSA
                        </span>
                    </div>
                    <div class="flex items-center gap-8 px-4">
                        <span class="flex items-center gap-3 text-lg font-bold text-white">
                            <svg class="h-5 w-5 text-red-300" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            HIMPUNAN MAHASISWA TEKNIK INFORMATIKA
                        </span>
                        <span class="flex items-center gap-3 text-lg font-bold text-white">
                            <div class="flex gap-1">
                                <div class="h-2 w-2 animate-pulse rounded-full bg-red-400"></div>
                                <div class="h-2 w-2 animate-pulse rounded-full bg-white" style="animation-delay: 0.2s">
                                </div>
                                <div class="h-2 w-2 animate-pulse rounded-full bg-red-400"
                                    style="animation-delay: 0.4s">
                                </div>
                            </div>
                            ONE FAMILY • ONE GOAL
                        </span>
                        <span class="flex items-center gap-3 text-lg font-bold text-white">
                            <svg class="h-5 w-5 text-red-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                    clip-rule="evenodd" />
                            </svg>
                            INNOVATE • COLLABORATE • ACHIEVE
                        </span>
                        <span class="flex items-center gap-3 text-lg font-bold text-white">
                            <svg class="h-5 w-5 text-red-300" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                            </svg>
                            KABINET {{ $activePeriod->cabinet_name }}
                        </span>
                    </div>
                </div>
            </div>

            <div
                class="absolute right-0 bottom-0 left-0 h-px bg-linear-to-r from-transparent via-red-400 to-transparent">
            </div>
        </div>

        @include('components.about')

        @include('components.pengurus')

        @include('components.activities')

        {{-- @include('components.galery') --}}
    </div>
    </x-guest->
