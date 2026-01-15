@extends('layouts.app')

@section('content')
    <section class="min-h-screen bg-[#0f0f0f] pt-28 pb-12">
        <div class="container mx-auto px-4">
            <div
                class="mb-8 flex flex-col md:flex-row items-center justify-between gap-4 rounded-2xl bg-gradient-to-r from-red-950 to-red-900 p-6 shadow-2xl border border-red-800/50">
                <div>
                    <h1 class="text-3xl font-bold text-white">Database Pengurus</h1>
                    <p class="text-red-200 opacity-80">Kelola data anggota Kabinet Metaforsa & periode lainnya.</p>
                </div>
                <a href="{{ route('member.create') }}"
                    class="group flex items-center gap-2 rounded-xl bg-white px-6 py-3 text-red-900 font-bold transition-all hover:bg-red-100 hover:scale-105 active:scale-95 shadow-lg">
                    <svg class="h-5 w-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor"
                        stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Anggota Baru
                </a>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-sm overflow-hidden shadow-xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/10 text-red-400 uppercase text-xs tracking-widest font-bold">
                                <th class="px-6 py-4">Profil</th>
                                <th class="px-6 py-4">Informasi Dasar</th>
                                <th class="px-6 py-4">Jabatan & Bidang</th>
                                <th class="px-6 py-4">Periode</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 text-gray-300">
                            @forelse ($members as $member)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="relative h-12 w-12 group">
                                            @if ($member->image)
                                                <img src="{{ asset('storage/' . $member->image) }}"
                                                    alt="{{ $member->name }}"
                                                    class="h-full w-full rounded-xl object-cover ring-2 ring-red-900 group-hover:ring-red-500 transition-all" />
                                            @else
                                                <div
                                                    class="flex h-full w-full items-center justify-center rounded-xl bg-red-900/30 text-red-500">
                                                    <i class="fa-solid fa-user"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-white">{{ $member->name }}</div>
                                        <div class="text-sm opacity-60 italic">{{ $member->student_id_number }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="block font-medium text-red-200">{{ $member->position }}</span>
                                        <span class="text-xs px-2 py-0.5 rounded bg-white/10 text-gray-400">
                                            {{ $member->department->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div
                                            class="badge border border-red-500/30 text-red-400 bg-red-500/5 px-3 py-1 rounded-full text-xs inline-block">
                                            {{ $member->organizationPeriod->name ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-3">
                                            <a href="{{ route('member.edit', $member->id) }}"
                                                class="p-2 rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white transition-all">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('member.destroy', $member->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus member ini?');" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                        <i class="fa-solid fa-folder-open text-4xl mb-3 block"></i>
                                        Tidak ada data anggota ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($members->hasPages())
                    <div class="bg-white/5 border-t border-white/10 px-6 py-4">
                        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                            <p class="text-sm text-gray-400">
                                Showing <span class="font-semibold text-white">{{ $members->firstItem() }}</span>
                                to <span class="font-semibold text-white">{{ $members->lastItem() }}</span>
                                of <span class="font-semibold text-white">{{ $members->total() }}</span> results
                            </p>

                            <div class="custom-pagination">
                                {{ $members->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* Styling Tailwind Pagination agar match dengan tema Glassmorphism */
        .custom-pagination nav svg {
            @apply w-5 h-5;
        }

        .custom-pagination nav span[aria-current="page"] span {
            @apply bg-red-600 border-red-600 text-white rounded-lg px-4 py-2;
        }

        .custom-pagination nav a,
        .custom-pagination nav span {
            @apply border-white/10 bg-white/5 text-gray-400 rounded-lg px-4 py-2 hover:bg-red-600/20 hover:text-white transition-all;
        }

        /* Sembunyikan summary default bawaan Laravel links() jika menggunakan custom layout di atas */
        .custom-pagination nav div:first-child {
            display: none;
        }

        .custom-pagination nav div:last-child {
            @apply flex gap-1 items-center;
        }
    </style>
@endpush
