<x-app-layout>
    <x-slot name="header">
        <h2 class="font-brand text-3xl leading-tight text-[#F5DEB3]">
            ☕ DETAIL PRODUK NOFVCKINGCOFFEE
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] overflow-hidden shadow-xl sm:rounded-xl border-2 border-[#DAA520]">
                <div class="p-8">
                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300">
                            ← Kembali ke Daftar Produk
                        </a>
                    </div>

                    <div class="bg-[#F5DEB3] rounded-xl p-6 border-2 border-[#DAA520]">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Product Image -->
                            <div class="space-y-4">
                                <div class="relative">
                                    <img src="{{ $product->image_url ?? 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=600' }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-96 object-cover rounded-xl border-2 border-[#DAA520] shadow-lg">
                                    <div class="absolute top-4 right-4 bg-[#8B4513] text-[#F5DEB3] px-3 py-2 rounded-full text-sm font-bold">
                                        {{ $product->category }}
                                    </div>
                                </div>
                            </div>

                            <!-- Product Details -->
                            <div class="space-y-6">
                                <div>
                                    <h1 class="font-brand text-4xl text-[#2F1B14] mb-2">{{ $product->name }}</h1>
                                    <div class="flex items-center mb-4">
                                        <span class="text-yellow-500 text-xl">⭐⭐⭐⭐⭐</span>
                                        <span class="text-sm text-[#5D4037] ml-2">(4.8/5 dari 120 review)</span>
                                    </div>
                                </div>

                                @if($product->description)
                                <div>
                                    <h3 class="font-bold text-lg text-[#2F1B14] mb-2">📝 Deskripsi:</h3>
                                    <p class="text-[#5D4037] text-base leading-relaxed">{{ $product->description }}</p>
                                </div>
                                @endif

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] p-4 rounded-lg text-center">
                                        <p class="text-[#F5DEB3] text-sm opacity-90">💰 Harga</p>
                                        <p class="text-[#F5DEB3] text-3xl font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] p-4 rounded-lg text-center">
                                        <p class="text-[#F5DEB3] text-sm opacity-90">📦 Stok</p>
                                        <p class="text-[#F5DEB3] text-3xl font-bold">{{ $product->stock }}</p>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-4 pt-4">
                                    <a href="{{ route('products.edit', $product->id) }}" 
                                       class="flex-1 bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white font-bold py-3 px-6 rounded-lg text-center shadow-lg transform hover:scale-105 transition-all duration-300">
                                        ✏️ EDIT PRODUK
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin mau hapus produk {{ $product->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300">
                                            🗑️ HAPUS PRODUK
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
