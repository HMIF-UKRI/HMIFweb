<x-app-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Dashboard - HMIF UKRI',
            'description' => 'Dashboard HMIF UKRI.',
            'image' => asset('images/banner-kegiatan.png'),
            'url' => url()->current(),
        ])
    </x-slot>

    <x-slot name="header_title">Dashboard</x-slot>

    <div class="space-y-6">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 md:p-8">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-2">
                    <p class="text-[10px] font-black uppercase tracking-[0.4em] text-red-500">HMIF UKRI</p>
                    <h1 class="text-2xl font-black text-white md:text-3xl">
                        Dashboard <span class="text-red-600 italic">Kontrol</span>
                    </h1>
                    <p class="text-xs text-gray-400">
                        Kelola data organisasi, kegiatan, dan konten dari satu tempat.
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.managements.index') }}"
                        class="rounded-xl border border-red-600/30 bg-red-600/10 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-red-500 transition hover:bg-red-600 hover:text-white">
                        Kelola Pengurus
                    </a>
                    <a href="{{ route('admin.events.index') }}"
                        class="rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-white transition hover:border-red-600/40">
                        Kelola Event
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <a href="{{ route('admin.managements.index') }}"
                class="group rounded-2xl border border-white/10 bg-white/5 p-5 transition hover:border-red-600/40">
                <p class="text-[9px] font-black uppercase tracking-widest text-gray-500">Pengurus</p>
                <p class="mt-2 text-xl font-black text-white">Kelola Data</p>
                <p class="mt-1 text-[10px] text-gray-400">Tambah/ubah struktur organisasi</p>
            </a>
            <a href="{{ route('admin.members.index') }}"
                class="group rounded-2xl border border-white/10 bg-white/5 p-5 transition hover:border-red-600/40">
                <p class="text-[9px] font-black uppercase tracking-widest text-gray-500">Anggota</p>
                <p class="mt-2 text-xl font-black text-white">Direktori</p>
                <p class="mt-1 text-[10px] text-gray-400">Manajemen data anggota</p>
            </a>
            <a href="{{ route('admin.departments.index') }}"
                class="group rounded-2xl border border-white/10 bg-white/5 p-5 transition hover:border-red-600/40">
                <p class="text-[9px] font-black uppercase tracking-widest text-gray-500">Departemen</p>
                <p class="mt-2 text-xl font-black text-white">Master Data</p>
                <p class="mt-1 text-[10px] text-gray-400">Ring 1, Ristek, PSDM, dll</p>
            </a>
            <a href="{{ route('admin.bidangs.index') }}"
                class="group rounded-2xl border border-white/10 bg-white/5 p-5 transition hover:border-red-600/40">
                <p class="text-[9px] font-black uppercase tracking-widest text-gray-500">Bidang</p>
                <p class="mt-2 text-xl font-black text-white">Sub Departemen</p>
                <p class="mt-1 text-[10px] text-gray-400">Pendidikan, Pengmas, dll</p>
            </a>
        </div>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5 lg:col-span-2">
                <h3 class="text-sm font-black uppercase tracking-widest text-white">Aksi Cepat</h3>
                <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <a href="{{ route('admin.periods.index') }}"
                        class="rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-300 transition hover:border-red-600/40">
                        Atur Periode
                    </a>
                    <a href="{{ route('admin.events.index') }}"
                        class="rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-300 transition hover:border-red-600/40">
                        Tambah Event
                    </a>
                    <a href="{{ route('admin.blogs.index') }}"
                        class="rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-300 transition hover:border-red-600/40">
                        Kelola Blog
                    </a>
                    <a href="{{ route('admin.galleries.index') }}"
                        class="rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-300 transition hover:border-red-600/40">
                        Kelola Galeri
                    </a>
                </div>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                <h3 class="text-sm font-black uppercase tracking-widest text-white">Tips</h3>
                <ul class="mt-4 space-y-2 text-[10px] text-gray-400">
                    <li>Set "Show on Homepage" di menu Periode untuk ganti periode tampil.</li>
                    <li>Pastikan pengurus punya periode yang sama dengan homepage.</li>
                    <li>Ring 1 tampil langsung tanpa kepala departemen.</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
