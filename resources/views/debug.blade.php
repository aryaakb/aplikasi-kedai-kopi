<x-app-layout>
    <x-slot name="header">
        <h2 class="font-brand text-3xl leading-tight">
            🔧 DEBUG ARPUL
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Products Debug -->
            <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] rounded-xl p-6 border-2 border-[#DAA520]">
                <h3 class="font-brand text-2xl text-[#F5DEB3] mb-4">☕ PRODUCTS ({{ $products->count() }})</h3>
                <div class="bg-[#F5DEB3] rounded-lg p-4">
                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($products as $product)
                                <div class="bg-white p-3 rounded-lg border-2 border-[#8B4513]">
                                    <h4 class="font-bold text-[#2F1B14]">{{ $product->name }}</h4>
                                    <p class="text-sm text-[#5D4037]">{{ $product->category }} - Rp {{ number_format($product->price) }}</p>
                                    <p class="text-xs text-[#8B4513]">Stok: {{ $product->stock }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-red-600 font-bold">❌ TIDAK ADA PRODUCTS!</p>
                    @endif
                </div>
            </div>

            <!-- Transactions Debug -->
            <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] rounded-xl p-6 border-2 border-[#DAA520]">
                <h3 class="font-brand text-2xl text-[#F5DEB3] mb-4">🧾 TRANSACTIONS ({{ $transactions->count() }})</h3>
                <div class="bg-[#F5DEB3] rounded-lg p-4">
                    @if($transactions->count() > 0)
                        <div class="space-y-3">
                            @foreach($transactions->take(5) as $transaction)
                                <div class="bg-white p-3 rounded-lg border-2 border-[#8B4513]">
                                    <div class="flex justify-between">
                                        <span class="font-bold text-[#2F1B14]">#{{ $transaction->id }}</span>
                                        <span class="text-[#8B4513]">Rp {{ number_format($transaction->total) }}</span>
                                    </div>
                                    <p class="text-sm text-[#5D4037]">{{ $transaction->user->name ?? 'Unknown' }} - {{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="text-xs text-[#8B4513]">{{ $transaction->details->count() }} items</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-red-600 font-bold">❌ TIDAK ADA TRANSACTIONS!</p>
                    @endif
                </div>
            </div>

            <!-- Users Debug -->
            <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] rounded-xl p-6 border-2 border-[#DAA520]">
                <h3 class="font-brand text-2xl text-[#F5DEB3] mb-4">👥 USERS ({{ $users->count() }})</h3>
                <div class="bg-[#F5DEB3] rounded-lg p-4">
                    @if($users->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($users as $user)
                                <div class="bg-white p-3 rounded-lg border-2 border-[#8B4513]">
                                    <h4 class="font-bold text-[#2F1B14]">{{ $user->name }}</h4>
                                    <p class="text-sm text-[#5D4037]">{{ $user->email }}</p>
                                    <p class="text-xs text-[#8B4513] capitalize">{{ $user->role }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-red-600 font-bold">❌ TIDAK ADA USERS!</p>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] rounded-xl p-6 border-2 border-[#DAA520]">
                <h3 class="font-brand text-2xl text-[#F5DEB3] mb-4">🔗 QUICK LINKS</h3>
                <div class="bg-[#F5DEB3] rounded-lg p-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="/test-products" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg text-center transition-colors">
                            📋 Products View
                        </a>
                        <a href="/test-reports" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg text-center transition-colors">
                            📊 Reports View
                        </a>
                        <a href="/auto-login-admin" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg text-center transition-colors">
                            👑 Login Admin
                        </a>
                        <a href="/dashboard" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-4 rounded-lg text-center transition-colors">
                            🏠 Dashboard
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>