<x-guest-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Merchandise HMIF - HMIF UKRI',
            'description' =>
                'Koleksi eksklusif merchandise HMIF yang dirancang khusus untuk anggota keluarga besar Teknik Informatika UKRI.',
            'keywords' => 'hmif, ukri, himatif, hima, informatika, merchandise, ganci, logo',
            'image' => asset('images/banner-kegiatan.png'),
            'url' => url()->current(),
        ])
    </x-slot>

    <div class="min-h-screen bg-black">
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute inset-0 bg-linear-to-br from-red-950/20 via-black to-black"></div>
            <div class="absolute top-1/4 -left-48 w-96 h-96 bg-red-600/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-1/4 -right-48 w-96 h-96 bg-red-800/10 rounded-full blur-3xl animate-pulse"
                style="animation-delay: 2s;"></div>
        </div>

        <div class="relative pt-32 pb-20">
            <div class="container mx-auto px-4 md:px-6">
                <div class="max-w-4xl mx-auto text-center">
                    <div
                        class="inline-flex items-center gap-3 px-6 py-3 bg-linear-to-r from-red-950/50 to-red-900/50 border border-red-500/20 rounded-full mb-8 backdrop-blur-sm">
                        <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-medium text-red-400 tracking-[0.2em] uppercase">Limited
                            Collection</span>
                        <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                    </div>

                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold mb-6 leading-tight">
                        <span class="block text-white/90 mb-2">Exclusive</span>
                        <span
                            class="block bg-linear-to-r from-red-500 via-red-400 to-red-600 bg-clip-text text-transparent">
                            Collection
                        </span>
                    </h1>

                    <p class="text-xl md:text-2xl text-gray-400 leading-relaxed max-w-3xl mx-auto font-light">
                        Koleksi merchandise eksklusif yang dirancang dengan detail sempurna
                        <span class="block mt-2 text-red-400">untuk keluarga besar HMIF UKRI</span>
                    </p>

                    <div class="flex items-center justify-center gap-4 mt-12 mb-8">
                        <div class="h-px w-24 bg-linear-to-r from-transparent to-red-500/50"></div>
                        <div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-red-500/50 rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-red-500/30 rounded-full"></div>
                        <div class="h-px w-24 bg-linear-to-l from-transparent to-red-500/50"></div>
                    </div>

                    <div class="flex items-center justify-center gap-3 sm:gap-12 text-center">
                        <div>
                            <p class="text-2xl md:text-4xl font-bold text-white mb-1" x-data="{ count: 0 }"
                                x-init="setInterval(() => { if (count < 8) count++ }, 100)">
                                <span x-text="count"></span>+
                            </p>
                            <p class="text-sm text-gray-500 uppercase tracking-wider">Produk Eksklusif</p>
                        </div>
                        <div class="h-12 w-px bg-white/10"></div>
                        <div>
                            <p class="text-2xl md:text-4xl font-bold text-white mb-1" x-data="{ count: 0 }"
                                x-init="setInterval(() => { if (count < 100) count++ }, 100)"><span x-text="count"></span>%</p>
                            <p class="text-sm text-gray-500 uppercase tracking-wider">Premium Quality</p>
                        </div>
                        <div class="h-12 w-px bg-white/10"></div>
                        <div>
                            <p class="text-2xl md:text-4xl font-bold text-white mb-1">Limited</p>
                            <p class="text-sm text-gray-500 uppercase tracking-wider">Edition</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative py-20" x-data="exclusiveStore()">
            <div class="container mx-auto px-4 md:px-6">
                <div class="max-w-6xl mx-auto mb-16">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex items-center gap-3 overflow-x-auto pb-2 w-full md:w-auto">
                            <button @click="selectedCategory = 'all'"
                                :class="selectedCategory === 'all' ? 'bg-red-600 text-white border-red-600' :
                                    'bg-transparent text-gray-400 border-white/10 hover:border-red-600/50'"
                                class="px-6 py-3 rounded-full border transition-all duration-300 whitespace-nowrap font-medium">
                                All Items
                            </button>
                            <button @click="selectedCategory = 'apparel'"
                                :class="selectedCategory === 'apparel' ? 'bg-red-600 text-white border-red-600' :
                                    'bg-transparent text-gray-400 border-white/10 hover:border-red-600/50'"
                                class="px-6 py-3 rounded-full border transition-all duration-300 whitespace-nowrap font-medium">
                                Apparel
                            </button>
                            <button @click="selectedCategory = 'accessories'"
                                :class="selectedCategory === 'accessories' ? 'bg-red-600 text-white border-red-600' :
                                    'bg-transparent text-gray-400 border-white/10 hover:border-red-600/50'"
                                class="px-6 py-3 rounded-full border transition-all duration-300 whitespace-nowrap font-medium">
                                Accessories
                            </button>
                            <button @click="selectedCategory = 'stationery'"
                                :class="selectedCategory === 'stationery' ? 'bg-red-600 text-white border-red-600' :
                                    'bg-transparent text-gray-400 border-white/10 hover:border-red-600/50'"
                                class="px-6 py-3 rounded-full border transition-all duration-300 whitespace-nowrap font-medium">
                                Stationery
                            </button>
                        </div>

                        <div class="relative w-full md:w-auto" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="w-full md:w-auto px-6 py-3 bg-white/5 border border-white/10 rounded-full text-gray-400 hover:border-red-600/50 transition flex items-center justify-between gap-8 backdrop-blur-sm">
                                <span class="font-medium">Sort By</span>
                                <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="absolute right-0 mt-2 w-48 bg-gray-900/95 border border-white/10 rounded-2xl overflow-hidden backdrop-blur-xl z-50"
                                style="display: none;">
                                <button @click="sortBy = 'featured'; open = false"
                                    class="w-full px-4 py-3 text-left text-gray-300 hover:bg-red-600/20 hover:text-white transition">Featured</button>
                                <button @click="sortBy = 'price-low'; open = false"
                                    class="w-full px-4 py-3 text-left text-gray-300 hover:bg-red-600/20 hover:text-white transition">Price:
                                    Low to High</button>
                                <button @click="sortBy = 'price-high'; open = false"
                                    class="w-full px-4 py-3 text-left text-gray-300 hover:bg-red-600/20 hover:text-white transition">Price:
                                    High to Low</button>
                                <button @click="sortBy = 'newest'; open = false"
                                    class="w-full px-4 py-3 text-left text-gray-300 hover:bg-red-600/20 hover:text-white transition">Newest</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
                        <template x-for="product in filteredProducts" :key="product.id">
                            <div class="group relative" @click="openProductDetail(product)">
                                <div
                                    class="relative bg-linear-to-br from-gray-900/50 to-black/50 border border-white/10 rounded-3xl overflow-hidden backdrop-blur-sm hover:border-red-500/50 transition-all duration-500 cursor-pointer">
                                    <div class="relative aspect-square overflow-hidden">
                                        <img :src="product.image" :alt="product.name"
                                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">

                                        <div
                                            class="absolute inset-0 bg-linear-to-t from-black via-black/20 to-transparent opacity-60">
                                        </div>

                                        <div class="absolute top-6 left-6 flex flex-col gap-2 z-10">
                                            <span x-show="product.isNew"
                                                class="px-4 py-2 bg-red-600 text-white text-xs font-bold tracking-wider uppercase rounded-full">
                                                New Arrival
                                            </span>
                                        </div>

                                        <div
                                            class="absolute inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                            <div
                                                class="text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                                <button
                                                    class="px-8 py-4 bg-white text-black rounded-full font-bold hover:bg-red-600 hover:text-white transition-all duration-300 mb-3">
                                                    View Details
                                                </button>
                                                <p class="text-white/80 text-sm">Click to explore</p>
                                            </div>
                                        </div>

                                        <div class="absolute bottom-0 left-0 right-0 p-6">
                                            <div
                                                class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl p-4">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span
                                                        class="text-white/60 text-xs uppercase tracking-wider">Availability</span>
                                                    <span class="text-white font-semibold text-sm"
                                                        x-text="product.stock + ' units'"></span>
                                                </div>
                                                <div class="w-full bg-white/10 rounded-full h-1.5 overflow-hidden">
                                                    <div class="bg-linear-to-r from-red-600 to-red-400 h-full rounded-full transition-all duration-500"
                                                        :style="`width: ${Math.min((product.stock / 100) * 100, 100)}%`">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-6 lg:p-8">
                                        <div class="flex items-center gap-2 mb-3">
                                            <div class="w-1 h-1 bg-red-500 rounded-full"></div>
                                            <span class="text-xs font-semibold text-red-500 uppercase tracking-[0.2em]"
                                                x-text="product.category"></span>
                                        </div>

                                        <h3 class="text-2xl font-bold text-white mb-3 leading-tight group-hover:text-red-400 transition-colors"
                                            x-text="product.name"></h3>

                                        <div class="flex items-center justify-between pt-4 border-t border-white/10">
                                            <div>
                                                <p class="text-2xl font-bold text-white"
                                                    x-text="formatPrice(product.price)"></p>
                                                <p x-show="product.originalPrice"
                                                    class="text-sm text-gray-500 line-through"
                                                    x-text="formatPrice(product.originalPrice)"></p>
                                            </div>
                                            <div
                                                class="w-12 h-12 bg-red-600/20 border border-red-600/30 rounded-full flex items-center justify-center group-hover:bg-red-600 transition-all duration-300">
                                                <i
                                                    class="fa-solid fa-arrow-right text-red-500 group-hover:text-white transition-colors"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div x-show="filteredProducts.length === 0" class="text-center py-32">
                        <div
                            class="inline-flex items-center justify-center w-24 h-24 bg-white/5 border border-white/10 rounded-full mb-8">
                            <i class="fa-solid fa-inbox text-4xl text-gray-600"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-white mb-3">No Products Found</h3>
                        <p class="text-gray-400 text-lg mb-8">Try adjusting your filters</p>
                        <button @click="selectedCategory = 'all'"
                            class="px-8 py-4 bg-red-600 hover:bg-red-700 text-white rounded-full font-semibold transition-all duration-300">
                            View All Products
                        </button>
                    </div>
                </div>
            </div>

            <x-modal name="product-detail" maxWidth="5xl">
                <div x-show="selectedProduct" class="relative">
                    <button @click="$dispatch('close-modal', 'product-detail')"
                        class="absolute top-6 right-6 z-20 w-14 h-14 bg-black/40 backdrop-blur-md border border-white/20 rounded-full flex items-center justify-center hover:bg-red-600 hover:border-red-600 transition-all duration-300 group">
                        <i class="fa-solid fa-times text-white/60 group-hover:text-white transition-colors"></i>
                    </button>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8 lg:p-12">
                        <div>
                            <div class="relative max-w-2xl aspect-square rounded-3xl overflow-hidden bg-gray-900 mb-6">
                                <img :src="selectedProduct?.image" :alt="selectedProduct?.name"
                                    class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-linear-to-t from-black/60 to-transparent"></div>

                                <div class="absolute top-6 left-6 flex flex-col gap-2">
                                    <span x-show="selectedProduct?.isNew"
                                        class="px-4 py-2 bg-red-600 text-white text-xs font-bold tracking-wider uppercase rounded-full">
                                        New Arrival
                                    </span>
                                    <span x-show="selectedProduct?.stock < 10"
                                        class="px-4 py-2 bg-yellow-600 text-white text-xs font-bold tracking-wider uppercase rounded-full">
                                        Limited Stock
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div>
                                    <span class="text-sm font-semibold text-red-500 uppercase tracking-[0.2em]"
                                        x-text="selectedProduct?.category"></span>
                                </div>

                                <h2 class="text-xl lg:text-3xl font-bold text-white mb-6 leading-tight"
                                    x-text="selectedProduct?.name"></h2>

                                <div class="flex flex-col items-baseline gap-2 mb-8">
                                    <p class="text-2xl font-bold text-white"
                                        x-text="formatPrice(selectedProduct?.price)"></p>
                                    <p x-show="selectedProduct?.originalPrice"
                                        class="text-sm text-gray-500 line-through"
                                        x-text="formatPrice(selectedProduct?.originalPrice)"></p>
                                </div>

                                <div class="mb-8">
                                    <h4 class="text-white font-semibold text-lg mb-3">Description</h4>
                                    <p class="text-gray-400 leading-relaxed text-justify"
                                        x-text="selectedProduct?.description">
                                    </p>
                                </div>

                                <section class="bg-white/5 border border-white/10 rounded-2xl p-6 mb-8"
                                    aria-labelledby="specs-title">
                                    <h4 id="specs-title" class="text-white font-semibold text-lg mb-4">Specifications
                                    </h4>

                                    <dl class="space-y-3 text-xs">
                                        <div class="flex justify-between items-center pb-3 border-b border-white/10">
                                            <dt class="text-gray-400">Material</dt>
                                            <dd class="text-white font-medium"
                                                x-text="selectedProduct?.material || 'Premium Quality'"></dd>
                                        </div>

                                        <div class="flex justify-between items-center pb-3 border-b border-white/10">
                                            <dt class="text-gray-400">Size</dt>
                                            <dd class="text-white font-medium"
                                                x-text="selectedProduct?.size || 'All Size'"></dd>
                                        </div>

                                        <div class="flex justify-between items-center pb-3 border-b border-white/10">
                                            <dt class="text-gray-400">Color</dt>
                                            <dd class="text-white font-medium"
                                                x-text="selectedProduct?.color || 'Various'"></dd>
                                        </div>

                                        <div class="flex justify-between items-center">
                                            <dt class="text-gray-400">Stock Available</dt>
                                            <dd class="font-semibold"
                                                :class="selectedProduct?.stock > 10 ? 'text-green-400' : 'text-yellow-400'"
                                                x-text="selectedProduct?.stock + ' units'"></dd>
                                        </div>
                                    </dl>
                                </section>
                            </div>

                            <div>
                                <button @click="orderWhatsApp(selectedProduct)"
                                    :disabled="selectedProduct?.stock === 0"
                                    :class="selectedProduct?.stock === 0 ? 'bg-gray-800 cursor-not-allowed' :
                                        'bg-linear-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 hover:shadow-2xl hover:shadow-red-500/50'"
                                    class="w-full py-5 rounded-2xl text-white font-bold text-sm transition-all duration-300 flex items-center justify-center gap-3 mb-4">
                                    <i class="fa-brands fa-whatsapp text-2xl"></i>
                                    <span
                                        x-text="selectedProduct?.stock === 0 ? 'Out of Stock' : 'Order via WhatsApp'"></span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                                <p class="text-center text-sm text-gray-500">
                                    <i class="fa-solid fa-shield-alt mr-2"></i>
                                    Pembelian terpercaya hanya di Official Whatsapp HMIF
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </x-modal>
        </div>

        <div class="relative py-32">
            <div class="container mx-auto px-4 md:px-6">
                <div class="max-w-6xl mx-auto">
                    <div class="text-center mb-20">
                        <div
                            class="inline-flex items-center gap-3 px-6 py-3 bg-white/5 border border-white/10 rounded-full mb-6">
                            <div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div>
                            <span class="text-sm font-medium text-red-400 tracking-[0.2em] uppercase">Why Choose
                                Us</span>
                            <div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div>
                        </div>
                        <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">Merchandise HMIF</h2>
                        <p class="text-xl text-gray-400">Temukan merchandise limited edition dan berkualitas</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="group relative">
                            <div
                                class="absolute inset-0 bg-linear-to-br from-red-600/20 to-transparent rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div
                                class="relative bg-linear-to-br from-white/5 to-transparent border border-white/10 rounded-3xl p-8 hover:border-red-500/50 transition-all duration-500 backdrop-blur-sm aspect-square">
                                <div
                                    class="w-16 h-16 bg-linear-to-br from-red-600 to-red-700 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                                    <i class="fa-solid fa-gem text-2xl text-white"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-white mb-3">Kualitas Premium</h3>
                                <p class="text-gray-400 leading-relaxed">Setiap barang dibuat dengan cermat dan teliti,
                                    memperhatikan detail dengan hanya menggunakan bahan-bahan terbaik.</p>
                            </div>
                        </div>

                        <div class="group relative">
                            <div
                                class="absolute inset-0 bg-linear-to-br from-red-600/20 to-transparent rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div
                                class="relative bg-linear-to-br from-white/5 to-transparent border border-white/10 rounded-3xl p-8 hover:border-red-500/50 transition-all duration-500 backdrop-blur-sm aspect-square">
                                <div
                                    class="w-16 h-16 bg-linear-to-br from-red-600 to-red-700 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                                    <i class="fa-solid fa-crown text-2xl text-white"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-white mb-3">Design Exclusive</h3>
                                <p class="text-gray-400 leading-relaxed">Limited Edition Design yang dibuat khusus
                                    untuk anggota keluarga HMIF</p>
                            </div>
                        </div>

                        <div class="group relative">
                            <div
                                class="absolute inset-0 bg-linear-to-br from-red-600/20 to-transparent rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div
                                class="relative bg-linear-to-br from-white/5 to-transparent border border-white/10 rounded-3xl p-8 hover:border-red-500/50 transition-all duration-500 backdrop-blur-sm aspect-square">
                                <div
                                    class="w-16 h-16 bg-linear-to-br from-red-600 to-red-700 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                                    <i class="fa-brands fa-whatsapp text-2xl text-white"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-white mb-3">Easy Ordering</h3>
                                <p class="text-gray-400 leading-relaxed">Proses pemesanan yang mudah dan cepat langsung
                                    dengan Badan Pengurus melalui WhatsApp.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative py-32">
            <div class="absolute inset-0 bg-linear-to-b from-red-950/20 to-black"></div>
            <div class="container mx-auto px-4 md:px-6 relative">
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
                        Ready to Join The
                        <span
                            class="block bg-linear-to-r from-red-500 to-red-600 bg-clip-text text-transparent">Exclusive
                            Club?</span>
                    </h2>
                    <p class="text-xl text-gray-400 mb-12 leading-relaxed">
                        Dapatkan merchandise edisi terbatas Anda sebelum kehabisan.
                    </p>
                    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                        class="inline-flex items-center gap-3 px-10 py-5 bg-linear-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-full font-bold text-lg transition-all duration-300 hover:shadow-2xl hover:shadow-red-500/50 group">
                        <span>Browse Collection</span>
                        <i class="fa-solid fa-arrow-up transform group-hover:-translate-y-1 transition-transform"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            function exclusiveStore() {
                return {
                    selectedCategory: 'all',
                    sortBy: 'featured',
                    selectedProduct: null,
                    products: @json($products),

                    get filteredProducts() {
                        let filtered = this.products;

                        if (this.selectedCategory !== 'all') {
                            filtered = filtered.filter(p => p.category === this.selectedCategory);
                        }

                        if (this.sortBy === 'price-low') {
                            filtered = [...filtered].sort((a, b) => a.price - b.price);
                        } else if (this.sortBy === 'price-high') {
                            filtered = [...filtered].sort((a, b) => b.price - a.price);
                        } else if (this.sortBy === 'newest') {
                            filtered = [...filtered].sort((a, b) => b.isNew - a.isNew);
                        }

                        return filtered;
                    },

                    formatPrice(price) {
                        if (!price) return '';
                        return 'Rp ' + price.toLocaleString('id-ID');
                    },

                    openProductDetail(product) {
                        this.selectedProduct = product;
                        this.$dispatch('open-modal', 'product-detail');
                    },

                    orderWhatsApp(product) {
                        if (product.stock === 0) return;

                        const message = `Hi, I'm interested in this exclusive item:\n\n` +
                            `🏷️ Product: ${product.name}\n` +
                            `💎 Price: ${this.formatPrice(product.price)}\n` +
                            `📦 Category: ${product.category}\n\n` +
                            `Is this still available?`;

                        const whatsappNumber = '6281234567890'; // Replace with actual admin number
                        const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;

                        window.open(whatsappUrl, '_blank');
                    }
                }
            }
        </script>
    @endpush
</x-guest-layout>
