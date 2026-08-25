<x-app-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Arsip Dokumen Organisasi & Kegiatan — HMIF UKRI',
            'description' => 'Pusat repositori dan pengarsipan berkas administratif resmi HMIF UKRI (Proposal, LPJ, RAB, Surat, TOR, Notulensi).',
            'image' => asset('images/banner-kegiatan.png'),
            'url' => url()->current(),
        ])
    </x-slot>

    <x-slot name="header_title">Arsip Dokumen</x-slot>

    <div class="space-y-6 pb-16" x-data="{
        previewModal: false,
        pdfUrl: '',
        downloadUrl: '',
        docTitle: '',
        docType: '',
        openPreview(url, dlUrl, title, type) {
            this.pdfUrl = url;
            this.downloadUrl = dlUrl;
            this.docTitle = title;
            this.docType = type;
            this.previewModal = true;
        }
    }">
        {{-- ===== HEADER & ACTION BAR ===== --}}
        <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-gray-900/60 backdrop-blur-xl px-6 py-5 md:px-8 md:py-6">
            <div class="pointer-events-none absolute -right-20 -top-20 h-80 w-80 rounded-full bg-red-600/10 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-16 -left-16 h-64 w-64 rounded-full bg-blue-600/5 blur-3xl"></div>

            <div class="relative flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div class="space-y-1.5">
                    <div class="flex items-center gap-2.5">
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-red-500/30 bg-red-600/15 px-2.5 py-0.5 text-[10px] font-black uppercase tracking-widest text-red-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500 animate-pulse"></span>
                            Document Archive
                        </span>
                        <span class="text-[11px] font-semibold text-gray-400">Pusat Repositori Berkas Resmi</span>
                    </div>
                    <h1 class="text-2xl font-black tracking-tight text-white md:text-3xl">
                        Arsip <span class="italic text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-rose-400">Dokumen Organisasi</span>
                    </h1>
                    <p class="text-xs text-gray-400 leading-relaxed max-w-xl">
                        Pengarsipan terpusat Proposal, LPJ, RAB Keuangan, Surat, dan berkas administratif HMIF UKRI dengan format PDF, Word, dan Excel.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" @click.prevent="$dispatch('open-modal', 'modal-upload-arsip')"
                        class="inline-flex items-center gap-2.5 rounded-xl border border-red-500/30 bg-red-600 px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white shadow-lg shadow-red-600/25 transition-all duration-200 hover:bg-red-700 hover:shadow-red-600/40">
                        <i class="fa-solid fa-cloud-arrow-up text-sm"></i>
                        Upload Dokumen
                    </button>
                </div>
            </div>
        </div>

        {{-- ===== TOP KPI METRICS ===== --}}
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            {{-- Metric 1: Total Dokumen --}}
            <div class="group relative overflow-hidden rounded-2xl border border-white/8 bg-gray-900/40 p-5 backdrop-blur-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-red-500/30 hover:bg-gray-900/60">
                <div class="flex items-start justify-between">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-500">Total Berkas</p>
                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl border border-red-500/20 bg-red-500/10 text-red-400">
                        <i class="fa-solid fa-folder-open text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-1.5">
                    <span class="text-3xl font-black text-white">{{ $metrics['total_documents'] }}</span>
                    <span class="text-[11px] font-medium text-gray-500">dokumen</span>
                </div>
                <div class="mt-3 flex items-center gap-2 border-t border-white/5 pt-3">
                    <span class="text-[10px] text-gray-400">Seluruh kategori arsip</span>
                </div>
            </div>

            {{-- Metric 2: Kapasitas Storage --}}
            <div class="group relative overflow-hidden rounded-2xl border border-white/8 bg-gray-900/40 p-5 backdrop-blur-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-blue-500/30 hover:bg-gray-900/60">
                <div class="flex items-start justify-between">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-500">Storage Terpakai</p>
                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl border border-blue-500/20 bg-blue-500/10 text-blue-400">
                        <i class="fa-solid fa-hard-drive text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-1.5">
                    <span class="text-3xl font-black text-white">{{ $metrics['total_size_formatted'] }}</span>
                </div>
                <div class="mt-3 flex items-center gap-2 border-t border-white/5 pt-3">
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-blue-400">
                        <i class="fa-solid fa-shield-halved text-[9px]"></i> Disk Privat
                    </span>
                </div>
            </div>

            {{-- Metric 3: Total Proposal --}}
            <div class="group relative overflow-hidden rounded-2xl border border-white/8 bg-gray-900/40 p-5 backdrop-blur-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-blue-500/30 hover:bg-gray-900/60">
                <div class="flex items-start justify-between">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-500">Proposal Proker</p>
                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl border border-blue-500/20 bg-blue-500/10 text-blue-400">
                        <i class="fa-solid fa-file-lines text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-1.5">
                    <span class="text-3xl font-black text-white">{{ $metrics['total_proposals'] }}</span>
                    <span class="text-[11px] font-medium text-gray-500">berkas</span>
                </div>
                <div class="mt-3 flex items-center gap-2 border-t border-white/5 pt-3">
                    <span class="text-[10px] text-gray-400">Proposal kegiatan terdaftar</span>
                </div>
            </div>

            {{-- Metric 4: Total LPJ --}}
            <div class="group relative overflow-hidden rounded-2xl border border-white/8 bg-gray-900/40 p-5 backdrop-blur-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-emerald-500/30 hover:bg-gray-900/60">
                <div class="flex items-start justify-between">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-500">LPJ Kegiatan</p>
                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl border border-emerald-500/20 bg-emerald-500/10 text-emerald-400">
                        <i class="fa-solid fa-file-circle-check text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-1.5">
                    <span class="text-3xl font-black text-white">{{ $metrics['total_lpj'] }}</span>
                    <span class="text-[11px] font-medium text-gray-500">berkas</span>
                </div>
                <div class="mt-3 flex items-center gap-2 border-t border-white/5 pt-3">
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-400">
                        <i class="fa-solid fa-circle-check text-[9px]"></i> Laporan Final
                    </span>
                </div>
            </div>
        </div>

        {{-- ===== MULTI-CRITERIA SEARCH & FILTER BAR ===== --}}
        <div class="rounded-2xl border border-white/8 bg-gray-900/40 p-5 backdrop-blur-sm">
            <form action="{{ route('admin.doc-event.index') }}" method="GET" class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-12">
                {{-- Search Keyword (Col 4) --}}
                <div class="relative lg:col-span-4">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-gray-500"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama berkas, proker, uploader..."
                        class="w-full rounded-xl border border-white/10 bg-black/40 py-2.5 pl-9 pr-4 text-xs font-semibold text-white placeholder-gray-500 outline-none transition focus:border-red-500/60">
                </div>

                {{-- Period Selector (Col 2) --}}
                <div class="relative lg:col-span-2">
                    <select name="period_id"
                        class="w-full appearance-none rounded-xl border border-white/10 bg-black/40 py-2.5 pl-3.5 pr-8 text-xs font-semibold text-white outline-none transition focus:border-red-500/60 cursor-pointer">
                        <option value="" class="bg-gray-950 text-gray-400">Semua Periode</option>
                        @foreach ($periods as $p)
                            <option value="{{ $p->id }}" class="bg-gray-950 text-white" {{ request('period_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->cabinet_name }}
                            </option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[9px] text-gray-500"></i>
                </div>

                {{-- Document Type Selector (Col 2) --}}
                <div class="relative lg:col-span-2">
                    <select name="type"
                        class="w-full appearance-none rounded-xl border border-white/10 bg-black/40 py-2.5 pl-3.5 pr-8 text-xs font-semibold text-white outline-none transition focus:border-red-500/60 cursor-pointer">
                        <option value="" class="bg-gray-950 text-gray-400">Semua Tipe</option>
                        <option value="proposal" class="bg-gray-950 text-white" {{ request('type') == 'proposal' ? 'selected' : '' }}>Proposal</option>
                        <option value="lpj" class="bg-gray-950 text-white" {{ request('type') == 'lpj' ? 'selected' : '' }}>LPJ</option>
                        <option value="rab" class="bg-gray-950 text-white" {{ request('type') == 'rab' ? 'selected' : '' }}>RAB / Keuangan</option>
                        <option value="surat" class="bg-gray-950 text-white" {{ request('type') == 'surat' ? 'selected' : '' }}>Surat Resmi</option>
                        <option value="tor" class="bg-gray-950 text-white" {{ request('type') == 'tor' ? 'selected' : '' }}>TOR / Juklak</option>
                        <option value="notulensi" class="bg-gray-950 text-white" {{ request('type') == 'notulensi' ? 'selected' : '' }}>Notulensi</option>
                        <option value="lainnya" class="bg-gray-950 text-white" {{ request('type') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    <i class="fa-solid fa-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[9px] text-gray-500"></i>
                </div>

                {{-- File Format Selector (Col 2) --}}
                <div class="relative lg:col-span-2">
                    <select name="format"
                        class="w-full appearance-none rounded-xl border border-white/10 bg-black/40 py-2.5 pl-3.5 pr-8 text-xs font-semibold text-white outline-none transition focus:border-red-500/60 cursor-pointer">
                        <option value="" class="bg-gray-950 text-gray-400">Semua Format</option>
                        <option value="pdf" class="bg-gray-950 text-white" {{ request('format') == 'pdf' ? 'selected' : '' }}>PDF (.pdf)</option>
                        <option value="word" class="bg-gray-950 text-white" {{ request('format') == 'word' ? 'selected' : '' }}>Word (.doc, .docx)</option>
                        <option value="excel" class="bg-gray-950 text-white" {{ request('format') == 'excel' ? 'selected' : '' }}>Excel / CSV (.xls, .xlsx, .csv)</option>
                    </select>
                    <i class="fa-solid fa-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[9px] text-gray-500"></i>
                </div>

                {{-- Action Buttons (Col 2) --}}
                <div class="flex items-center gap-2 lg:col-span-2">
                    <button type="submit"
                        class="flex-1 rounded-xl bg-white/10 py-2.5 text-center text-[10px] font-black uppercase tracking-wider text-white transition hover:bg-white/20">
                        Filter
                    </button>
                    <a href="{{ route('admin.doc-event.index') }}"
                        class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl border border-white/10 bg-black/40 text-gray-400 transition hover:border-red-500/50 hover:text-white"
                        title="Reset Filter">
                        <i class="fa-solid fa-rotate-right text-xs"></i>
                    </a>
                </div>
            </form>
        </div>

        {{-- ===== DOCUMENT TABLE ===== --}}
        <div class="overflow-hidden rounded-2xl border border-white/8 bg-gray-900/40 backdrop-blur-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/8 bg-white/[0.02]">
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-500">Dokumen &amp; Format</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-500">Kegiatan / Proker</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-500 text-center">Tipe</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-500">Periode</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-500">Ukuran</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-500">Tanggal &amp; Uploader</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-500 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($documents as $doc)
                            <tr class="group transition-colors hover:bg-white/[0.03]">
                                {{-- Dokumen & Format --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3.5">
                                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl border border-white/10 bg-black/30 text-lg">
                                            <i class="{{ $doc->file_icon }}"></i>
                                        </div>
                                        <div class="min-w-0">
                                            @if($doc->is_pdf)
                                                <button type="button"
                                                    @click="openPreview('{{ route('admin.archive.view', $doc->id) }}', '{{ route('admin.archive.download', $doc->id) }}', '{{ addslashes($doc->name) }}', '{{ $doc->type_document_label }}')"
                                                    class="text-left text-xs font-bold text-white transition hover:text-red-400 focus:outline-none">
                                                    {{ $doc->name }}
                                                </button>
                                            @else
                                                <a href="{{ route('admin.archive.download', $doc->id) }}"
                                                    class="text-xs font-bold text-white transition hover:text-blue-400">
                                                    {{ $doc->name }}
                                                </a>
                                            @endif
                                            <p class="mt-0.5 text-[10px] text-gray-500 uppercase tracking-wider">
                                                {{ strtoupper($doc->file_extension ?? 'FILE') }}
                                                @if($doc->access_level === 'public')
                                                    • <span class="text-emerald-400 font-semibold">Publik</span>
                                                @else
                                                    • <span class="text-gray-500">Internal</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Proker / Kegiatan --}}
                                <td class="px-6 py-4">
                                    @if($doc->event)
                                        <a href="{{ route('admin.events.show', $doc->event->slug) }}"
                                            class="text-xs font-medium text-gray-300 hover:text-white transition line-clamp-1">
                                            {{ $doc->event->title }}
                                        </a>
                                    @else
                                        <span class="inline-flex items-center rounded-md border border-white/10 bg-white/5 px-2 py-0.5 text-[9px] font-semibold text-gray-400">
                                            Umum Organisasi
                                        </span>
                                    @endif
                                </td>

                                {{-- Tipe Dokumen --}}
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-[9px] font-black uppercase tracking-wider {{ $doc->type_badge_color }}">
                                        {{ $doc->type_document_label }}
                                    </span>
                                </td>

                                {{-- Periode --}}
                                <td class="px-6 py-4 text-xs font-medium text-gray-400">
                                    {{ $doc->period->cabinet_name ?? '-' }}
                                </td>

                                {{-- Ukuran --}}
                                <td class="px-6 py-4 text-xs font-semibold text-gray-400 whitespace-nowrap">
                                    {{ $doc->formatted_file_size }}
                                </td>

                                {{-- Tanggal & Uploader --}}
                                <td class="px-6 py-4">
                                    <div class="text-[11px] text-gray-300 font-medium whitespace-nowrap">
                                        {{ $doc->created_at->translatedFormat('d M Y') }}
                                    </div>
                                    <div class="text-[10px] text-gray-500 truncate max-w-[120px]">
                                        {{ $doc->user->name ?? 'Admin' }}
                                    </div>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        {{-- Inline Preview (Khusus PDF) --}}
                                        @if($doc->is_pdf)
                                            <button type="button"
                                                @click="openPreview('{{ route('admin.archive.view', $doc->id) }}', '{{ route('admin.archive.download', $doc->id) }}', '{{ addslashes($doc->name) }}', '{{ $doc->type_document_label }}')"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-gray-300 transition hover:border-red-500/40 hover:bg-red-600/10 hover:text-red-400"
                                                title="Lihat Pratinjau PDF">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </button>
                                        @endif

                                        {{-- Download --}}
                                        <a href="{{ route('admin.archive.download', $doc->id) }}"
                                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-gray-300 transition hover:border-blue-500/40 hover:bg-blue-600/10 hover:text-blue-400"
                                            title="Unduh Berkas">
                                            <i class="fa-solid fa-download text-xs"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.doc-event.destroy', $doc->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus arsip ini? Berkas fisik akan dihapus secara permanen.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg border border-red-500/20 bg-red-600/10 text-red-400 transition hover:border-red-500/50 hover:bg-red-600 hover:text-white"
                                                title="Hapus Arsip">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <i class="fa-solid fa-folder-open text-4xl mb-3 text-gray-600"></i>
                                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Belum ada dokumen arsip</p>
                                        <p class="text-[11px] text-gray-600 mt-1 max-w-sm">Unggah proposal, LPJ, RAB, atau surat resmi untuk memulai pengarsipan terpusat.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($documents->hasPages())
                <div class="border-t border-white/5 px-6 py-4">
                    {{ $documents->links() }}
                </div>
            @endif
        </div>

        {{-- ===== PDF PREVIEW MODAL ===== --}}
        <template x-if="previewModal">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" style="display: none;" x-show="previewModal" x-transition.opacity>
                {{-- Backdrop --}}
                <div class="fixed inset-0 bg-black/80 backdrop-blur-md transition-opacity" @click="previewModal = false"></div>

                {{-- Modal Container --}}
                <div class="relative w-full max-w-5xl h-[88vh] rounded-2xl border border-white/10 bg-gray-900 shadow-2xl flex flex-col overflow-hidden z-10"
                    @click.stop>
                    {{-- Modal Header --}}
                    <div class="flex items-center justify-between border-b border-white/10 bg-gray-950 px-6 py-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl border border-red-500/30 bg-red-600/20 text-red-400">
                                <i class="fa-solid fa-file-pdf text-sm"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="truncate text-xs font-bold text-white" x-text="docTitle"></h3>
                                <span class="text-[10px] font-semibold text-gray-400" x-text="docType"></span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <a :href="downloadUrl"
                                class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-bold text-gray-300 transition hover:bg-white/10 hover:text-white">
                                <i class="fa-solid fa-download text-xs"></i>
                                Unduh PDF
                            </a>
                            <button type="button" @click="previewModal = false"
                                class="flex h-8 w-8 items-center justify-center rounded-xl text-gray-400 transition hover:bg-white/10 hover:text-white">
                                <i class="fa-solid fa-xmark text-sm"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Modal Body / PDF Iframe --}}
                    <div class="flex-1 bg-gray-950 relative">
                        <iframe :src="pdfUrl" class="w-full h-full border-none" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- ===== UPLOAD ARSIP MODAL WITH DRAG & DROP DROPZONE ===== --}}
    <x-modal name="modal-upload-arsip" focusable>
        <div x-data="documentUploader()" class="p-6 md:p-8 bg-gray-950 border border-white/10 rounded-2xl space-y-6">
            {{-- Header --}}
            <div class="border-b border-white/8 pb-4">
                <div class="flex items-center gap-2 mb-1">
                    <span class="h-2 w-2 rounded-full bg-red-500"></span>
                    <h2 class="text-lg font-black uppercase tracking-tight text-white">Upload Arsip Dokumen</h2>
                </div>
                <p class="text-xs text-gray-400">
                    Format yang diterima: <span class="text-red-400 font-bold">PDF (.pdf)</span>, <span class="text-blue-400 font-bold">Word (.doc, .docx)</span>, <span class="text-emerald-400 font-bold">Excel/CSV (.xls, .xlsx, .csv)</span> • Maksimal 20MB.
                </p>
            </div>

            <form method="POST" action="{{ route('admin.doc-event.store') }}" enctype="multipart/form-data" class="space-y-4" @submit="validateBeforeSubmit($event)">
                @csrf

                {{-- Kegiatan / Proker Target --}}
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">
                        Pilih Program Kerja / Kegiatan (Opsional)
                    </label>
                    <div class="relative">
                        <select name="event_id" x-model="selectedEventId" @change="autoFillName()"
                            class="w-full appearance-none rounded-xl border border-white/10 bg-black/40 px-3.5 py-2.5 pr-8 text-xs font-semibold text-white outline-none transition focus:border-red-500/60 cursor-pointer">
                            <option value="" class="bg-gray-950 text-gray-400">-- Dokumen Umum Organisasi (Non-Proker) --</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}" data-title="{{ $event->title }}" class="bg-gray-950 text-white">
                                    {{ $event->title }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[9px] text-gray-500"></i>
                    </div>
                </div>

                {{-- Periode & Tipe Dokumen --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">
                            Periode Kepengurusan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="period_id" required
                                class="w-full appearance-none rounded-xl border border-white/10 bg-black/40 px-3.5 py-2.5 pr-8 text-xs font-semibold text-white outline-none transition focus:border-red-500/60 cursor-pointer">
                                @foreach ($periods as $p)
                                    <option value="{{ $p->id }}" class="bg-gray-950 text-white" {{ $p->is_current ? 'selected' : '' }}>
                                        {{ $p->cabinet_name }} ({{ $p->period_range }})
                                    </option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[9px] text-gray-500"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">
                            Tipe Dokumen <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="type_document" x-model="selectedType" @change="autoFillName()" required
                                class="w-full appearance-none rounded-xl border border-white/10 bg-black/40 px-3.5 py-2.5 pr-8 text-xs font-semibold text-white outline-none transition focus:border-red-500/60 cursor-pointer">
                                <option value="proposal" class="bg-gray-950 text-white">PROPOSAL</option>
                                <option value="lpj" class="bg-gray-950 text-white">LPJ (Laporan Pertanggungjawaban)</option>
                                <option value="rab" class="bg-gray-950 text-white">RAB / Laporan Keuangan</option>
                                <option value="surat" class="bg-gray-950 text-white">SURAT RESMI (SK / Undangan)</option>
                                <option value="tor" class="bg-gray-950 text-white">TOR / JUKLAK-JUKNIS</option>
                                <option value="notulensi" class="bg-gray-950 text-white">NOTULENSI RAPAT</option>
                                <option value="lainnya" class="bg-gray-950 text-white">DOKUMEN LAINNYA</option>
                            </select>
                            <i class="fa-solid fa-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[9px] text-gray-500"></i>
                        </div>
                    </div>
                </div>

                {{-- Nama Dokumen --}}
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">
                        Nama / Judul Arsip <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" x-model="docName" required placeholder="Contoh: Arsip_Proposal_Seminar_AI_2026"
                        class="w-full rounded-xl border border-white/10 bg-black/40 px-3.5 py-2.5 text-xs font-semibold text-white placeholder-gray-500 outline-none transition focus:border-red-500/60">
                </div>

                {{-- Deskripsi Ringkas --}}
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">
                        Catatan Tambahan (Opsional)
                    </label>
                    <textarea name="description" rows="2" placeholder="Catatan versi revisi atau keterangan berkas..."
                        class="w-full rounded-xl border border-white/10 bg-black/40 px-3.5 py-2.5 text-xs font-semibold text-white placeholder-gray-500 outline-none transition focus:border-red-500/60"></textarea>
                </div>

                {{-- Drag and Drop File Dropzone --}}
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">
                        Berkas Dokumen (PDF, Word, Excel/CSV) <span class="text-red-500">*</span>
                    </label>

                    <div class="relative rounded-2xl border-2 border-dashed p-6 text-center transition-all duration-200"
                        :class="isDragging ? 'border-red-500 bg-red-600/10' : (fileInfo ? 'border-emerald-500/40 bg-emerald-500/5' : 'border-white/15 bg-black/30 hover:border-white/30')"
                        @dragover.prevent="isDragging = true"
                        @dragleave.prevent="isDragging = false"
                        @drop.prevent="handleDrop($event)">

                        <input type="file" name="file" id="archive-file-input" required
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,text/csv"
                            class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10"
                            @change="handleFileSelect($event)">

                        {{-- State 1: File Selected --}}
                        <template x-if="fileInfo">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl border text-xl"
                                    :class="fileInfo.badgeClass">
                                    <i :class="fileInfo.icon"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-white truncate max-w-sm" x-text="fileInfo.name"></p>
                                    <p class="text-[10px] text-gray-400" x-text="fileInfo.sizeFormatted + ' • ' + fileInfo.ext.toUpperCase()"></p>
                                </div>
                                <span class="text-[10px] font-semibold text-emerald-400">Berkas siap diunggah (Klik untuk mengganti)</span>
                            </div>
                        </template>

                        {{-- State 2: No File Selected --}}
                        <template x-if="!fileInfo">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-gray-400">
                                    <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-white">Tarik &amp; lepas berkas di sini, atau <span class="text-red-400 underline">pilih file</span></p>
                                    <p class="text-[10px] text-gray-500 mt-0.5">Mendukung .pdf, .doc, .docx, .xls, .xlsx, .csv (Maks. 20MB)</p>
                                </div>
                            </div>
                        </template>
                    </div>

                    <template x-if="errorMessage">
                        <p class="mt-2 text-xs font-semibold text-red-400" x-text="errorMessage"></p>
                    </template>
                </div>

                {{-- Action Buttons --}}
                <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-white/8">
                    <button type="button" x-on:click="$dispatch('close')"
                        class="rounded-xl px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-gray-400 transition hover:bg-white/5 hover:text-white">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded-xl bg-red-600 px-6 py-2.5 text-xs font-bold uppercase tracking-wider text-white shadow-lg shadow-red-600/30 transition hover:bg-red-700">
                        Simpan Arsip
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    @push('scripts')
    <script>
        function documentUploader() {
            return {
                isDragging: false,
                fileInfo: null,
                errorMessage: '',
                selectedEventId: '',
                selectedType: 'proposal',
                docName: '',

                autoFillName() {
                    const selectEl = document.querySelector('select[name="event_id"]');
                    const selectedOpt = selectEl ? selectEl.selectedOptions[0] : null;
                    const eventTitle = selectedOpt && selectedOpt.dataset.title ? selectedOpt.dataset.title : 'Organisasi';
                    const typeLabel = this.selectedType ? this.selectedType.toUpperCase() : 'ARSIP';

                    const cleanTitle = eventTitle.replace(/[^a-zA-Z0-9]/g, '_').substring(0, 35);
                    this.docName = `Arsip_${typeLabel}_${cleanTitle}`;
                },

                handleFileSelect(event) {
                    const file = event.target.files[0];
                    this.processFile(file);
                },

                handleDrop(event) {
                    this.isDragging = false;
                    const file = event.dataTransfer.files[0];
                    if (file) {
                        const input = document.getElementById('archive-file-input');
                        if (input) {
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            input.files = dataTransfer.files;
                        }
                        this.processFile(file);
                    }
                },

                processFile(file) {
                    this.errorMessage = '';
                    if (!file) {
                        this.fileInfo = null;
                        return;
                    }

                    const ext = file.name.split('.').pop().toLowerCase();
                    const validExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv'];

                    if (!validExtensions.includes(ext)) {
                        this.errorMessage = 'Format berkas tidak didukung! Harap unggah berkas PDF, Word (.doc, .docx), atau Excel (.xls, .xlsx, .csv).';
                        this.fileInfo = null;
                        return;
                    }

                    const maxSizeBytes = 20 * 1024 * 1024; // 20 MB
                    if (file.size > maxSizeBytes) {
                        this.errorMessage = 'Ukuran berkas melebihi batas maksimal 20 MB.';
                        this.fileInfo = null;
                        return;
                    }

                    let icon = 'fa-solid fa-file-lines';
                    let badgeClass = 'border-white/10 bg-white/5 text-gray-300';

                    if (ext === 'pdf') {
                        icon = 'fa-solid fa-file-pdf';
                        badgeClass = 'border-red-500/30 bg-red-500/10 text-red-400';
                    } else if (['doc', 'docx'].includes(ext)) {
                        icon = 'fa-solid fa-file-word';
                        badgeClass = 'border-blue-500/30 bg-blue-500/10 text-blue-400';
                    } else if (['xls', 'xlsx', 'csv'].includes(ext)) {
                        icon = 'fa-solid fa-file-excel';
                        badgeClass = 'border-emerald-500/30 bg-emerald-500/10 text-emerald-400';
                    }

                    this.fileInfo = {
                        name: file.name,
                        ext: ext,
                        sizeFormatted: this.formatBytes(file.size),
                        icon: icon,
                        badgeClass: badgeClass,
                    };

                    if (!this.docName) {
                        this.docName = file.name.substring(0, file.name.lastIndexOf('.')) || file.name;
                    }
                },

                formatBytes(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                },

                validateBeforeSubmit(event) {
                    if (!this.fileInfo && !this.errorMessage) {
                        this.errorMessage = 'Harap pilih berkas dokumen yang valid sebelum menyimpan.';
                        event.preventDefault();
                    }
                }
            };
        }
    </script>
    @endpush
</x-app-layout>
