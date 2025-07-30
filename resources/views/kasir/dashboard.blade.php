<x-app-layout>
    <x-slot name="header">
        <h2 class="font-brand text-3xl leading-tight text-[#F5DEB3]">
            💳 KASIR DASHBOARD
        </h2>
    </x-slot>

    <div class="py-12 relative z-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-0">
            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] overflow-visible shadow-xl sm:rounded-lg border-2 border-[#DAA520] mb-8 relative z-0">
                <div class="p-6 text-center">
                    <div class="text-5xl mb-4">💳</div>
                    <h3 class="font-elegant text-2xl text-[#F5DEB3] mb-2">Dashboard Kasir</h3>
                    <p class="text-[#DAA520] font-semibold">Sistem Point of Sale Arpul</p>
                    <div class="mt-4 text-[#F5DEB3] opacity-90">
                        Selamat datang, <span class="font-bold text-[#DAA520]">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Sales Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm">Penjualan Hari Ini</p>
                            <p class="text-2xl font-bold">Rp {{ number_format($todaySales) }}</p>
                        </div>
                        <div class="text-4xl opacity-80">💰</div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm">Transaksi Hari Ini</p>
                            <p class="text-2xl font-bold">{{ $todayTransactions }}</p>
                        </div>
                        <div class="text-4xl opacity-80">🧾</div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm">Total Produk</p>
                            <p class="text-2xl font-bold">{{ $totalProducts }}</p>
                        </div>
                        <div class="text-4xl opacity-80">☕</div>
                    </div>
                </div>
            </div>

            <!-- Quick POS Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] rounded-xl shadow-xl border-2 border-[#DAA520] p-6">
                    <h4 class="font-brand text-xl text-[#2F1B14] mb-4 text-center">⚡ AKSI CEPAT</h4>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('transactions.index') }}" 
                           class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-4 px-6 rounded-lg text-center transition-all duration-300 transform hover:scale-105">
                            <div class="text-3xl mb-2">🛒</div>
                            <div class="text-sm">Mulai Transaksi</div>
                        </a>

                        <a href="{{ route('transactions.index') }}" 
                           class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-lg text-center transition-all duration-300 transform hover:scale-105">
                            <div class="text-3xl mb-2">📋</div>
                            <div class="text-sm">Riwayat Transaksi</div>
                        </a>

                        <a href="#" 
                           class="bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white font-bold py-4 px-6 rounded-lg text-center transition-all duration-300 transform hover:scale-105">
                            <div class="text-3xl mb-2">📊</div>
                            <div class="text-sm">Laporan Harian</div>
                        </a>

                        <a href="#" 
                           class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold py-4 px-6 rounded-lg text-center transition-all duration-300 transform hover:scale-105">
                            <div class="text-3xl mb-2">🔄</div>
                            <div class="text-sm">Sync Data</div>
                        </a>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] rounded-xl p-6 border-2 border-[#DAA520]">
                    <h4 class="font-brand text-xl text-[#F5DEB3] mb-4 text-center">🔥 PRODUK POPULER</h4>
                    
                    <div class="space-y-3">
                        @forelse($popularProducts as $product)
                            <div class="bg-[#F5DEB3] rounded-lg p-3 flex justify-between items-center">
                                <div>
                                    <h5 class="font-semibold text-[#2F1B14] text-sm">{{ $product->name }}</h5>
                                    <p class="text-[#8B4513] text-xs">Stok: {{ $product->stock }}</p>
                                </div>
                                <div class="text-[#2F1B14] font-bold">
                                    Rp {{ number_format($product->price) }}
                                </div>
                            </div>
                        @empty
                            <div class="text-[#F5DEB3] text-center py-4">
                                <div class="text-2xl mb-2">📦</div>
                                <p class="text-sm">Belum ada data produk</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Today's Summary -->
            <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] rounded-xl p-6 border-2 border-[#DAA520]">
                <h4 class="font-brand text-2xl text-[#F5DEB3] mb-4 text-center">📈 RINGKASAN HARI INI</h4>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div class="bg-[#F5DEB3] rounded-lg p-4">
                        <div class="text-2xl text-[#2F1B14] mb-2">☕</div>
                        <p class="text-[#2F1B14] font-bold text-lg">0</p>
                        <p class="text-[#8B4513] text-xs">Kopi Terjual</p>
                    </div>
                    
                    <div class="bg-[#F5DEB3] rounded-lg p-4">
                        <div class="text-2xl text-[#2F1B14] mb-2">🍞</div>
                        <p class="text-[#2F1B14] font-bold text-lg">0</p>
                        <p class="text-[#8B4513] text-xs">Makanan Terjual</p>
                    </div>
                    
                    <div class="bg-[#F5DEB3] rounded-lg p-4">
                        <div class="text-2xl text-[#2F1B14] mb-2">👥</div>
                        <p class="text-[#2F1B14] font-bold text-lg">0</p>
                        <p class="text-[#8B4513] text-xs">Pelanggan Dilayani</p>
                    </div>
                    
                    <div class="bg-[#F5DEB3] rounded-lg p-4">
                        <div class="text-2xl text-[#2F1B14] mb-2">⭐</div>
                        <p class="text-[#2F1B14] font-bold text-lg">-</p>
                        <p class="text-[#8B4513] text-xs">Rata-rata Order</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>