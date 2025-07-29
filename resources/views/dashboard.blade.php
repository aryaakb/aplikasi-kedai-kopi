<x-app-layout>
    <x-slot name="header">
        <h2 class="font-brand text-3xl leading-tight">
            DASHBOARD
        </h2>
    </x-slot>

    <div class="py-12 relative z-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-0">
            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] overflow-visible shadow-xl sm:rounded-lg border-2 border-[#DAA520] mb-8 relative z-0">
                <div class="p-8 text-center">
                    <div class="text-6xl mb-4">☕</div>
                    <h3 class="font-elegant text-2xl text-[#F5DEB3] mb-2">Selamat Datang di NoFvckingCoffee</h3>
                    <p class="text-[#DAA520] font-semibold">{{ __("Anda berhasil login!") }}</p>
                    <div class="mt-4 text-[#F5DEB3] opacity-90">
                        Peran: <span class="font-bold text-[#DAA520] uppercase">{{ Auth::user()->role }}</span>
                    </div>
                </div>
            </div>

            {{-- Analytics Dashboard for admin and cashier --}}
            @if(in_array(auth()->user()->role, ['admin', 'cashier']))
            
            @php
                // Data dummy untuk demo - dalam aplikasi nyata ini dari controller
                $todaySales = 2750000;
                $todayTransactions = 47;
                $weeklySales = 18500000;
                $weeklyTransactions = 312;
                $totalProducts = 24;
                $lowStockProducts = 3;
                $averageOrderValue = 58500;
                $totalCustomers = 156;
                
                // Top Products Data
                $topProducts = [
                    (object)['name' => 'Americano Special', 'total_sold' => 156, 'revenue' => 4680000],
                    (object)['name' => 'Cappuccino Premium', 'total_sold' => 134, 'revenue' => 4020000],
                    (object)['name' => 'Latte Signature', 'total_sold' => 98, 'revenue' => 3430000],
                    (object)['name' => 'Cold Brew No BS', 'total_sold' => 87, 'revenue' => 2610000],
                    (object)['name' => 'Espresso Double Shot', 'total_sold' => 76, 'revenue' => 1900000]
                ];
                
                // Daily Sales Data (7 hari terakhir)
                $dailySales = [
                    (object)['date' => 'Sen', 'total' => 2100000, 'transactions' => 38],
                    (object)['date' => 'Sel', 'total' => 2450000, 'transactions' => 42],
                    (object)['date' => 'Rab', 'total' => 2890000, 'transactions' => 51],
                    (object)['date' => 'Kam', 'total' => 3200000, 'transactions' => 56],
                    (object)['date' => 'Jum', 'total' => 3850000, 'transactions' => 67],
                    (object)['date' => 'Sab', 'total' => 4260000, 'transactions' => 73],
                    (object)['date' => 'Min', 'total' => 2750000, 'transactions' => 47]
                ];
                $maxDailySales = 4260000;
                
                // Business Insights
                $busiestHour = '14:00 - 15:00';
                $busiestHourTransactions = 23;
                $bestDay = 'Sabtu';
                $bestDayRevenue = 4260000;
                $growthRate = 18.5;
            @endphp
            
            <!-- Statistik Utama -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 relative z-0">
                <!-- Today's Revenue -->
                <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] p-6 rounded-xl shadow-xl border-2 border-[#DAA520] transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center space-x-4">
                        <div class="bg-[#DAA520] p-4 rounded-full text-[#2F1B14]">
                            <div class="text-2xl">💰</div>
                        </div>
                        <div>
                            <p class="text-sm text-[#F5DEB3] opacity-90 font-elegant">Pendapatan Hari Ini</p>
                            <p class="text-2xl font-bold text-[#F5DEB3] font-brand">Rp {{ number_format($todaySales, 0, ',', '.') }}</p>
                            <p class="text-xs text-[#DAA520]">{{ $todayTransactions }} transaksi</p>
                        </div>
                    </div>
                </div>

                <!-- Weekly Revenue -->
                <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] p-6 rounded-xl shadow-xl border-2 border-[#DAA520] transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center space-x-4">
                        <div class="bg-[#DAA520] p-4 rounded-full text-[#2F1B14]">
                            <div class="text-2xl">📈</div>
                        </div>
                        <div>
                            <p class="text-sm text-[#F5DEB3] opacity-90 font-elegant">Pendapatan Minggu Ini</p>
                            <p class="text-2xl font-bold text-[#F5DEB3] font-brand">Rp {{ number_format($weeklySales, 0, ',', '.') }}</p>
                            <p class="text-xs text-[#DAA520]">{{ $weeklyTransactions }} transaksi</p>
                        </div>
                    </div>
                </div>

                <!-- Total Products -->
                <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] p-6 rounded-xl shadow-xl border-2 border-[#DAA520] transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center space-x-4">
                        <div class="bg-[#DAA520] p-4 rounded-full text-[#2F1B14]">
                            <div class="text-2xl">☕</div>
                        </div>
                        <div>
                            <p class="text-sm text-[#F5DEB3] opacity-90 font-elegant">Total Produk</p>
                            <p class="text-2xl font-bold text-[#F5DEB3] font-brand">{{ $totalProducts }}</p>
                            <p class="text-xs text-[#DAA520]">{{ $lowStockProducts }} stok rendah</p>
                        </div>
                    </div>
                </div>

                <!-- Average Order Value -->
                <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] p-6 rounded-xl shadow-xl border-2 border-[#DAA520] transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center space-x-4">
                        <div class="bg-[#DAA520] p-4 rounded-full text-[#2F1B14]">
                            <div class="text-2xl">🎯</div>
                        </div>
                        <div>
                            <p class="text-sm text-[#F5DEB3] opacity-90 font-elegant">Rata-rata Pesanan</p>
                            <p class="text-2xl font-bold text-[#F5DEB3] font-brand">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</p>
                            <p class="text-xs text-[#DAA520]">{{ $totalCustomers }} pelanggan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics Charts & Insights -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Produk Terlaris -->
                <div class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] rounded-xl shadow-xl border-2 border-[#DAA520] p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-brand text-[#2F1B14]">🏆 PRODUK TERLARIS</h3>
                        <span class="bg-[#8B4513] text-[#F5DEB3] px-3 py-1 rounded-full text-sm font-bold">TOP 5</span>
                    </div>
                    <div class="space-y-4">
                        @foreach($topProducts as $index => $product)
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg border border-[#DAA520] hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-3">
                                <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <p class="font-bold text-[#2F1B14]">{{ $product->name }}</p>
                                    <p class="text-sm text-[#8B4513]">{{ $product->total_sold }} terjual</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-[#8B4513]">Rp {{ number_format($product->revenue, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-600">revenue</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Penjualan Harian -->
                <div class="bg-gradient-to-br from-[#F5DEB3] to-[#E6D3A3] rounded-xl shadow-xl border-2 border-[#DAA520] p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-brand text-[#2F1B14]">📊 PENJUALAN 7 HARI</h3>
                        <span class="bg-[#8B4513] text-[#F5DEB3] px-3 py-1 rounded-full text-sm font-bold">CHART</span>
                    </div>
                    <div class="space-y-3">
                        @foreach($dailySales as $day)
                        @php
                            $percentage = $maxDailySales > 0 ? ($day->total / $maxDailySales) * 100 : 0;
                        @endphp
                        <div class="flex items-center space-x-3">
                            <div class="w-16 text-sm font-medium text-[#2F1B14]">{{ $day->date }}</div>
                            <div class="flex-1 bg-gray-200 rounded-full h-6 relative overflow-hidden">
                                <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] h-full rounded-full transition-all duration-500" 
                                     style="width: {{ $percentage }}%"></div>
                                <div class="absolute inset-0 flex items-center justify-center text-xs font-bold text-white">
                                    Rp {{ number_format($day->total, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="w-12 text-xs text-[#8B4513] font-medium">{{ $day->transactions }}x</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Quick Insights -->
            <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] rounded-xl shadow-xl border-2 border-[#DAA520] p-6 mb-8">
                <h3 class="text-2xl font-brand text-[#F5DEB3] mb-4">🔍 INSIGHTS BISNIS</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white/10 backdrop-blur rounded-lg p-4 border border-[#DAA520]">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="text-xl">⏰</span>
                            <h4 class="font-bold text-[#F5DEB3]">Jam Tersibuk</h4>
                        </div>
                        <p class="text-2xl font-brand text-[#DAA520]">{{ $busiestHour }}</p>
                        <p class="text-sm text-[#F5DEB3] opacity-80">{{ $busiestHourTransactions }} transaksi</p>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur rounded-lg p-4 border border-[#DAA520]">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="text-xl">📅</span>
                            <h4 class="font-bold text-[#F5DEB3]">Hari Terbaik</h4>
                        </div>
                        <p class="text-2xl font-brand text-[#DAA520]">{{ $bestDay }}</p>
                        <p class="text-sm text-[#F5DEB3] opacity-80">Rp {{ number_format($bestDayRevenue, 0, ',', '.') }}</p>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur rounded-lg p-4 border border-[#DAA520]">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="text-xl">🎯</span>
                            <h4 class="font-bold text-[#F5DEB3]">Growth Rate</h4>
                        </div>
                        <p class="text-2xl font-brand text-[#DAA520]">{{ $growthRate }}%</p>
                        <p class="text-sm text-[#F5DEB3] opacity-80">vs minggu lalu</p>
                    </div>
                </div>
            </div>

            @endif

            <!-- Quick Actions Section for Members -->
            @if(auth()->user()->role === 'member')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-0">
                <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] p-8 rounded-xl shadow-xl border-2 border-[#DAA520] text-center">
                    <div class="text-5xl mb-4">🍴</div>
                    <h3 class="font-elegant text-xl text-[#F5DEB3] mb-4">Jelajahi Menu Kami</h3>
                    <p class="text-[#F5DEB3] opacity-90 mb-6">Temukan pilihan kopi premium dan camilan lezat kami</p>
                    <a href="{{ route('menu.index') }}" class="bg-[#DAA520] hover:bg-[#B8860B] text-[#2F1B14] font-bold py-3 px-6 rounded-lg transition-colors duration-300">
                        LIHAT MENU
                    </a>
                </div>
                
                <div class="bg-gradient-to-br from-[#8B4513] to-[#A0522D] p-8 rounded-xl shadow-xl border-2 border-[#DAA520] text-center">
                    <div class="text-5xl mb-4">🛍️</div>
                    <h3 class="font-elegant text-xl text-[#F5DEB3] mb-4">Pesanan Saya</h3>
                    <p class="text-[#F5DEB3] opacity-90 mb-6">Lacak pesanan kopi terkini dan sebelumnya</p>
                    <a href="{{ route('orders.index') }}" class="bg-[#DAA520] hover:bg-[#B8860B] text-[#2F1B14] font-bold py-3 px-6 rounded-lg transition-colors duration-300">
                        LIHAT PESANAN
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
