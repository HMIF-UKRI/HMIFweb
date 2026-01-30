<section>
    <header>
        <h2 class="text-lg font-black uppercase tracking-widest text-white">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-400">
            {{ __('Perbarui informasi akun dan detail keanggotaan Himpunan Anda.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <div x-data="{
                photoPreview: null,
                triggerClick() { $refs.photoInput.click() },
                updatePreview() {
                    const reader = new FileReader();
                    reader.onload = (e) => { this.photoPreview = e.target.result; };
                    reader.readAsDataURL($refs.photoInput.files[0]);
                }
            }" class="flex flex-col items-center sm:items-start gap-4">

                <x-input-label for="avatar" :value="__('Foto Profil')" />

                <div class="relative group cursor-pointer" @click="triggerClick()">
                    <div
                        class="w-24 h-24 rounded-2xl overflow-hidden border-2 border-white/10 group-hover:border-red-600/50 transition-all duration-300 shadow-2xl">
                        <template x-if="!photoPreview">
                            <img src="{{ Auth::user()->member?->getFirstMediaUrl('avatars') ?: 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->member?->full_name ?? Auth::user()->email) . '&background=dc2626&color=fff' }}"
                                class="w-full h-full object-cover">
                        </template>

                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="w-full h-full object-cover">
                        </template>
                    </div>

                    <div
                        class="absolute inset-0 bg-black/60 flex flex-col items-center justify-center rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <ion-icon name="camera-outline" class="text-white text-2xl mb-1"></ion-icon>
                        <span class="text-[8px] font-black uppercase tracking-widest text-white">Ganti Foto</span>
                    </div>
                </div>

                <input type="file" x-ref="photoInput" name="avatar" class="hidden" @change="updatePreview()">

                <p class="text-[9px] text-gray-500 italic uppercase tracking-tighter">
                    *Klik pada foto untuk mengganti. Format: JPG, PNG (Max 2MB).
                </p>

                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="full_name" :value="__('Nama Lengkap')" />
                <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" :value="old('full_name', $user->member?->full_name)"
                    required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
            </div>

            <div>
                <x-input-label for="npm" :value="__('NPM')" />
                <x-text-input id="npm" name="npm" type="text" class="mt-1 block w-full" :value="old('npm', $user->member?->npm)"
                    required />
                <x-input-error class="mt-2" :messages="$errors->get('npm')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                    required />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="no_hp" :value="__('No. WhatsApp')" />
                <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full" :value="old('no_hp', $user->no_hp)"
                    placeholder="0812..." />
                <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-white/5 pt-6">
            <div>
                <x-input-label for="instagram_url" :value="__('Instagram URL')" />
                <x-text-input id="instagram_url" name="instagram_url" type="url" class="mt-1 block w-full"
                    :value="old('instagram_url', $user->member?->instagram_url)" />
                <x-input-error class="mt-2" :messages="$errors->get('instagram_url')" />
            </div>

            <div>
                <x-input-label for="linkedin_url" :value="__('LinkedIn URL')" />
                <x-text-input id="linkedin_url" name="linkedin_url" type="url" class="mt-1 block w-full"
                    :value="old('linkedin_url', $user->member?->linkedin_url)" />
                <x-input-error class="mt-2" :messages="$errors->get('linkedin_url')" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-500 font-bold">
                    {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>
