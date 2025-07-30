<x-app-layout>
    <x-slot name="header">
        <h2 class="font-brand text-3xl leading-tight text-[#F5DEB3]" style="font-family: 'Bebas Neue', sans-serif;">
            📊 LAPORAN PENJUALAN ARPUL
        </h2>
    </x-slot>

    <div class="py-12" style="background: linear-gradient(135deg, #2F1B14, #4A2C2A);">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#F5DEB3] overflow-hidden shadow-xl sm:rounded-lg border-4 border-[#DAA520]">
                <div class="p-6 lg:p-8">
                    
                    <!-- Header Section -->
                    <div class="text-center mb-8">
                        <h1 class="text-4xl font-brand text-[#2F1B14] mb-2" style="font-family: 'Bebas Neue', sans-serif;">
                            💰 LAPORAN PENJUALAN
                        </h1>
                        <p class="text-[#8B4513] font-medium">Analisis lengkap transaksi Arpul</p>
                    </div>

                    @php
                        $transactionCount = isset($transactions) ? $transactions->count() : 0;
                        $totalRevenue = isset($total) ? $total : 0;
                    @endphp

                    <!-- Filter Section -->
                    <div class="bg-white rounded-xl p-6 mb-8 border-2 border-[#DAA520] shadow-lg">
                        <h3 class="font-brand text-xl text-[#2F1B14] mb-4">🔍 FILTER LAPORAN</h3>
                        <form method="GET" action="{{ route('admin.reports.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[#8B4513] font-medium mb-2">Tanggal Mulai</label>
                                <input type="date" 
                                       name="start_date" 
                                       value="{{ request('start_date', $startDate ?? now()->subDays(30)->format('Y-m-d')) }}"
                                       class="w-full px-4 py-2 rounded-lg border-2 border-[#DAA520] focus:border-[#8B4513] focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[#8B4513] font-medium mb-2">Tanggal Akhir</label>
                                <input type="date" 
                                       name="end_date" 
                                       value="{{ request('end_date', $endDate ?? now()->format('Y-m-d')) }}"
                                       class="w-full px-4 py-2 rounded-lg border-2 border-[#DAA520] focus:border-[#8B4513] focus:outline-none">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" 
                                        class="w-full bg-[#8B4513] hover:bg-[#A0522D] text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                                    🔍 Filter Data
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Revenue Summary -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div class="bg-gradient-to-r from-[#8B4513] to-[#A0522D] rounded-xl p-6 text-white text-center shadow-lg">
                            <div class="text-3xl mb-2">💰</div>
                            <div class="text-2xl font-bold">Rp {{ number_format($totalRevenue) }}</div>
                            <div class="text-sm opacity-80">Total Pendapatan</div>
                        </div>
                        <div class="bg-gradient-to-r from-[#DAA520] to-[#B8860B] rounded-xl p-6 text-white text-center shadow-lg">
                            <div class="text-3xl mb-2">🧾</div>
                            <div class="text-2xl font-bold">{{ $transactionCount }}</div>
                            <div class="text-sm opacity-80">Total Transaksi</div>
                        </div>
                        <div class="bg-gradient-to-r from-[#CD853F] to-[#D2691E] rounded-xl p-6 text-white text-center shadow-lg">
                            <div class="text-3xl mb-2">📈</div>
                            <div class="text-2xl font-bold">Rp {{ $transactionCount > 0 ? number_format($totalRevenue / $transactionCount) : '0' }}</div>
                            <div class="text-sm opacity-80">Rata-rata/Transaksi</div>
                        </div>
                        <div class="bg-gradient-to-r from-[#A0522D] to-[#8B4513] rounded-xl p-6 text-white text-center shadow-lg">
                            <div class="text-3xl mb-2">☕</div>
                            <div class="text-2xl font-bold">{{ isset($transactions) ? $transactions->sum(function($t) { return $t->details->sum('quantity'); }) : 0 }}</div>
                            <div class="text-sm opacity-80">Total Item Terjual</div>
                        </div>
                    </div>

                    <!-- Export Buttons -->
                    @if($transactionCount > 0)
                        <div class="text-center mb-6">
                            <div x-data="{ showExportOptions: false }" class="inline-block">
                                <button @click="showExportOptions = !showExportOptions" 
                                        class="bg-[#8B4513] hover:bg-[#A0522D] text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-lg mr-2">
                                    📤 Export Laporan
                                    <span x-text="showExportOptions ? '🔼' : '🔽'"></span>
                                </button>
                                
                                <div x-show="showExportOptions" 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                                     x-transition:enter-end="opacity-100 transform translate-y-0"
                                     class="absolute z-10 mt-2 bg-white rounded-lg shadow-lg border-2 border-[#DAA520] p-4 min-w-[200px]">
                                    
                                    <!-- PDF Export -->
                                    <form action="{{ route('admin.reports.export') }}" method="POST" class="mb-2">
                                        @csrf
                                        <input type="hidden" name="start_date" value="{{ request('start_date', $startDate ?? '') }}">
                                        <input type="hidden" name="end_date" value="{{ request('end_date', $endDate ?? '') }}">
                                        <input type="hidden" name="format" value="pdf">
                                        <button type="submit" 
                                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 text-sm">
                                            📄 Export PDF
                                        </button>
                                    </form>
                                    
                                    <!-- CSV Export Options -->
                                    <div x-data="{ showCsvOptions: false }">
                                        <button @click="showCsvOptions = !showCsvOptions" 
                                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 text-sm">
                                            📊 Export Excel/CSV
                                            <span x-text="showCsvOptions ? '🔼' : '🔽'" class="text-xs"></span>
                                        </button>
                                        
                                        <div x-show="showCsvOptions" 
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0"
                                             x-transition:enter-end="opacity-100"
                                             class="mt-2 space-y-1">
                                             
                                            <!-- Detailed CSV -->
                                            <form action="{{ route('admin.reports.export') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="start_date" value="{{ request('start_date', $startDate ?? '') }}">
                                                <input type="hidden" name="end_date" value="{{ request('end_date', $endDate ?? '') }}">
                                                <input type="hidden" name="format" value="csv">
                                                <input type="hidden" name="csv_type" value="detailed">
                                                <button type="submit" 
                                                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-1 px-3 rounded text-xs">
                                                    📋 Detail per Item
                                                </button>
                                            </form>
                                            
                                            <!-- Summary CSV -->
                                            <form action="{{ route('admin.reports.export') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="start_date" value="{{ request('start_date', $startDate ?? '') }}">
                                                <input type="hidden" name="end_date" value="{{ request('end_date', $endDate ?? '') }}">
                                                <input type="hidden" name="format" value="csv">
                                                <input type="hidden" name="csv_type" value="summary">
                                                <button type="submit" 
                                                        class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-1 px-3 rounded text-xs">
                                                    📊 Ringkasan per Transaksi
                                                </button>
                                            </form>
                                        </div>
                                        
                                        <p class="text-xs text-gray-600 mt-1">
                                            💡 Buka dengan Excel: Data → From Text/CSV
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Transactions Table -->
                    <div class="bg-white rounded-xl p-6 border-2 border-[#DAA520] shadow-lg overflow-x-auto">
                        <h3 class="font-brand text-xl text-[#2F1B14] mb-6 text-center">📋 DETAIL TRANSAKSI</h3>
                        
                        @if($transactionCount > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse">
                                    <thead>
                                        <tr class="bg-[#8B4513] text-white">
                                            <th class="border border-[#654321] px-4 py-3 text-left">ID</th>
                                            <th class="border border-[#654321] px-4 py-3 text-left">Tanggal</th>
                                            <th class="border border-[#654321] px-4 py-3 text-left">Customer</th>
                                            <th class="border border-[#654321] px-4 py-3 text-left">Items</th>
                                            <th class="border border-[#654321] px-4 py-3 text-right">Total</th>
                                            <th class="border border-[#654321] px-4 py-3 text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr class="hover:bg-[#F5DEB3] transition duration-200 border-b border-[#DAA520]">
                                                <td class="border border-[#DAA520] px-4 py-3 font-bold text-[#8B4513]">
                                                    #{{ $transaction->id }}
                                                </td>
                                                <td class="border border-[#DAA520] px-4 py-3 text-[#654321]">
                                                    {{ $transaction->created_at->format('d/m/Y H:i') }}
                                                </td>
                                                <td class="border border-[#DAA520] px-4 py-3 text-[#654321]">
                                                    {{ $transaction->user->name ?? 'Guest' }}
                                                    <br>
                                                    <small class="text-[#8B4513]">{{ $transaction->user->email ?? '' }}</small>
                                                </td>
                                                <td class="border border-[#DAA520] px-4 py-3">
                                                    @if(isset($transaction->details) && $transaction->details->count() > 0)
                                                        @foreach($transaction->details as $detail)
                                                            <div class="text-sm text-[#654321] mb-1">
                                                                {{ $detail->quantity }}x {{ $detail->product->name ?? 'Product' }}
                                                                <span class="text-[#8B4513]">(Rp {{ number_format($detail->price ?? 0) }})</span>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <span class="text-gray-500 italic">No items</span>
                                                    @endif
                                                </td>
                                                <td class="border border-[#DAA520] px-4 py-3 text-right">
                                                    <span class="font-bold text-[#8B4513] text-lg">
                                                        Rp {{ number_format($transaction->total ?? 0) }}
                                                    </span>
                                                </td>
                                                <td class="border border-[#DAA520] px-4 py-3 text-center">
                                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                                        ✅ Selesai
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-[#DAA520] text-white font-bold">
                                            <td colspan="4" class="border border-[#B8860B] px-4 py-3 text-right">
                                                TOTAL KESELURUHAN:
                                            </td>
                                            <td class="border border-[#B8860B] px-4 py-3 text-right text-xl">
                                                Rp {{ number_format($totalRevenue) }}
                                            </td>
                                            <td class="border border-[#B8860B] px-4 py-3"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="text-6xl mb-4">📊</div>
                                <h3 class="text-2xl font-brand text-[#8B4513] mb-2">Belum Ada Transaksi</h3>
                                <p class="text-[#A0522D] mb-6">Belum ada data transaksi untuk periode yang dipilih.</p>
                                <p class="text-[#654321] text-sm">
                                    Coba ubah filter tanggal atau pastikan sudah ada transaksi di sistem.
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Footer Note -->
                    <div class="mt-8 text-center">
                        <p class="text-[#8B4513] text-sm">
                            💡 <strong>Tips:</strong> Gunakan filter tanggal untuk melihat periode tertentu. 
                            Export PDF untuk menyimpan laporan.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>