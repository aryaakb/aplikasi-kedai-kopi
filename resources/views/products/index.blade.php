<x-app-layout>
    <x-slot name="header">
        <h2 class="font-brand text-3xl leading-tight text-[#F5DEB3]" style="font-family: 'Bebas Neue', sans-serif;">
            ☕ KELOLA PRODUK NOFVCKINGCOFFEE
        </h2>
    </x-slot>

    <div class="py-12" style="background: linear-gradient(135deg, #2F1B14, #4A2C2A);">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#F5DEB3] overflow-hidden shadow-xl sm:rounded-lg border-4 border-[#DAA520]">
                <div class="p-6 lg:p-8">
                    
                    <!-- Header Section -->
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h1 class="text-4xl font-brand text-[#2F1B14]" style="font-family: 'Bebas Neue', sans-serif;">
                                📦 PRODUK KOPI KAMI
                            </h1>
                            <p class="text-[#8B4513] mt-2 font-medium">Kelola semua produk kopi NoFvckingCoffee</p>
                        </div>
                        <a href="{{ route('products.create') }}" 
                           class="bg-[#8B4513] hover:bg-[#A0522D] text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-lg border-2 border-[#654321]">
                            ➕ Tambah Produk Baru
                        </a>
                    </div>

                    <!-- Search & Filter Section -->
                    <div x-data="{ showFilters: false }" class="bg-[#8B4513] rounded-xl p-6 mb-8">
                        <h3 class="text-white font-brand text-xl mb-4">🔍 CARI & FILTER PRODUK</h3>
                        
                        <form method="GET" action="{{ route('products.index') }}" class="space-y-4">
                            <!-- Search Bar -->
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}"
                                           placeholder="Cari nama produk atau deskripsi..." 
                                           class="w-full px-4 py-3 rounded-lg border-2 border-[#DAA520] focus:outline-none focus:ring-2 focus:ring-[#F5DEB3] text-[#2F1B14] font-semibold">
                                </div>
                                <button type="button" 
                                        @click="showFilters = !showFilters"
                                        class="bg-[#DAA520] hover:bg-[#B8860B] text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                                    <span x-text="showFilters ? '🔼 Sembunyikan Filter' : '🔽 Tampilkan Filter'"></span>
                                </button>
                                <button type="submit" 
                                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                                    🔍 Cari
                                </button>
                            </div>

                            <!-- Advanced Filters -->
                            <div x-show="showFilters" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-[#DAA520]">
                                
                                <!-- Category Filter -->
                                <div>
                                    <label class="block text-white font-semibold mb-2">🏷️ Kategori</label>
                                    <select name="category" 
                                            class="w-full px-4 py-3 rounded-lg border-2 border-[#DAA520] focus:outline-none focus:ring-2 focus:ring-[#F5DEB3] text-[#2F1B14] font-semibold">
                                        <option value="">Semua Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Sort By -->
                                <div>
                                    <label class="block text-white font-semibold mb-2">📊 Urutkan</label>
                                    <select name="sort_by" 
                                            class="w-full px-4 py-3 rounded-lg border-2 border-[#DAA520] focus:outline-none focus:ring-2 focus:ring-[#F5DEB3] text-[#2F1B14] font-semibold">
                                        <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>Nama</option>
                                        <option value="price" {{ request('sort_by') === 'price' ? 'selected' : '' }}>Harga</option>
                                        <option value="stock" {{ request('sort_by') === 'stock' ? 'selected' : '' }}>Stok</option>
                                        <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Tanggal Dibuat</option>
                                    </select>
                                </div>

                                <!-- Sort Order -->
                                <div>
                                    <label class="block text-white font-semibold mb-2">⬆️⬇️ Arah</label>
                                    <select name="sort_order" 
                                            class="w-full px-4 py-3 rounded-lg border-2 border-[#DAA520] focus:outline-none focus:ring-2 focus:ring-[#F5DEB3] text-[#2F1B14] font-semibold">
                                        <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>A-Z / Rendah-Tinggi</option>
                                        <option value="desc" {{ request('sort_order') === 'desc' ? 'selected' : '' }}>Z-A / Tinggi-Rendah</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Clear Filters Button -->
                            @if(request()->hasAny(['search', 'category', 'sort_by', 'sort_order']))
                                <div class="flex justify-end">
                                    <a href="{{ route('products.index') }}" 
                                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                                        🔄 Reset Filter
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>


                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse ($products ?? [] as $product)
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-3 border-[#DAA520] hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
                                
                                <!-- Product Image -->
                                <div class="h-48 bg-gradient-to-br from-[#8B4513] to-[#A0522D] flex items-center justify-center">
                                    @if($product->image && file_exists(public_path('storage/' . $product->image)))
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="text-white text-6xl">☕</div>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="p-6">
                                    <h3 class="font-brand text-xl text-[#2F1B14] mb-2" style="font-family: 'Playfair Display', serif;">
                                        {{ $product->name }}
                                    </h3>
                                    
                                    <p class="text-[#8B4513] text-sm mb-4 line-clamp-3">
                                        {{ Str::limit($product->description ?? 'Kopi premium NoFvckingCoffee', 100) }}
                                    </p>

                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-2xl font-bold text-[#8B4513]">
                                            Rp {{ number_format($product->price ?? 0) }}
                                        </span>
                                        <span class="bg-[#DAA520] text-white px-3 py-1 rounded-full text-sm font-medium">
                                            Stock: {{ $product->stock ?? 0 }}
                                        </span>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2">
                                        <a href="{{ route('products.show', $product->id) }}" 
                                           class="flex-1 bg-[#DAA520] hover:bg-[#B8860B] text-white text-center py-2 px-4 rounded-lg transition duration-300 text-sm">
                                            👁️ Lihat
                                        </a>
                                        <a href="{{ route('products.edit', $product->id) }}" 
                                           class="flex-1 bg-[#8B4513] hover:bg-[#A0522D] text-white text-center py-2 px-4 rounded-lg transition duration-300 text-sm">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" 
                                              method="POST" 
                                              class="flex-1"
                                              onsubmit="return confirm('Yakin mau hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition duration-300 text-sm">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full">
                                <div class="text-center py-12">
                                    <div class="text-6xl mb-4">☕</div>
                                    <h3 class="text-2xl font-brand text-[#8B4513] mb-2">Belum Ada Produk</h3>
                                    <p class="text-[#A0522D] mb-6">Yuk, tambah produk kopi pertama Anda!</p>
                                    <a href="{{ route('products.create') }}" 
                                       class="bg-[#8B4513] hover:bg-[#A0522D] text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-lg">
                                        ➕ Tambah Produk Sekarang
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Footer Stats -->
                    @if(isset($products) && $products->count() > 0)
                        <div class="mt-8 bg-[#8B4513] rounded-xl p-6 text-white text-center">
                            <h4 class="font-brand text-xl mb-2">📊 STATISTIK PRODUK</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <div class="text-2xl font-bold">{{ $products->count() }}</div>
                                    <div class="text-sm opacity-80">Total Produk</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold">{{ $products->sum('stock') }}</div>
                                    <div class="text-sm opacity-80">Total Stock</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold">Rp {{ number_format($products->avg('price') ?? 0) }}</div>
                                    <div class="text-sm opacity-80">Harga Rata-rata</div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</x-app-layout>