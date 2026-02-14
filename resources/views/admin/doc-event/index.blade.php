<x-app-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Archive Document - HMIF UKRI',
            'description' =>
                'Portal Internal Pengurus HMIF UKRI untuk mengelola konten dan kegiatan organisasi secara efisien.',
            'keywords' => 'hmif, ukri, himatif, hima, informatika, kegiatan, agenda, seminar, workshop',
            'image' => asset('images/banner-kegiatan.png'),
            'url' => url()->current(),
        ])
    </x-slot>

    <x-slot name="header_title">Arsip Dokumen</x-slot>

    <div class="space-y-6 p-4 md:p-0" x-data="{
        previewModal: false,
        pdfUrl: '',
        docTitle: '',
        openPreview(url, title) {
            this.pdfUrl = url;
            this.docTitle = title;
            this.previewModal = true;
        }
    }">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-white uppercase tracking-tight">Data Arsip Proker</h1>
                <p class="text-xs text-gray-500 uppercase tracking-widest mt-1">Manajemen Proposal & LPJ</p>
            </div>

            <button @click.prevent="$dispatch('open-modal', 'modal-upload-arsip')"
                class="flex items-center justify-center gap-3 px-6 py-3 bg-red-600 hover:bg-red-700 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl transition-all shadow-lg shadow-red-600/20 group">
                <ion-icon name="cloud-upload-outline"
                    class="text-lg group-hover:scale-110 transition-transform"></ion-icon>
                Upload Dokumen
            </button>
        </div>

        <form action="{{ route('admin.doc-event.index') }}" method="GET"
            class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-white/5 p-4 rounded-2xl border border-white/10">
            <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
                    <ion-icon name="search-outline"></ion-icon>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari proker..."
                    class="w-full bg-black/20 border-white/10 rounded-xl pl-10 py-3 text-xs text-white focus:ring-red-600 focus:border-red-600">
            </div>

            <select name="period_id"
                class="bg-black/20 border-white/10 rounded-xl text-xs text-white focus:ring-red-600 focus:border-red-600">
                <option value="">Semua Periode</option>
                @foreach ($periods as $period)
                    <option value="{{ $period->id }}" {{ request('period_id') == $period->id ? 'selected' : '' }}>
                        {{ $period->cabinet_name }}
                    </option>
                @endforeach
            </select>

            <select name="type"
                class="bg-black/20 border-white/10 rounded-xl text-xs text-white focus:ring-red-600 focus:border-red-600">
                <option value="">Semua Tipe</option>
                <option value="proposal" {{ request('type') == 'proposal' ? 'selected' : '' }}>PROPOSAL</option>
                <option value="lpj" {{ request('type') == 'lpj' ? 'selected' : '' }}>LPJ</option>
            </select>

            <div class="flex gap-2">
                <button type="submit"
                    class="flex-1 bg-white/10 hover:bg-white/20 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all font-poppins">Filter</button>
                <a href="{{ route('admin.doc-event.index') }}"
                    class="px-4 py-2 bg-red-600/10 text-red-500 hover:bg-red-600 hover:text-white rounded-xl transition-all flex items-center justify-center">
                    <ion-icon name="refresh-outline"></ion-icon>
                </a>
            </div>
        </form>

        <div class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden backdrop-blur-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/2">
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama
                                Kegiatan / Nama File</th>
                            <th
                                class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
                                Tipe</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Periode
                            </th>
                            <th
                                class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($documents as $doc)
                            <tr class="hover:bg-white/2 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <button type="button"
                                            @click="openPreview('{{ route('admin.archive.view', $doc->id) }}', '{{ $doc->name }}')"
                                            class="text-left text-sm font-bold text-white hover:text-red-500 transition-colors focus:outline-none">
                                            {{ $doc->name }}
                                        </button>
                                        <span
                                            class="text-[10px] text-gray-500 uppercase tracking-tighter">{{ $doc->event->title ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="px-3 py-1 {{ $doc->type_document == 'proposal' ? 'bg-blue-500/10 text-blue-500 border-blue-500/20' : 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20' }} text-[9px] font-black uppercase tracking-widest rounded-full border">
                                        {{ strtoupper($doc->type_document) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-400 font-medium">
                                    {{ $doc->period->cabinet_name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.archive.download', $doc->id) }}"
                                            class="p-2 bg-white/5 hover:bg-white/10 text-white rounded-lg transition-all border border-white/10">
                                            <ion-icon name="download-outline"></ion-icon>
                                        </a>
                                        <form action="{{ route('admin.doc-event.destroy', $doc->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus arsip ini? File fisik juga akan dihapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 bg-red-600/10 hover:bg-red-600 text-red-500 hover:text-white rounded-lg transition-all border border-red-500/20"
                                                title="Hapus">
                                                <ion-icon name="trash-outline"></ion-icon>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="px-6 py-12 text-center text-gray-500 uppercase text-[10px] font-bold tracking-widest opacity-30 italic">
                                    Belum ada arsip proker</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <template x-if="previewModal">
            <div class="fixed inset-0 z-100 flex items-center justify-center p-4 sm:p-6">
                <div class="fixed inset-0 bg-black/95 backdrop-blur-md transition-opacity"
                    @click="previewModal = false"></div>
                <div
                    class="relative bg-gray-900 w-full max-w-3xl h-[85vh] rounded-3xl border border-white/10 flex flex-col overflow-hidden shadow-2xl transition-all mt-12">
                    <div class="p-4 border-b border-white/10 flex justify-between items-center bg-gray-950/50">
                        <div class="flex items-center gap-3">
                            <ion-icon name="document-text" class="text-red-500 text-xl"></ion-icon>
                            <h3 class="text-[10px] font-black text-white uppercase tracking-[0.2em]" x-text="docTitle">
                            </h3>
                        </div>
                        <button @click="previewModal = false" class="text-gray-400 hover:text-white transition-colors">
                            <ion-icon name="close-outline" class="text-3xl"></ion-icon>
                        </button>
                    </div>
                    <div class="flex-1 bg-gray-950">
                        <iframe :src="pdfUrl" class="w-full h-full border-none shadow-inner"></iframe>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <x-modal name="modal-upload-arsip" focusable>
        <form method="POST" action="{{ route('admin.doc-event.store') }}" enctype="multipart/form-data"
            class="p-8 bg-gray-950 border border-white/10 rounded-3xl">
            @csrf
            <h2 class="text-xl font-black text-white uppercase tracking-tight">Upload Arsip Baru</h2>
            <p
                class="text-[10px] text-gray-500 uppercase tracking-widest mt-1 mb-6 border-b border-white/5 pb-4 italic">
                Format PDF • Maksimal 20MB</p>

            <div class="space-y-4">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Pilih
                        Kegiatan</label>
                    <select name="event_id"
                        class="w-full bg-white/5 border border-white/10 rounded-xl text-sm focus:ring-red-600 p-3"
                        required>
                        <option value="" disabled selected>-- Pilih Proker --</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}">{{ $event->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tipe
                            Dokumen</label>
                        <select name="type_document"
                            class="w-full bg-white/5 border border-white/10 rounded-xl text-sm focus:ring-red-600 p-3"
                            required>
                            <option value="proposal">PROPOSAL</option>
                            <option value="lpj">LPJ</option>
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 cursor-pointer">File
                            PDF</label>
                        <input type="file" name="file" accept="application/pdf"
                            class="w-full text-[10px] text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-red-600 file:text-white cursor-pointer"
                            required>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-white transition-colors font-poppins">Batal</button>
                <button type="submit"
                    class="px-8 py-3 bg-white text-black text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-red-600 hover:text-white transition-all font-poppins">Simpan
                    Arsip</button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
