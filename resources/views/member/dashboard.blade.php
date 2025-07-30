<x-app-layout>
    <x-slot name="header">
        <h2 class="font-brand text-3xl leading-tight text-[#F5DEB3]">
            👤 MEMBER DASHBOARD
        </h2>
    </x-slot>

    <div class="py-12 relative z-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-0">
            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] overflow-visible shadow-xl sm:rounded-lg border-2 border-[#DAA520] mb-8 relative z-0">
                <div class="p-6 text-center">
                    <div class="text-5xl mb-4">☕</div>
                    <h3 class="font-elegant text-2xl text-[#F5DEB3] mb-2">Selamat Datang, Coffee Lover!</h3>
                    <p class="text-[#DAA520] font-semibold">Nikmati kopi premium tanpa drama</p>
                    <div class="mt-4 text-[#F5DEB3] opacity-90">
                        Halo, <span class="font-bold text-[#DAA520]">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                <a href="{{ route('menu.index') }}" 
                   class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white text-center transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <div class="text-4xl mb-3">🍴</div>
                    <h4 class="font-bold text-lg">Menu Kopi</h4>
                    <p class="text-green-100 text-sm">Lihat semua menu</p>
                </a>

                <a href="{{ route('orders.index') }}" 
                   class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white text-center transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <div class="text-4xl mb-3">🛍️</div>
                    <h4 class="font-bold text-lg">Pesanan Saya</h4>
                    <p class="text-blue-100 text-sm">Riwayat pesanan</p>
                </a>

                <a href="{{ route('favorites.index') }}" 
                   class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white text-center transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <div class="text-4xl mb-3">⭐</div>
                    <h4 class="font-bold text-lg">Favorit</h4>
                    <p class="text-purple-100 text-sm">{{ $totalFavorites ?? 0 }} kopi favorit</p>
                </a>

                <a href="{{ route('profile.edit') }}" 
                   class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white text-center transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <div class="text-4xl mb-3">👤</div>
                    <h4 class="font-bold text-lg">Profile</h4>
                    <p class="text-yellow-100 text-sm">Edit profil saya</p>
                </a>
            </div>

            <!-- Featured Menu -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] rounded-xl shadow-xl border-2 border-[#DAA520] p-6">
                    <h4 class="font-brand text-2xl text-[#2F1B14] mb-6 text-center">🔥 MENU UNGGULAN</h4>
                    
                    <div class="grid grid-cols-1 gap-4">
                        @forelse($favoriteProducts as $product)
                            <div class="bg-white rounded-lg p-4 flex items-center justify-between shadow-md border border-[#D2B48C]">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-[#8B4513] to-[#A0522D] rounded-full flex items-center justify-center text-white text-xl mr-4">
                                        ☕
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-[#2F1B14]">{{ $product->name }}</h5>
                                        <p class="text-[#8B4513] text-sm">{{ Str::limit($product->description, 50) }}</p>
                                    </div>
                                </div>
                                <div class="text-right flex flex-col items-end">
                                    <p class="font-bold text-[#2F1B14] text-lg mb-2">Rp {{ number_format($product->price) }}</p>
                                    <div class="flex gap-2 items-center">
                                        <button onclick="toggleFavorite({{ $product->id }})" 
                                                class="favorite-btn-{{ $product->id }} text-red-500 hover:text-red-600 transition-colors duration-300">
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                            </svg>
                                        </button>
                                        <a href="{{ route('menu.index') }}" 
                                           class="text-[#DAA520] hover:text-[#B8860B] text-sm font-semibold">
                                            Pesan →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="text-4xl mb-3">📦</div>
                                <p class="text-[#8B4513]">Belum ada menu yang tersedia</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] rounded-xl p-6 border-2 border-[#DAA520]">
                    <h4 class="font-brand text-2xl text-[#F5DEB3] mb-6 text-center">📋 PESANAN TERAKHIR</h4>
                    
                    @if(empty($recentOrders))
                        <div class="text-center py-8">
                            <div class="text-6xl mb-4">🛍️</div>
                            <h5 class="text-[#F5DEB3] font-bold text-lg mb-2">Belum ada pesanan</h5>
                            <p class="text-[#DAA520] mb-4">Yuk, mulai pesan kopi favorit kamu!</p>
                            <a href="{{ route('menu.index') }}" 
                               class="bg-[#DAA520] hover:bg-[#B8860B] text-[#2F1B14] font-bold py-2 px-6 rounded-lg transition-colors duration-300">
                                Lihat Menu
                            </a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                <div class="bg-[#F5DEB3] rounded-lg p-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h5 class="font-bold text-[#2F1B14]">#{{ $order->id }}</h5>
                                            <p class="text-[#8B4513] text-sm">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-[#2F1B14]">Rp {{ number_format($order->total) }}</p>
                                            <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-800">
                                                {{ $order->status }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Coffee Tips -->
            <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] rounded-xl p-6 border-2 border-[#DAA520]">
                <h4 class="font-brand text-2xl text-[#F5DEB3] mb-4 text-center">💡 TIPS KOPI HARI INI</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-[#F5DEB3] rounded-lg p-4 text-center">
                        <div class="text-3xl mb-2">☕</div>
                        <h5 class="font-bold text-[#2F1B14] mb-2">Perfect Brewing</h5>
                        <p class="text-[#8B4513] text-sm">Suhu air ideal untuk kopi adalah 90-96°C</p>
                    </div>
                    
                    <div class="bg-[#F5DEB3] rounded-lg p-4 text-center">
                        <div class="text-3xl mb-2">⏰</div>
                        <h5 class="font-bold text-[#2F1B14] mb-2">Best Time</h5>
                        <p class="text-[#8B4513] text-sm">Waktu terbaik minum kopi adalah pagi dan sore</p>
                    </div>
                    
                    <div class="bg-[#F5DEB3] rounded-lg p-4 text-center">
                        <div class="text-3xl mb-2">🫘</div>
                        <h5 class="font-bold text-[#2F1B14] mb-2">Fresh Beans</h5>
                        <p class="text-[#8B4513] text-sm">Biji kopi terbaik adalah yang digiling fresh</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for AJAX favorites -->
    <script>
        function toggleFavorite(productId) {
            fetch(`/favorites/toggle/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update button visual state
                const btn = document.querySelector(`.favorite-btn-${productId}`);
                if (data.status === 'added') {
                    btn.classList.remove('text-red-500');
                    btn.classList.add('text-red-600');
                } else {
                    btn.classList.remove('text-red-600');
                    btn.classList.add('text-red-500');
                }
                
                showToast(data.message, data.status === 'added' ? 'success' : 'info');
                
                // Optionally refresh page to update favorites count
                if (data.status === 'added') {
                    setTimeout(() => location.reload(), 1500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan', 'error');
            });
        }

        function showToast(message, type = 'success') {
            // Simple toast notification
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white font-semibold z-50 transition-all duration-300 ${
                type === 'success' ? 'bg-green-500' :
                type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            }`;
            toast.textContent = message;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }
    </script>
</x-app-layout>