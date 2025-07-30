<x-app-layout>
    <x-slot name="header">
        <h2 class="font-brand text-3xl leading-tight text-[#F5DEB3]">
            ⭐ FAVORIT SAYA
        </h2>
    </x-slot>

    <div class="py-12 relative z-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-0">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] overflow-visible shadow-xl sm:rounded-lg border-2 border-[#DAA520] mb-8 relative z-0">
                <div class="p-6 text-center">
                    <div class="text-5xl mb-4">⭐</div>
                    <h3 class="font-elegant text-2xl text-[#F5DEB3] mb-2">Kopi Favorit Saya</h3>
                    <p class="text-[#DAA520] font-semibold">Koleksi kopi pilihan terbaik Anda</p>
                    <div class="mt-4 text-[#F5DEB3] opacity-90">
                        Total: <span class="font-bold text-[#DAA520]">{{ $favorites->total() }}</span> favorit
                    </div>
                </div>
            </div>

            @if($favorites->count() > 0)
                <!-- Favorites Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                    @foreach($favorites as $product)
                        <div class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] rounded-xl shadow-xl border-2 border-[#DAA520] overflow-hidden transition-all duration-300 hover:transform hover:scale-105">
                            <!-- Product Image -->
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ $product->gambar_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover">
                                <div class="absolute top-3 right-3">
                                    <button onclick="toggleFavorite({{ $product->id }})" 
                                            class="favorite-btn bg-red-500 hover:bg-red-600 text-white rounded-full p-2 transition-colors duration-300 shadow-lg">
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="absolute bottom-3 left-3">
                                    <span class="bg-[#8B4513] text-[#F5DEB3] px-2 py-1 rounded-full text-xs font-semibold">
                                        {{ $product->category }}
                                    </span>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <h4 class="font-bold text-lg text-[#2F1B14] mb-2">{{ $product->name }}</h4>
                                <p class="text-[#8B4513] text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                                
                                <div class="flex justify-between items-center mb-3">
                                    <span class="font-bold text-xl text-[#2F1B14]">
                                        Rp {{ number_format($product->price) }}
                                    </span>
                                    <span class="text-sm text-[#8B4513]">
                                        Stok: {{ $product->stock }}
                                    </span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <a href="{{ route('menu.index') }}" 
                                       class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-2 px-4 rounded-lg text-center text-sm transition-all duration-300">
                                        Pesan
                                    </a>
                                    <button onclick="removeFavorite({{ $product->id }})" 
                                            class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-2 px-3 rounded-lg transition-all duration-300">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $favorites->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] rounded-xl shadow-xl border-2 border-[#DAA520] p-12 text-center">
                    <div class="text-8xl mb-6">💔</div>
                    <h3 class="font-brand text-2xl text-[#2F1B14] mb-4">Belum Ada Favorit</h3>
                    <p class="text-[#8B4513] mb-6">Anda belum menambahkan kopi apapun ke favorit</p>
                    <a href="{{ route('menu.index') }}" 
                       class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] hover:from-[#A0522D] hover:to-[#8B4513] text-[#F5DEB3] font-bold py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105">
                        Jelajahi Menu Kopi
                    </a>
                </div>
            @endif
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
                if (data.status === 'removed') {
                    // Reload page to remove the item from favorites list
                    location.reload();
                }
                showToast(data.message, data.status === 'added' ? 'success' : 'info');
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan', 'error');
            });
        }

        function removeFavorite(productId) {
            if (confirm('Hapus dari favorit?')) {
                fetch(`/favorites/remove/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'removed') {
                        location.reload();
                    }
                    showToast(data.message, 'success');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Terjadi kesalahan', 'error');
                });
            }
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