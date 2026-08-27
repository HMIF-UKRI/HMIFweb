@props([
    'name' => 'certificate_file',
])

<div
    x-data="{
        isDragging: false,
        file: null,
        errorMessage: '',
        acceptedExtensions: ['pdf', 'jpg', 'jpeg', 'png'],
        maxSize: 10 * 1024 * 1024,
        handleInput(event) {
            this.setFile(event.target.files[0] ?? null);
        },
        handleDrop(event) {
            this.isDragging = false;
            const droppedFile = event.dataTransfer.files[0] ?? null;

            if (!this.setFile(droppedFile)) {
                return;
            }

            const transfer = new DataTransfer();
            transfer.items.add(droppedFile);
            this.$refs.fileInput.files = transfer.files;
        },
        setFile(selectedFile) {
            this.errorMessage = '';

            if (!selectedFile) {
                this.file = null;
                return false;
            }

            const extension = selectedFile.name.split('.').pop().toLowerCase();

            if (!this.acceptedExtensions.includes(extension)) {
                this.file = null;
                this.$refs.fileInput.value = '';
                this.errorMessage = 'Format file harus PDF, JPG, JPEG, atau PNG.';
                return false;
            }

            if (selectedFile.size > this.maxSize) {
                this.file = null;
                this.$refs.fileInput.value = '';
                this.errorMessage = 'Ukuran file maksimal 10 MB.';
                return false;
            }

            this.file = selectedFile;
            return true;
        },
        formatSize(size) {
            return size >= 1024 * 1024
                ? `${(size / (1024 * 1024)).toFixed(1)} MB`
                : `${Math.max(1, Math.round(size / 1024))} KB`;
        },
    }"
>
    <label class="mb-1.5 block text-[10px] font-bold uppercase tracking-widest text-gray-500">
        File Sertifikat
    </label>

    <div
        class="relative flex min-h-32 cursor-pointer items-center justify-center rounded-lg border-2 border-dashed px-4 py-5 text-center transition"
        :class="isDragging
            ? 'border-emerald-400 bg-emerald-500/10'
            : file
                ? 'border-emerald-500/50 bg-emerald-500/5'
                : 'border-white/15 bg-black/30 hover:border-white/30 hover:bg-white/[0.03]'"
        x-on:dragenter.prevent="isDragging = true"
        x-on:dragover.prevent="isDragging = true"
        x-on:dragleave.prevent="isDragging = false"
        x-on:drop.prevent="handleDrop($event)"
    >
        <input
            x-ref="fileInput"
            type="file"
            name="{{ $name }}"
            required
            accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/jpeg,image/png"
            class="absolute inset-0 z-10 h-full w-full cursor-pointer opacity-0"
            x-on:change="handleInput($event)"
        >

        <div class="pointer-events-none min-w-0">
            <template x-if="!file">
                <div>
                    <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-400"></i>
                    <p class="mt-2 text-sm font-bold text-white">
                        Tarik dan lepas file di sini
                    </p>
                    <p class="mt-1 text-xs text-gray-500">
                        atau klik untuk memilih dari penyimpanan
                    </p>
                    <p class="mt-2 text-[10px] font-semibold text-gray-600">
                        PDF, JPG, atau PNG &middot; Maksimal 10 MB
                    </p>
                </div>
            </template>

            <template x-if="file">
                <div class="min-w-0">
                    <i class="fa-solid fa-file-circle-check text-2xl text-emerald-400"></i>
                    <p class="mx-auto mt-2 max-w-sm truncate text-sm font-bold text-white" x-text="file.name"></p>
                    <p class="mt-1 text-xs text-emerald-400" x-text="`${formatSize(file.size)} - siap dikirim`"></p>
                    <p class="mt-2 text-[10px] text-gray-500">Klik atau jatuhkan file lain untuk mengganti</p>
                </div>
            </template>
        </div>
    </div>

    <p x-show="errorMessage" x-text="errorMessage" class="mt-2 text-xs font-semibold text-red-400"></p>
    @error($name)
        <p class="mt-2 text-xs font-semibold text-red-400">{{ $message }}</p>
    @enderror
</div>
