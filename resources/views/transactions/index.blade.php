<x-app-layout>
    <x-slot name="header">
        <h2 class="font-brand text-3xl leading-tight text-[#F5DEB3]">
            🧾 KASIR ARPUL
        </h2>
    </x-slot>

    <div x-data="{ 
        showModal: false, 
        uangBayar: '', 
        totalBelanja: {{ array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0) }},
        get kembalian() {
            const bayar = parseFloat(this.uangBayar) || 0;
            return bayar >= this.totalBelanja ? bayar - this.totalBelanja : 0;
        },
        get isPaidEnough() {
            return (parseFloat(this.uangBayar) || 0) >= this.totalBelanja;
        }
    }">
        <div class="py-12 relative z-0">
            <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8 relative z-0">
                @if(session('success'))
                    <div class="bg-emerald-500 text-white p-4 rounded-lg mb-6 shadow-md">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-500 text-white p-4 rounded-lg mb-6 shadow-md">{{ session('error') }}</div>
                @endif
                
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Kolom Kiri: Daftar Pesanan -->
                    <div class="w-full lg:w-1/3 flex flex-col gap-6">
                        <!-- Pesanan Menunggu Konfirmasi -->
                        <div class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] overflow-hidden shadow-xl sm:rounded-lg border-2 border-[#DAA520]">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-[#3E2723] mb-4 border-b border-[#D2B48C] pb-2">Menunggu Konfirmasi</h3>
                                <div class="space-y-3 max-h-[35vh] overflow-y-auto">
                                    @forelse ($pendingOrders as $order)
                                        <div class="bg-gradient-to-br from-white to-[#FFF8E1] rounded-xl border-2 border-[#DAA520] shadow-lg hover:shadow-xl transition-all duration-300">
                                            <!-- Header Pesanan -->
                                            <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] text-white p-4 rounded-t-lg">
                                                <div class="flex justify-between items-center">
                                                    <div class="flex items-center space-x-2">
                                                        <span class="text-xl">📋</span>
                                                        <div>
                                                            <div class="font-bold text-lg">#{{ $order->id }} - Meja {{ $order->table_number }}</div>
                                                            <div class="text-[#DAA520] text-sm">👤 {{ $order->user->name }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <div class="text-xs opacity-90">⏰ {{ $order->created_at->diffForHumans() }}</div>
                                                        <div class="bg-yellow-500 text-yellow-900 px-2 py-1 rounded-full text-xs font-bold mt-1">
                                                            MENUNGGU
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Detail Pesanan -->
                                            <div class="p-4">
                                                @if($order->notes)
                                                <div class="bg-blue-50 border-l-4 border-blue-400 p-3 mb-4 rounded">
                                                    <div class="flex items-center">
                                                        <span class="text-blue-600 mr-2">📝</span>
                                                        <span class="text-blue-800 font-medium">Catatan: {{ $order->notes }}</span>
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                <div class="space-y-2 mb-4">
                                                    <h4 class="font-semibold text-[#2F1B14] border-b border-[#DAA520] pb-1">🛒 Item Pesanan:</h4>
                                                    @foreach($order->details as $detail)
                                                        <div class="flex justify-between items-center bg-[#F5DEB3] p-2 rounded-lg">
                                                            <div class="flex items-center space-x-2">
                                                                <span class="bg-[#8B4513] text-white text-xs font-bold px-2 py-1 rounded-full">{{ $detail->quantity }}</span>
                                                                <span class="font-medium text-[#2F1B14]">{{ $detail->product->name }}</span>
                                                            </div>
                                                            <span class="text-[#8B4513] font-bold">Rp {{ number_format($detail->price, 0, ',', '.') }}</span>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Total -->
                                                    <div class="border-t-2 border-[#8B4513] pt-2 mt-2">
                                                        <div class="flex justify-between items-center bg-gradient-to-r from-[#DAA520] to-[#B8860B] text-white p-3 rounded-lg">
                                                            <span class="font-bold">💰 TOTAL:</span>
                                                            <span class="font-bold text-lg">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Action Buttons -->
                                                <div class="flex justify-end items-center gap-3">
                                                    <form action="{{ route('transactions.cancelOrder', $order) }}" method="POST" onsubmit="return confirm('Anda yakin ingin membatalkan pesanan ini?');">
                                                        @csrf
                                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-bold transition duration-300 shadow-md border border-red-500">
                                                            🚫 Batalkan
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('transactions.confirmOrder', $order) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 py-2 rounded-lg font-bold transition duration-300 shadow-md border border-green-500">
                                                            ✅ Konfirmasi
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-center text-gray-500 py-4">Tidak ada pesanan baru.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Pesanan Sedang Diproses -->
                        <div class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] overflow-hidden shadow-xl sm:rounded-lg border-2 border-[#DAA520]">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-[#3E2723] mb-4 border-b border-[#D2B48C] pb-2">Sedang Diproses</h3>
                                <div class="space-y-3 max-h-[35vh] overflow-y-auto">
                                    @forelse ($inProgressOrders as $order)
                                        <div class="bg-gradient-to-br from-white to-[#FFF8E1] rounded-xl border-2 border-[#DAA520] shadow-lg hover:shadow-xl transition-all duration-300">
                                            <!-- Header Pesanan -->
                                            <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] text-white p-4 rounded-t-lg">
                                                <div class="flex justify-between items-center">
                                                    <div class="flex items-center space-x-2">
                                                        <span class="text-xl">⚡</span>
                                                        <div>
                                                            <div class="font-bold text-lg">#{{ $order->id }} - Meja {{ $order->table_number }}</div>
                                                            <div class="text-[#DAA520] text-sm">👤 {{ $order->user->name }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <div class="text-xs opacity-90">⏰ {{ $order->created_at->diffForHumans() }}</div>
                                                        <div class="bg-blue-500 text-blue-900 px-2 py-1 rounded-full text-xs font-bold mt-1">
                                                            DIPROSES
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Detail Pesanan -->
                                            <div class="p-4">
                                                @if($order->notes)
                                                <div class="bg-blue-50 border-l-4 border-blue-400 p-3 mb-4 rounded">
                                                    <div class="flex items-center">
                                                        <span class="text-blue-600 mr-2">📝</span>
                                                        <span class="text-blue-800 font-medium">Catatan: {{ $order->notes }}</span>
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                <div class="space-y-2 mb-4">
                                                    <h4 class="font-semibold text-[#2F1B14] border-b border-[#DAA520] pb-1">🛒 Item Pesanan:</h4>
                                                    @foreach($order->details as $detail)
                                                        <div class="flex justify-between items-center bg-[#F5DEB3] p-2 rounded-lg">
                                                            <div class="flex items-center space-x-2">
                                                                <span class="bg-[#8B4513] text-white text-xs font-bold px-2 py-1 rounded-full">{{ $detail->quantity }}</span>
                                                                <span class="font-medium text-[#2F1B14]">{{ $detail->product->name }}</span>
                                                            </div>
                                                            <span class="text-[#8B4513] font-bold">Rp {{ number_format($detail->price, 0, ',', '.') }}</span>
                                                        </div>
                                                    @endforeach
                                                    
                                                    <!-- Total -->
                                                    <div class="border-t-2 border-[#8B4513] pt-2 mt-2">
                                                        <div class="flex justify-between items-center bg-gradient-to-r from-[#DAA520] to-[#B8860B] text-white p-3 rounded-lg">
                                                            <span class="font-bold">💰 TOTAL:</span>
                                                            <span class="font-bold text-lg">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Action Buttons -->
                                                <div class="flex justify-end items-center gap-3">
                                                    <form action="{{ route('transactions.cancelOrder', $order) }}" method="POST" onsubmit="return confirm('Anda yakin ingin membatalkan pesanan ini?');">
                                                        @csrf
                                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-bold transition duration-300 shadow-md border border-red-500">
                                                            🚫 Batalkan
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('transactions.loadOrder', $order) }}" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 py-2 rounded-lg font-bold transition duration-300 shadow-md border border-green-500">
                                                        💰 Proses Bayar
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-center text-gray-500 py-4">Tidak ada pesanan yang diproses.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Point of Sale (POS) -->
                    <div class="w-full lg:w-2/3 flex flex-col md:flex-row gap-6">
                        <!-- Keranjang & Pembayaran -->
                        <div class="w-full md:w-1/3 order-2 md:order-1">
                            <div class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] overflow-hidden shadow-xl sm:rounded-lg border-2 border-[#DAA520] sticky top-20">
                                <div class="p-6">
                                    <h3 class="text-lg font-medium text-[#3E2723] mb-4 border-b border-[#D2B48C] pb-2">
                                        {{ session('processing_transaction_id') ? 'Pembayaran Pesanan #' . session('processing_transaction_id') : 'Keranjang' }}
                                    </h3>
                                    <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                                        @forelse($cart as $id => $item)
                                        <div class="flex justify-between items-center border-b border-dashed border-[#D2B48C] pb-2">
                                            <div>
                                                <h4 class="font-medium text-[#3E2723]">{{ $item['name'] }}</h4>
                                                <span class="text-sm text-[#5D4037]">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                            </div>
                                            <form action="{{ route('transactions.removeFromCart') }}" method="POST">
                                                @csrf <input type="hidden" name="product_id" value="{{ $id }}">
                                                <button type="submit" class="text-[#BF360C] hover:text-[#A6320F]">&times;</button>
                                            </form>
                                        </div>
                                        @empty
                                        <p class="text-[#8D6E63] text-center py-4">Keranjang kosong</p>
                                        @endforelse
                                    </div>
                                    @if(count($cart) > 0)
                                    <div class="mt-4 pt-4 border-t border-[#D2B48C]">
                                        <div class="flex justify-between font-bold text-lg text-[#3E2723]">
                                            <span>Total:</span>
                                            <span x-text="`Rp ${totalBelanja.toLocaleString('id-ID')}`"></span>
                                        </div>
                                        <button @click="showModal = true" class="mt-4 w-full bg-gradient-to-r from-[#8B4513] to-[#A0522D] hover:from-[#A0522D] hover:to-[#8B4513] text-[#F5DEB3] font-bold py-3 px-4 rounded-lg shadow-lg border-2 border-[#DAA520] transition duration-300">
                                            💰 BAYAR SEKARANG
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Daftar Produk -->
                        <div class="w-full md:w-2/3 order-1 md:order-2">
                            <div class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] overflow-hidden shadow-xl sm:rounded-lg border-2 border-[#DAA520]">
                                <div class="p-6 max-h-[80vh] overflow-y-auto">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @forelse($products as $product)
                                            <div class="bg-[#FFF8E1] border border-[#D2B48C] rounded-lg overflow-hidden shadow-sm hover:shadow-md flex flex-col">
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-32 object-cover">
                                                <div class="p-3 flex-grow flex flex-col">
                                                    <h4 class="font-semibold text-md text-[#3E2723]">{{ $product->name }}</h4>
                                                    <p class="text-sm text-[#5D4037]">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                                    <form action="{{ route('transactions.addToCart') }}" method="POST" class="mt-auto pt-2">
                                                        @csrf <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <button type="submit" class="w-full text-sm bg-[#BF360C] hover:bg-[#A6320F] text-white py-1 px-2 rounded-md" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                                            {{ $product->stock > 0 ? 'Tambah' : 'Habis' }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-span-full text-center py-12">
                                                <div class="text-6xl mb-4">📦</div>
                                                <h4 class="text-2xl font-bold text-[#3E2723] mb-2">Tidak Ada Produk</h4>
                                                <p class="text-[#5D4037]">Belum ada produk yang tersedia untuk dijual.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Pembayaran -->
        <div x-show="showModal" x-transition class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-70" style="display: none;">
            <div @click.away="showModal = false" class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] rounded-xl shadow-2xl p-8 w-full max-w-lg mx-4 border-4 border-[#DAA520] relative z-[10000]">
                <div class="text-center mb-6">
                    <div class="text-4xl mb-2">💰</div>
                    <h3 class="text-2xl font-brand text-[#2F1B14] tracking-wide">DETAIL PEMBAYARAN</h3>
                    <div class="w-16 h-1 bg-[#8B4513] mx-auto mt-2 rounded"></div>
                </div>
                
                <form action="{{ route('transactions.complete') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <!-- Total -->
                        <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] rounded-lg p-4 text-white">
                            <div class="flex justify-between items-center text-xl">
                                <span class="font-elegant">Total Belanja:</span>
                                <span class="font-brand text-2xl text-[#DAA520]" x-text="`Rp ${totalBelanja.toLocaleString('id-ID')}`"></span>
                            </div>
                        </div>
                        
                        <!-- Input Uang Bayar -->
                        <div class="bg-white rounded-lg p-4 border-2 border-[#8B4513]">
                            <label for="uang_bayar" class="block text-lg font-semibold text-[#2F1B14] mb-2">💵 Uang Dibayar:</label>
                            <input type="number" name="paid_amount" x-model.number="uangBayar" 
                                   class="w-full border-2 border-[#DAA520] rounded-lg shadow-sm py-3 px-4 text-xl font-bold text-[#2F1B14] focus:border-[#8B4513] focus:ring-0 bg-[#FFFEF7]" 
                                   placeholder="Masukkan nominal uang" required>
                        </div>
                        
                        <!-- Kembalian -->
                        <div class="bg-gradient-to-r from-[#DAA520] to-[#B8860B] rounded-lg p-4 text-white">
                            <div class="flex justify-between items-center text-xl">
                                <span class="font-elegant">💸 Kembalian:</span>
                                <span class="font-brand text-2xl" x-text="`Rp ${kembalian.toLocaleString('id-ID')}`"></span>
                            </div>
                        </div>
                        
                        <!-- Peringatan jika uang kurang -->
                        <div x-show="!isPaidEnough && uangBayar > 0" class="bg-red-100 border-2 border-red-400 text-red-700 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <span class="text-xl mr-2">⚠️</span>
                                <span class="font-semibold">Uang yang dibayar kurang!</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-center gap-4">
                        <button @click="showModal = false" type="button" 
                                class="bg-[#8B4513] hover:bg-[#A0522D] text-white font-bold py-3 px-6 rounded-lg transition duration-300 border-2 border-[#654321] shadow-lg">
                            🚫 Batal
                        </button>
                        <button type="submit" :disabled="!isPaidEnough" 
                                :class="{'bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white': isPaidEnough, 'bg-gray-400 cursor-not-allowed text-gray-600': !isPaidEnough}" 
                                class="font-bold py-3 px-6 rounded-lg transition duration-300 border-2 shadow-lg"
                                :style="isPaidEnough ? 'border-color: #16a34a' : 'border-color: #9ca3af'">
                            🧾 Selesaikan & Cetak Struk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
