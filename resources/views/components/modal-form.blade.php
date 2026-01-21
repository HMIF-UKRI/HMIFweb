<div x-show="openModal" class="fixed inset-0 z-100 flex items-center justify-center p-4 md:p-10 backdrop-blur-md" x-cloak
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8"
    x-transition:enter-end="opacity-100 translate-y-0">

    <div @click.away="openModal = false"
        class="relative w-full max-w-3xl bg-gray-950 border border-white/10 rounded-[2.5rem] shadow-[0_0_50px_rgba(0,0,0,0.5)] flex flex-col max-h-[85vh] mt-20 overflow-hidden">

        <div class="pointer-events-none absolute inset-0 z-0 opacity-[0.03]"
            style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>

        <div class="relative z-10 px-8 py-6 border-b border-white/5 bg-white/2 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="h-8 w-1.5 bg-red-600 rounded-full shadow-[0_0_10px_rgba(220,38,38,0.5)]"></div>
                <h4 class="text-lg font-black text-white uppercase tracking-tighter"
                    x-text="editMode ? 'Edit' : 'Create'"></h4>
            </div>
            <button @click="openModal = false"
                class="group h-10 w-10 flex items-center justify-center rounded-xl bg-white/5 hover:bg-red-600/20 transition-all">
                <i class="fa-solid fa-xmark text-gray-500 group-hover:text-red-600 transition-colors"></i>
            </button>
        </div>

        <form :action="formAction" method="POST" enctype="multipart/form-data"
            class="relative z-10 flex-1 overflow-y-auto custom-scrollbar p-8">
            @csrf
            <template x-if="editMode">
                @method('PATCH')
            </template>

            <div class="space-y-6">
                {{ $slot }}
            </div>
        </form>

        <div class="relative z-10 px-6 py-4 border-t border-white/5 bg-white/2 flex justify-end items-center gap-4">
            <button type="button" @click="openModal = false"
                class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 hover:text-white transition-all">
                Cancel
            </button>
            <button @click="$el.closest('div').previousElementSibling.submit()"
                class="group relative flex items-center gap-2 px-8 py-4 rounded-2xl bg-red-600 hover:bg-red-700 text-white text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-xl shadow-red-600/20 active:scale-95"
                x-text="editMode ? 'Edit' : 'Create'"></h4>>
                <i class="fa-solid fa-check text-sm group-hover:animate-pulse"></i>
            </button>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(220, 38, 38, 0.5);
    }
</style>
