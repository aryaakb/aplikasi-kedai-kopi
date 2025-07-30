<x-app-layout>
    <x-slot name="header">
        <h2 class="font-brand text-3xl leading-tight text-[#F5DEB3]" style="font-family: 'Bebas Neue', sans-serif;">
            ☕ KELOLA PRODUK ARPUL
        </h2>
    </x-slot>

    <div class="py-6 md:py-12" style="background: linear-gradient(135deg, #2F1B14, #4A2C2A);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-[#F5DEB3] overflow-hidden shadow-xl rounded-lg md:rounded-xl border-2 md:border-4 border-[#DAA520]">
                <div class="p-4 md:p-6 lg:p-8">
                    
                    <!-- Header Section -->
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 md:mb-8 space-y-4 md:space-y-0">
                        <div class="text-center md:text-left">
                            <h1 class="text-2xl md:text-3xl lg:text-4xl font-brand text-[#2F1B14]" style="font-family: 'Bebas Neue', sans-serif;">
                                📦 PRODUK KOPI KAMI
                            </h1>
                            <p class="text-[#8B4513] mt-1 md:mt-2 font-medium text-sm md:text-base">Kelola semua produk kopi Arpul</p>
                        </div>
                        <a href="{{ route('admin.admin.products.create') }}" 
                           class="bg-[#8B4513] hover:bg-[#A0522D] text-white font-bold py-2 md:py-3 px-4 md:px-6 rounded-lg transition duration-300 shadow-lg border-2 border-[#654321] text-sm md:text-base text-center">
                            <span class="md:hidden">➕ Tambah</span>
                            <span class="hidden md:inline">➕ Tambah Produk Baru</span>
                        </a>
                    </div>

                    <!-- Search & Filter Section -->
                    <div x-data="{ showFilters: false }" class="bg-[#8B4513] rounded-lg md:rounded-xl p-4 md:p-6 mb-6 md:mb-8">
                        <h3 class="text-white font-brand text-lg md:text-xl mb-3 md:mb-4">🔍 CARI & FILTER PRODUK</h3>
                        
                        <form method="GET" action="{{ route('admin.admin.products.index') }}" class="space-y-4">
                            <!-- Search Bar -->
                            <div class="flex flex-col sm:flex-row gap-2 sm:gap-4">
                                <div class="flex-1">
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}"
                                           placeholder="Cari nama produk atau deskripsi..." 
                                           class="w-full px-3 md:px-4 py-2 md:py-3 rounded-lg border-2 border-[#DAA520] focus:outline-none focus:ring-2 focus:ring-[#F5DEB3] text-[#2F1B14] font-semibold text-sm md:text-base">
                                </div>
                                <div class="flex gap-2 sm:gap-4">
                                    <button type="button" 
                                            @click="showFilters = !showFilters"
                                            class="bg-[#DAA520] hover:bg-[#B8860B] text-white px-3 md:px-6 py-2 md:py-3 rounded-lg font-semibold transition-colors text-xs md:text-sm flex-1 sm:flex-none">
                                        <span class="md:hidden" x-text="showFilters ? '🔼' : '🔽'"></span>
                                        <span class="hidden md:inline" x-text="showFilters ? '🔼 Sembunyikan Filter' : '🔽 Tampilkan Filter'"></span>
                                    </button>
                                    <button type="submit" 
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 md:px-6 py-2 md:py-3 rounded-lg font-semibold transition-colors text-xs md:text-sm flex-1 sm:flex-none">
                                        <span class="md:hidden">🔍</span>
                                        <span class="hidden md:inline">🔍 Cari</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Advanced Filters -->
                            <div x-show="showFilters" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4 pt-4 border-t border-[#DAA520]">
                                
                                <!-- Category Filter -->
                                <div>
                                    <label class="block text-white font-semibold mb-2 text-sm md:text-base">🏷️ Kategori</label>
                                    <select name="category" 
                                            class="w-full px-3 md:px-4 py-2 md:py-3 rounded-lg border-2 border-[#DAA520] focus:outline-none focus:ring-2 focus:ring-[#F5DEB3] text-[#2F1B14] font-semibold text-sm md:text-base">
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
                                    <label class="block text-white font-semibold mb-2 text-sm md:text-base">📊 Urutkan</label>
                                    <select name="sort_by" 
                                            class="w-full px-3 md:px-4 py-2 md:py-3 rounded-lg border-2 border-[#DAA520] focus:outline-none focus:ring-2 focus:ring-[#F5DEB3] text-[#2F1B14] font-semibold text-sm md:text-base">
                                        <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>Nama</option>
                                        <option value="price" {{ request('sort_by') === 'price' ? 'selected' : '' }}>Harga</option>
                                        <option value="stock" {{ request('sort_by') === 'stock' ? 'selected' : '' }}>Stok</option>
                                        <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Tanggal Dibuat</option>
                                    </select>
                                </div>

                                <!-- Sort Order -->
                                <div class="sm:col-span-2 lg:col-span-1">
                                    <label class="block text-white font-semibold mb-2 text-sm md:text-base">⬆️⬇️ Arah</label>
                                    <select name="sort_order" 
                                            class="w-full px-3 md:px-4 py-2 md:py-3 rounded-lg border-2 border-[#DAA520] focus:outline-none focus:ring-2 focus:ring-[#F5DEB3] text-[#2F1B14] font-semibold text-sm md:text-base">
                                        <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>A-Z / Rendah-Tinggi</option>
                                        <option value="desc" {{ request('sort_order') === 'desc' ? 'selected' : '' }}>Z-A / Tinggi-Rendah</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Clear Filters Button -->
                            @if(request()->hasAny(['search', 'category', 'sort_by', 'sort_order']))
                                <div class="flex justify-end">
                                    <a href="{{ route('admin.admin.products.index') }}" 
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4 md:gap-6">
                        @forelse ($products ?? [] as $product)
                            <div class="bg-white rounded-lg md:rounded-xl shadow-lg overflow-hidden border-2 md:border-3 border-[#DAA520] hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                                
                                <!-- Product Image -->
                                <div class="h-40 md:h-48 bg-gradient-to-br from-[#8B4513] to-[#A0522D] flex items-center justify-center relative overflow-hidden">
                                    @if($product->image && file_exists(public_path('storage/' . $product->image)))
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
                                    @else
                                        <div class="text-white text-4xl md:text-6xl">☕</div>
                                    @endif
                                    <!-- Stock Status Badge -->
                                    @if($product->stock <= 0)
                                        <div class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded-full text-xs font-bold">
                                            HABIS
                                        </div>
                                    @elseif($product->stock <= 10)
                                        <div class="absolute top-2 right-2 bg-orange-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                            SEDIKIT
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="p-4 md:p-6">
                                    <h3 class="font-brand text-lg md:text-xl text-[#2F1B14] mb-2 line-clamp-2" style="font-family: 'Playfair Display', serif;">
                                        {{ $product->name }}
                                    </h3>
                                    
                                    <p class="text-[#8B4513] text-xs md:text-sm mb-3 md:mb-4 line-clamp-2 md:line-clamp-3">
                                        {{ Str::limit($product->description ?? 'Kopi premium Arpul', 80) }}
                                    </p>

                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-3 md:mb-4 space-y-2 sm:space-y-0">
                                        <span class="text-lg md:text-xl lg:text-2xl font-bold text-[#8B4513]">
                                            Rp {{ number_format($product->price ?? 0) }}
                                        </span>
                                        <span class="bg-[#DAA520] text-white px-2 md:px-3 py-1 rounded-full text-xs md:text-sm font-medium self-start sm:self-center">
                                            Stock: {{ $product->stock ?? 0 }}
                                        </span>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                                        <a href="{{ route('admin.admin.products.show', $product->id) }}" 
                                           class="flex-1 bg-[#DAA520] hover:bg-[#B8860B] text-white text-center py-2 px-2 md:px-4 rounded-lg transition duration-300 text-xs md:text-sm">
                                            <span class="sm:hidden">👁️</span>
                                            <span class="hidden sm:inline">👁️ Lihat</span>
                                        </a>
                                        <a href="{{ route('admin.admin.products.edit', $product->id) }}" 
                                           class="flex-1 bg-[#8B4513] hover:bg-[#A0522D] text-white text-center py-2 px-2 md:px-4 rounded-lg transition duration-300 text-xs md:text-sm">
                                            <span class="sm:hidden">✏️</span>
                                            <span class="hidden sm:inline">✏️ Edit</span>
                                        </a>
                                        <form action="{{ route('admin.admin.products.destroy', $product->id) }}" 
                                              method="POST" 
                                              class="flex-1"
                                              onsubmit="return confirm('Yakin mau hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-2 md:px-4 rounded-lg transition duration-300 text-xs md:text-sm">
                                                <span class="sm:hidden">🗑️</span>
                                                <span class="hidden sm:inline">🗑️ Hapus</span>
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
                                    <a href="{{ route('admin.admin.products.create') }}" 
                                       class="bg-[#8B4513] hover:bg-[#A0522D] text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-lg">
                                        ➕ Tambah Produk Sekarang
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Footer Stats -->
                    @if(isset($products) && $products->count() > 0)
                        <div class="mt-6 md:mt-8 bg-[#8B4513] rounded-lg md:rounded-xl p-4 md:p-6 text-white text-center">
                            <h4 class="font-brand text-lg md:text-xl mb-3 md:mb-4">📊 STATISTIK PRODUK</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4">
                                <div class="bg-[#A0522D] rounded-lg p-3 md:p-4">
                                    <div class="text-xl md:text-2xl lg:text-3xl font-bold">{{ $products->count() }}</div>
                                    <div class="text-xs md:text-sm opacity-80">Total Produk</div>
                                </div>
                                <div class="bg-[#A0522D] rounded-lg p-3 md:p-4">
                                    <div class="text-xl md:text-2xl lg:text-3xl font-bold">{{ $products->sum('stock') }}</div>
                                    <div class="text-xs md:text-sm opacity-80">Total Stock</div>
                                </div>
                                <div class="bg-[#A0522D] rounded-lg p-3 md:p-4">
                                    <div class="text-xl md:text-2xl lg:text-3xl font-bold">Rp {{ number_format($products->avg('price') ?? 0) }}</div>
                                    <div class="text-xs md:text-sm opacity-80">Harga Rata-rata</div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</x-app-layout>