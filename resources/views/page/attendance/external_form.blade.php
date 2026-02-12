<x-guest-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Konfirmasi Kehadiran - ' . $event->title,
            'description' => 'Silakan konfirmasi kehadiran Anda untuk kegiatan ' . $event->event_name,
            'url' => url()->current(),
        ])
    </x-slot>

    <div
        class="relative min-h-screen md:h-screen flex items-start md:items-center justify-center py-20 md:py-0 px-4 sm:px-6 lg:px-8 overflow-hidden">

        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-3xl h-full opacity-20 pointer-events-none">
            <div class="absolute top-10 left-5 w-48 h-48 bg-red-600 blur-[80px] rounded-full"></div>
            <div class="absolute bottom-10 right-5 w-48 h-48 bg-red-900 blur-[80px] rounded-full"></div>
        </div>

        <div class="relative z-10 w-full max-w-2xl my-auto">
            <div class="mb-6 text-center space-y-2">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/10 border border-red-500/20 text-[9px] font-black uppercase tracking-[0.2em] text-red-500">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                    </span>
                    Guest Presence System
                </span>
                <h2 class="text-2xl md:text-4xl font-black text-white uppercase tracking-tighter italic">
                    Absensi <span class="text-red-600">Tamu</span>
                </h2>
                <p class="text-gray-500 text-[10px] md:text-sm font-medium">Kegiatan: <span
                        class="text-gray-300">{{ $event->title }}</span></p>
            </div>

            <div
                class="bg-white/0.03 backdrop-blur-2xl border border-white/10 rounded-3xl md:rounded-[2.5rem] p-5 md:p-10 shadow-2xl ring-1 ring-white/5">
                <form action="{{ route('attendance.submit', $event->slug) }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="participant_type" value="external">

                    <div class="space-y-4">
                        <div class="space-y-1.5">
                            <label for="external_name"
                                class="text-[9px] font-bold text-gray-500 uppercase tracking-widest ml-1 flex items-center gap-2">
                                <i class="fa-solid fa-signature text-red-500"></i> Nama Lengkap
                            </label>
                            <input type="text" name="external_name" id="external_name" required
                                class="w-full bg-black/40 border border-white/10 rounded-xl py-3 px-5 text-sm text-white placeholder:text-gray-700 focus:outline-none focus:border-red-600/50 focus:ring-4 focus:ring-red-600/10 transition-all duration-300"
                                placeholder="Masukkan nama lengkap">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label for="external_npm"
                                    class="text-[9px] font-bold text-gray-500 uppercase tracking-widest ml-1 flex items-center gap-2">
                                    <i class="fa-solid fa-id-card text-red-500"></i> NPM / ID Identitas
                                </label>
                                <input type="text" name="external_npm" id="external_npm" required
                                    class="w-full bg-black/40 border border-white/10 rounded-xl py-3 px-5 text-sm text-white placeholder:text-gray-700 focus:outline-none focus:border-red-600/50 focus:ring-4 focus:ring-red-600/10 transition-all duration-300"
                                    placeholder="Nomor identitas">
                            </div>

                            <div class="space-y-1.5">
                                <label for="external_prodi"
                                    class="text-[9px] font-bold text-gray-500 uppercase tracking-widest ml-1 flex items-center gap-2">
                                    <i class="fa-solid fa-school text-red-500"></i> Instansi / Prodi
                                </label>
                                <input type="text" name="external_prodi" id="external_prodi" required
                                    class="w-full bg-black/40 border border-white/10 rounded-xl py-3 px-5 text-sm text-white placeholder:text-gray-700 focus:outline-none focus:border-red-600/50 focus:ring-4 focus:ring-red-600/10 transition-all duration-300"
                                    placeholder="Contoh: Teknik Informatika">
                            </div>

                            <div class="md:col-span-2 space-y-1.5">
                                <label for="external_angkatan"
                                    class="text-[9px] font-bold text-gray-500 uppercase tracking-widest ml-1 flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-days text-red-500"></i> Angkatan
                                </label>
                                <input type="number" name="external_angkatan" id="external_angkatan" required
                                    class="w-full bg-black/40 border border-white/10 rounded-xl py-3 px-5 text-sm text-white placeholder:text-gray-700 focus:outline-none focus:border-red-600/50 focus:ring-4 focus:ring-red-600/10 transition-all duration-300"
                                    placeholder="Contoh: 2024">
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-xl shadow-lg shadow-red-900/30 transition-all active:scale-95 flex items-center justify-center gap-3">
                            <span class="text-sm tracking-widest uppercase">Kirim Presensi</span>
                            <i class="fa-solid fa-paper-plane text-xs"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
