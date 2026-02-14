<x-app-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Merchandise - HMIF UKRI',
            'description' => 'Merchandise page untuk kebutuhan penjualan HMIF.',
            'keywords' => 'hmif, ukri, himatif, hima, informatika, kegiatan, agenda, seminar, workshop',
            'image' => asset('images/banner-kegiatan.png'),
            'url' => url()->current(),
        ])
    </x-slot>

    <x-slot name="header_title">Admin / Merchandise</x-slot>

    <div class="space-y-6" x-data="{
        openModal: false,
        editMode: false,
        formAction: '',
        name: '',
        merchandise_category_id: '',
        price: '',
        original_price: '',
        stock: 0,
        description: '',
        material: '',
        size: '',
        color: '',
        is_new: 1,
        foto: null,
    
        setCreate() {
            this.editMode = false;
            this.formAction = '{{ route('admin.merchandises.store') }}';
            this.name = '';
            this.merchandise_category_id = '';
            this.price = '';
            this.original_price = '';
            this.stock = 0;
            this.description = '';
            this.material = '';
            this.size = '';
            this.color = '';
            this.is_new = true;
            this.foto = null;
            this.openModal = true;
        },
        setEdit(item) {
            this.editMode = true;
            this.formAction = `/admin/merchandises/${item.id}`;
            this.name = item.name;
            this.merchandise_category_id = item.merchandise_category_id;
            this.price = item.price;
            this.original_price = item.original_price;
            this.stock = item.stock;
            this.description = item.description;
            this.material = item.material;
            this.size = item.size;
            this.color = item.color;
            this.is_new = item.is_new == 1;;
            this.foto = item.preview_url || null;
            this.openModal = true;
        }
    }">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-white/5 pb-6">
            <div class="space-y-1">
                <h3 class="text-2xl font-black text-white uppercase tracking-tighter">
                    Manage <span class="text-red-600 italic">Merchandise</span>
                </h3>
            </div>
            <button @click="setCreate()"
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all">
                Add New Product
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($merchandises as $item)
                <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden group">
                    <div class="aspect-square relative overflow-hidden bg-gray-900">
                        <img src="{{ $item->preview_url ?: 'https://placehold.co/400x400?text=No+Image' }}"
                            class="w-full h-full object-cover">
                        <div class="absolute top-2 right-2 flex gap-1">
                            <button @click="setEdit(@js($item))"
                                class="p-2 bg-black/50 backdrop-blur-md rounded-lg text-white hover:bg-red-600 transition-colors">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('admin.merchandises.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="p-2 bg-black/50 backdrop-blur-md rounded-lg text-white hover:bg-red-600 transition-colors">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="p-4">
                        <span
                            class="text-[10px] text-red-500 font-bold uppercase">{{ $item->category->name ?? 'Uncategorized' }}</span>
                        <h4 class="text-white font-bold truncate">{{ $item->name }}</h4>
                        <p class="text-sm text-gray-400">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        <p class="text-[10px] text-gray-500 mt-2 font-medium tracking-widest uppercase">Stock:
                            {{ $item->stock }} units</p>
                    </div>
                    <div class="p-4 flex items-center gap-2 mt-2">
                        <form action="{{ route('admin.merchandises.decrement', $item->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="w-6 h-6 flex items-center justify-center bg-white/10 hover:bg-red-600 rounded-md text-white transition-colors">
                                <i class="fa-solid fa-minus text-[10px]"></i>
                            </button>
                        </form>

                        <span class="text-xs font-bold text-white w-8 text-center" x-text="{{ $item->stock }}"></span>

                        <form action="{{ route('admin.merchandises.increment', $item->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="w-6 h-6 flex items-center justify-center bg-white/10 hover:bg-green-600 rounded-md text-white transition-colors">
                                <i class="fa-solid fa-plus text-[10px]"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <x-modal-form>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-gray-500 uppercase ml-1">Product Name</label>
                    <input type="text" name="name" x-model="name" required placeholder="Masukan nama product"
                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600">
                </div>

                <div class="space-y-1">
                    <label class="text-[9px] font-black text-gray-500 uppercase ml-1">Category</label>
                    <select name="merchandise_category_id" x-model="merchandise_category_id" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600 appearance-none">
                        <option value="" class="bg-gray-900">Select Category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" class="bg-gray-900">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-[9px] font-black text-gray-500 uppercase ml-1">Price</label>
                    <input type="number" name="price" x-model="price" required placeholder="Masukan harga product"
                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600">
                </div>

                <div class="space-y-1">
                    <label class="text-[9px] font-black text-gray-500 uppercase ml-1">Original Price</label>
                    <input type="number" name="original_price" x-model="original_price"
                        placeholder="Masukan Harga Coret"
                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600">
                </div>

                <div class="space-y-1">
                    <label class="text-[9px] font-black text-gray-500 uppercase ml-1">Stock</label>
                    <input type="number" name="stock" x-model="stock" placeholder="Masukan stok product saat ini"
                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600">
                </div>

                <div class="space-y-1 flex flex-col justify-center">
                    <label class="text-[9px] font-black text-gray-500 uppercase ml-1">New Product Label</label>
                    <label class="inline-flex items-center cursor-pointer h-10">
                        <input type="checkbox" x-model="is_new" class="sr-only peer">

                        <div
                            class="relative w-11 h-6 bg-white/10 peer-focus:outline-none rounded-full peer 
                    peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full 
                    after:content-[''] after:absolute after:top-0.5 after:start-0.5 
                    after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all 
                    peer-checked:bg-red-600">
                        </div>
                        <span class="ms-3 text-xs font-bold text-gray-400 uppercase tracking-widest"
                            x-text="is_new ? 'New' : 'Regular'"></span>
                    </label>
                </div>

                <input type="hidden" name="is_new" :value="is_new ? 1 : 0">
            </div>

            <div class="space-y-1">
                <label class="text-[9px] font-black text-gray-500 uppercase ml-1">Description</label>
                <textarea name="description" x-model="description" rows="3" required placeholder="Masukan deskripsi product"
                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white outline-none focus:border-red-600"></textarea>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-gray-500 uppercase ml-1">Material</label>
                    <input type="text" name="material" x-model="material" placeholder="Cotton 30s"
                        class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-xs text-white outline-none focus:border-red-600">
                </div>
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-gray-500 uppercase ml-1">Size</label>
                    <input type="text" name="size" x-model="size" placeholder="S, M, L, XL"
                        class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-xs text-white outline-none focus:border-red-600">
                </div>
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-gray-500 uppercase ml-1">Color</label>
                    <input type="text" name="color" x-model="color" placeholder="Black"
                        class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-xs text-white outline-none focus:border-red-600">
                </div>
            </div>

            <input type="hidden" name="is_new" :value="is_new ? 1 : 0">

            <div class="space-y-1">
                <label class="text-[9px] font-black text-gray-500 uppercase ml-1">Product Image</label>
                <div
                    class="relative h-64 aspect-square border-2 border-dashed border-white/10 rounded-3xl bg-white/1 flex items-center justify-center overflow-hidden group hover:border-red-600/30 transition-all">
                    <input type="file" name="foto" class="absolute inset-0 opacity-0 z-20 cursor-pointer"
                        @change="foto = URL.createObjectURL($event.target.files[0])" accept="image/*">
                    <template x-if="foto">
                        <img :src="foto" class="absolute inset-0 w-full h-full object-cover z-10">
                    </template>
                    <div x-show="!foto" class="text-center opacity-30 group-hover:opacity-60 transition-opacity">
                        <ion-icon name="camera-outline" class="text-2xl mb-1"></ion-icon>
                        <p class="text-[8px] font-black uppercase tracking-widest">Klik / Drop Foto</p>
                    </div>
                </div>
            </div>
        </x-modal-form>
    </div>
</x-app-layout>
