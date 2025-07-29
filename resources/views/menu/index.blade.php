<x-app-layout>
    <x-slot name="header">
        <h2 class="font-brand text-3xl leading-tight">
            MENU NOFVCKINGCOFFEE
        </h2>
    </x-slot>

    {{-- Alpine.js component untuk menangani modal konfirmasi pesanan --}}
    <div x-data="{ showOrderModal: false }">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {{-- Menampilkan notifikasi sukses atau error --}}
                @if(session('success'))
                    <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-4 rounded-xl mb-6 shadow-xl border-l-4 border-green-300">
                        <div class="flex items-center">
                            <span class="text-2xl mr-2">✅</span>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-4 rounded-xl mb-6 shadow-xl border-l-4 border-red-300">
                        <div class="flex items-center">
                            <span class="text-2xl mr-2">❌</span>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif
                
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Daftar Produk -->
                    <div class="w-full md:w-3/4">
                        <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] overflow-hidden shadow-xl sm:rounded-xl border-2 border-[#DAA520]">
                            <div class="p-6">
                                <h3 class="font-brand text-2xl text-[#F5DEB3] mb-6 text-center">🔥 KOPI TANPA DRAMA 🔥</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($products as $product)
                                        @php
                                            $inCartQty = $cart[$product->id]['quantity'] ?? 0;
                                            $availableStock = $product->stock - $inCartQty;
                                        @endphp
                                        <div class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] border-2 border-[#DAA520] rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 flex flex-col">
                                            <div class="relative">
                                                <img src="{{ $product->image_url ?? 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=400' }}" 
                                                     alt="{{ $product->name }}" 
                                                     class="w-full h-48 object-cover">
                                                <div class="absolute top-2 right-2 bg-[#8B4513] text-[#F5DEB3] px-2 py-1 rounded-full text-xs font-bold">
                                                    ☕ Premium
                                                </div>
                                            </div>
                                            <div class="p-4 flex-grow flex flex-col">
                                                <h4 class="font-bold text-xl text-[#2F1B14] mb-2">{{ $product->name }}</h4>
                                                @if($product->description)
                                                    <p class="text-[#5D4037] text-sm mb-3 opacity-90">{{ $product->description }}</p>
                                                @endif
                                                <div class="flex justify-between items-center mb-3">
                                                    <span class="text-2xl font-bold text-[#8B4513]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                    <span class="text-sm px-2 py-1 rounded-full {{ $availableStock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $availableStock > 0 ? "Stok: $availableStock" : 'Habis' }}
                                                    </span>
                                                </div>
                                                
                                                {{-- Rating dan kategori --}}
                                                <div class="flex justify-between items-center mb-3">
                                                    <div class="flex items-center">
                                                        <span class="text-yellow-500">⭐⭐⭐⭐⭐</span>
                                                        <span class="text-xs text-[#5D4037] ml-1">(4.8)</span>
                                                    </div>
                                                    <span class="text-xs bg-[#DAA520] text-[#2F1B14] px-2 py-1 rounded-full font-semibold">
                                                        {{ $product->category ?? 'Kopi' }}
                                                    </span>
                                                </div>

                                                <form action="{{ route('menu.addToCart') }}" method="POST" class="mt-auto">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <button type="submit" 
                                                            class="w-full font-bold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105
                                                                   {{ $availableStock > 0 ? 'bg-gradient-to-r from-[#8B4513] to-[#A0522D] hover:from-[#A0522D] hover:to-[#8B4513] text-[#F5DEB3] shadow-lg' : 'bg-gray-400 text-gray-600 cursor-not-allowed' }}"
                                                            {{ $availableStock <= 0 ? 'disabled' : '' }}>
                                                        {{ $availableStock > 0 ? '🛒 TAMBAH KE KERANJANG' : '❌ STOK HABIS' }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Keranjang -->
                    <div class="w-full md:w-1/4">
                        <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] overflow-hidden shadow-xl sm:rounded-xl border-2 border-[#DAA520] sticky top-20">
                            <div class="p-6">
                                <h3 class="font-brand text-xl text-[#F5DEB3] mb-4 border-b-2 border-[#DAA520] pb-2 text-center">🛒 KERANJANG ANDA</h3>
                                
                                <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                                    @forelse($cart as $id => $item)
                                    <div class="bg-[#F5DEB3] rounded-lg p-3 border border-[#DAA520] shadow-md">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h4 class="font-bold text-[#2F1B14] text-sm">{{ $item['name'] }}</h4>
                                                <div class="flex justify-between items-center mt-1">
                                                    <span class="text-xs text-[#5D4037] bg-[#DAA520] px-2 py-1 rounded-full">
                                                        {{ $item['quantity'] }}x
                                                    </span>
                                                    <span class="font-bold text-[#8B4513]">
                                                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <form action="{{ route('menu.removeFromCart') }}" method="POST" class="ml-2">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $id }}">
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold transition-colors">
                                                    ×
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-8">
                                        <div class="text-4xl mb-2">🛒</div>
                                        <p class="text-[#F5DEB3] opacity-80">Keranjang masih kosong</p>
                                        <p class="text-[#DAA520] text-sm mt-1">Pilih kopi favorit Anda!</p>
                                    </div>
                                    @endforelse
                                </div>
                                
                                @if(count($cart) > 0)
                                <div class="mt-4 pt-4 border-t-2 border-[#DAA520]">
                                    <div class="bg-[#F5DEB3] rounded-lg p-3 mb-4">
                                        <div class="flex justify-between items-center">
                                            <span class="font-bold text-[#2F1B14]">TOTAL BAYAR:</span>
                                            <span class="font-brand text-xl text-[#8B4513]">
                                                Rp {{ number_format(array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0), 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                    <button @click="showOrderModal = true" class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-4 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300">
                                        🚀 PESAN SEKARANG
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk konfirmasi pesanan -->
        <div x-show="showOrderModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70" style="display: none;">
            <div @click.away="showOrderModal = false" class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] rounded-xl shadow-2xl p-8 w-full max-w-lg mx-4 border-4 border-[#DAA520]">
                <div class="text-center mb-6">
                    <div class="text-4xl mb-2">🔥</div>
                    <h3 class="font-brand text-2xl text-[#2F1B14] mb-2">KONFIRMASI PESANAN</h3>
                    <p class="text-[#5D4037] text-sm">Siap-siap nikmati kopi tanpa drama!</p>
                </div>
                
                <form action="{{ route('menu.placeOrder') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="table_number" class="block text-sm font-bold text-[#2F1B14] mb-2">
                                🪑 Nomor Meja Anda
                            </label>
                            <input type="text" name="table_number" id="table_number" 
                                   class="w-full border-2 border-[#8B4513] rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] font-semibold text-[#2F1B14]" 
                                   placeholder="Contoh: 15" required>
                        </div>
                        <div>
                            <label for="notes" class="block text-sm font-bold text-[#2F1B14] mb-2">
                                📝 Catatan Khusus (opsional)
                            </label>
                            <textarea name="notes" id="notes" rows="3" 
                                      class="w-full border-2 border-[#8B4513] rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#DAA520] focus:border-[#DAA520] text-[#2F1B14]" 
                                      placeholder="Contoh: Gula sedikit, panas banget ya!"></textarea>
                        </div>
                        
                        {{-- Ringkasan pesanan --}}
                        <div class="bg-[#8B4513] rounded-lg p-4 border-2 border-[#DAA520]">
                            <h4 class="font-bold text-[#F5DEB3] mb-3">📋 Ringkasan Pesanan:</h4>
                            <div class="space-y-2 max-h-32 overflow-y-auto">
                                @foreach($cart as $id => $item)
                                <div class="flex justify-between text-[#F5DEB3] text-sm">
                                    <span>{{ $item['quantity'] }}x {{ $item['name'] }}</span>
                                    <span>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                                </div>
                                @endforeach
                            </div>
                            <div class="border-t border-[#DAA520] mt-3 pt-3">
                                <div class="flex justify-between font-bold text-[#DAA520] text-lg">
                                    <span>TOTAL:</span>
                                    <span>Rp {{ number_format(array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0), 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-end gap-4">
                        <button @click="showOrderModal = false" type="button" 
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-300">
                            ❌ Batal
                        </button>
                        <button type="submit" 
                                class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300">
                            🚀 PESAN SEKARANG!
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
