<x-guest-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'QR Code - HMIF UKRI',
            'description' => '',
        ])
    </x-slot>

    <div class="flex flex-col items-center justify-center min-h-screen text-center space-y-8">
        <div class="space-y-2">
            <h2 class="text-3xl font-black text-white uppercase tracking-tighter italic">Scan Untuk <span
                    class="text-red-600">Presensi</span></h2>
            <p class="text-gray-500 font-medium tracking-widest uppercase text-xs">Silahkan scan QR di bawah menggunakan
                smartphone Anda</p>
        </div>

        <div class="relative group">
            <div
                class="absolute -inset-4 bg-red-600/20 rounded-[2.5rem] blur-xl group-hover:bg-red-600/30 transition duration-500 ">
            </div>
            <div class="relative p-4 bg-white rounded-4xl shadow-2xl">
                {!! $qrcode !!}
            </div>
        </div>

        <div class="bg-white/5 border border-white/10 px-6 py-3 rounded-2xl backdrop-blur-md">
            <p class="text-white font-mono text-sm tracking-widest uppercase">
                Event ID: <span class="text-red-500">{{ $event->slug }}</span>
            </p>
        </div>
    </div>
</x-guest-layout>
