<section class="space-y-6">
    <header>
        <h2 class="text-lg font-black uppercase tracking-widest text-red-500">
            {{ __('Hapus Akun') }}
        </h2>
        <p class="mt-1 text-sm text-gray-400">
            {{ __('Setelah akun dihapus, semua sumber daya dan data terkait keanggotaan Anda (termasuk data Member) akan dihapus secara permanen.') }}
        </p>
    </header>

    <x-danger-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Hapus Akun Sekarang') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-gray-900 border border-red-500/20">
            @csrf
            @method('delete')

            <h2 class="text-lg font-black uppercase tracking-widest text-white">
                {{ __('Apakah Anda yakin ingin menghapus akun?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                {{ __('Tindakan ini tidak dapat dibatalkan. Masukkan password Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun ini secara permanen.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                    placeholder="{{ __('Masukkan Password Konfirmasi') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Ya, Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
