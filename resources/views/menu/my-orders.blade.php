<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-stone-800 leading-tight">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-emerald-500 text-white p-4 rounded-lg mb-6 shadow-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-[#F5F5DC] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-6">
                        @forelse ($orders as $order)
                            <div x-data="{ open: false }" class="bg-[#FFF8E1] p-4 rounded-lg border border-[#D2B48C]">
                                <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
                                    <div>
                                        <h3 class="font-bold text-lg text-[#3E2723]">Pesanan #{{ $order->id }}</h3>
                                        <p class="text-sm text-[#5D4037]">{{ $order->created_at->format('d F Y, H:i') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full
                                            @switch($order->status)
                                                @case('pending') bg-yellow-200 text-yellow-800 @break
                                                @case('in_progress') bg-cyan-200 text-cyan-800 @break
                                                @case('paid') bg-green-200 text-green-800 @break
                                                @case('canceled') bg-red-200 text-red-800 @break
                                                @default bg-gray-200 text-gray-800
                                            @endswitch">
                                            {{ str_replace('_', ' ', ucfirst($order->status)) }}
                                        </span>
                                        <p class="font-bold text-lg text-[#3E2723]">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                
                                <div x-show="open" x-transition class="mt-4 border-t border-dashed border-[#D2B48C] pt-4">
                                    <h4 class="font-semibold text-[#5D4037] mb-2">Detail Item:</h4>
                                    {{-- INI BAGIAN YANG DIPERBAIKI --}}
                                    <ul class="space-y-1 text-sm text-[#3E2723]">
                                        @foreach($order->details as $detail)
                                            <li class="flex justify-between">
                                                <span>
                                                    {{ $detail->product->name }} 
                                                    <span class="text-gray-500">({{ $detail->quantity }}x)</span>
                                                </span>
                                                <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="mt-4">
                                        <p class="text-sm text-[#5D4037]"><span class="font-semibold">No. Meja:</span> {{ $order->table_number }}</p>
                                        @if($order->notes)
                                        <p class="text-sm text-[#5D4037] mt-1"><span class="font-semibold">Catatan:</span> {{ $order->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-[#5D4037] py-8">Anda belum memiliki riwayat pesanan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
