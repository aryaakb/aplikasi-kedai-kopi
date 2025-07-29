<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-stone-800 leading-tight">
            {{ __('Transaksi Berhasil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-green-600 mb-4">Pembayaran Berhasil!</h3>
                        <p class="text-gray-600">Transaksi dengan ID #{{ $transaction->id }} telah berhasil diproses.</p>
                        <div class="mt-6">
                            <a href="{{ route('transactions.receipt', ['id' => $transaction->id, 'stream' => true]) }}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Cetak Struk
                            </a>
                            <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Kembali ke Transaksi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>