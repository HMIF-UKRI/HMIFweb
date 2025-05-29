@extends("layouts.app")

@section("content")
    <section class="bg-white">
        <div
            style="background-image: url(images/banner-kegiatan.png)"
            class="flex min-h-screen w-full items-center justify-center bg-cover bg-center bg-no-repeat object-cover shadow-2xl shadow-red-500/50"
        >
            <div class="flex h-full items-center justify-center">
                <div class="w-3xl text-center text-white">
                    <div class="flex items-center">
                        <span
                            class="h-px flex-1 bg-gradient-to-r from-transparent to-gray-300 dark:to-gray-600"
                        ></span>

                        <span
                            class="shrink-0 bg-gradient-to-r from-red-100 to-red-600/80 bg-clip-text px-4 text-4xl font-bold tracking-wider text-transparent uppercase"
                        >
                            Kegiatan HMIF
                        </span>

                        <span
                            class="h-px flex-1 bg-gradient-to-l from-transparent to-gray-300 dark:to-gray-600"
                        ></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
