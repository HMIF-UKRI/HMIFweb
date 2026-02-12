<x-guest-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Konfirmasi Kehadiran - ' . $event->title,
            'description' => 'Silakan konfirmasi kehadiran Anda untuk kegiatan ' . $event->title,
            'url' => url()->current(),
        ])
    </x-slot>

    <div class="relative min-h-screen flex items-center justify-center py-12 px-4 overflow-hidden">
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-red-600/10 blur-[120px] rounded-full">
        </div>

        <div class="relative z-10 w-full max-w-xl">
            <div
                class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 md:p-12 shadow-2xl text-center">

                <div class="mb-6">
                    <span
                        class="inline-flex items-center rounded-full border border-red-500/30 bg-red-900/20 px-4 py-1.5 text-xs font-bold tracking-widest text-red-400 uppercase">
                        {{ $event->category->name ?? 'Event HMIF' }}
                    </span>
                </div>

                <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-2 leading-tight">
                    {{ $event->title }}
                </h1>
                <p class="text-gray-400 text-sm mb-10">Presensi Digital HMIF UKRI</p>

                @if (auth()->check())
                    <div class="space-y-6">
                        <div class="flex flex-col items-center gap-4 py-6 bg-white/5 rounded-3xl border border-white/5">
                            <div
                                class="h-16 w-16 bg-red-600/20 rounded-2xl flex items-center justify-center text-red-500 text-2xl">
                                <i class="fa-solid fa-user-check"></i>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Masuk sebagai</p>
                                <p class="text-white font-bold text-lg">{{ auth()->user()->member->full_name }}</p>
                            </div>
                        </div>

                        <form action="{{ route('attendance.submit', $event->slug) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full group relative flex items-center justify-center overflow-hidden rounded-2xl bg-red-600 px-8 py-4 text-center font-bold text-white shadow-lg shadow-red-900/40 transition duration-300 hover:scale-[1.02] hover:bg-red-700">
                                <span class="relative z-10 flex items-center gap-2">
                                    Konfirmasi Kehadiran
                                    <i
                                        class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                                </span>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="space-y-8">
                        <div class="p-6 bg-yellow-500/5 rounded-3xl border border-yellow-500/20">
                            <i class="fa-solid fa-user-astronaut text-4xl text-yellow-500 mb-4"></i>
                            <p class="text-white font-semibold">Tamu / Non-Anggota</p>
                            <p class="text-gray-400 text-xs mt-2 leading-relaxed">
                                Anda belum masuk ke sistem. Silakan isi data diri untuk mendata kehadiran Anda secara
                                manual.
                            </p>
                        </div>

                        <a href="#form-external"
                            class="flex items-center justify-center gap-2 w-full bg-white text-dark font-black py-4 rounded-2xl transition hover:bg-gray-200">
                            Lanjut Isi Form
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>
