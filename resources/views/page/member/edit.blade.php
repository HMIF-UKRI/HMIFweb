@extends('layouts.app')

@section('content')
    <section class="min-h-screen bg-[#0f0f0f] pt-32 pb-20 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 h-96 w-96 rounded-full bg-red-900/20 blur-[120px]"></div>
        <div class="absolute bottom-0 left-0 -ml-20 h-96 w-96 rounded-full bg-red-950/30 blur-[120px]"></div>

        <div class="container mx-auto px-4 max-w-3xl relative z-10">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-8 backdrop-blur-md shadow-2xl">
                <div class="mb-10 text-center">
                    <h1 class="text-4xl font-extrabold tracking-tight text-white">
                        {{ isset($member) ? 'Update Member' : 'Registrasi Pengurus' }}
                    </h1>
                    <div class="mt-2 h-1.5 w-20 bg-gradient-to-r from-red-600 to-red-900 mx-auto rounded-full"></div>
                </div>

                @if ($errors->any())
                    <div class="mb-6 rounded-2xl bg-red-500/10 border border-red-500/20 p-4 text-red-400 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ isset($member) ? route('member.update', $member->id) : route('member.store') }}"
                    method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @if (isset($member))
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-400 ml-1 uppercase tracking-wider">Nama
                                Lengkap</label>
                            <input type="text" name="name" required value="{{ old('name', $member->name ?? '') }}"
                                class="w-full rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-white transition focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none"
                                placeholder="Masukkan nama lengkap">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-400 ml-1 uppercase tracking-wider">NPM</label>
                            <input type="text" name="student_id_number" required
                                value="{{ old('student_id_number', $member->student_id_number ?? '') }}"
                                class="w-full rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-white transition focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none"
                                placeholder="202xxxxx">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-400 ml-1 uppercase tracking-wider">Foto Profil</label>
                        <div
                            class="group relative flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-white/10 bg-white/5 p-8 transition hover:border-red-500/50">
                            @if (isset($member) && $member->image)
                                <img src="{{ asset('storage/' . $member->image) }}"
                                    class="h-24 w-24 rounded-full object-cover mb-4 ring-4 ring-red-900">
                            @endif
                            <i
                                class="fa-solid fa-cloud-arrow-up text-3xl text-red-500 mb-3 transition-transform group-hover:-translate-y-1"></i>
                            <span class="text-white font-medium">Klik untuk upload foto</span>
                            <span class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB</span>
                            <input type="file" name="image" class="absolute inset-0 cursor-pointer opacity-0"
                                accept="image/*" {{ isset($member) ? '' : 'required' }}>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-400 ml-1 uppercase tracking-wider">Jabatan</label>
                        <input type="text" name="position" required
                            value="{{ old('position', $member->position ?? '') }}"
                            class="w-full rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-white transition focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none"
                            placeholder="Contoh: Ketua Himpunan">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label
                                class="text-sm font-semibold text-gray-400 ml-1 uppercase tracking-wider">Periode/Kabinet</label>
                            <select name="organization_period_id" required
                                class="w-full rounded-xl border border-white/10 bg-[#1a1a1a] px-5 py-3 text-white transition focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none">
                                <option value="" disabled selected>Pilih Kabinet</option>
                                @foreach ($organizationPeriods as $period)
                                    <option value="{{ $period->id }}"
                                        {{ old('organization_period_id', $member->organization_period_id ?? '') == $period->id ? 'selected' : '' }}>
                                        {{ $period->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label
                                class="text-sm font-semibold text-gray-400 ml-1 uppercase tracking-wider">Bidang/Departemen</label>
                            <select name="department_id" required
                                class="w-full rounded-xl border border-white/10 bg-[#1a1a1a] px-5 py-3 text-white transition focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none">
                                <option value="" disabled selected>Pilih Bidang</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ old('department_id', $member->department_id ?? '') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit"
                        class="mt-8 w-full rounded-2xl bg-gradient-to-r from-red-600 to-red-800 py-4 font-bold text-white shadow-xl transition-all hover:from-red-500 hover:to-red-700 hover:scale-[1.02] active:scale-[0.98]">
                        <i class="fa-solid fa-save mr-2"></i>
                        {{ isset($member) ? 'Simpan Perubahan' : 'Finalisasi Pendaftaran' }}
                    </button>

                    <a href="{{ route('member.index') }}"
                        class="block text-center text-sm text-gray-500 hover:text-white transition-colors">
                        Batal dan Kembali
                    </a>
                </form>
            </div>
        </div>
    </section>
@endsection
