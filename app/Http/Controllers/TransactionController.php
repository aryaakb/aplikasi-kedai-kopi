<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index()
    {
        // Memuat relasi 'user' dan 'details.product' untuk menampilkan detail
        $pendingOrders = Transaction::with('user', 'details.product')
                                    ->where('status', 'pending')
                                    ->orderBy('created_at', 'asc')
                                    ->get();

        $inProgressOrders = Transaction::with('user', 'details.product')
                                    ->where('status', 'in_progress')
                                    ->orderBy('created_at', 'asc')
                                    ->get();

        // Ambil semua produk dan urutkan berdasarkan nama
        $products = Product::orderBy('name', 'asc')->get();
        $cart = session()->get('cart', []);
        
        return view('transactions.index', compact('products', 'cart', 'pendingOrders', 'inProgressOrders'));
    }

    public function confirmOrder(Transaction $transaction)
    {
        if ($transaction->status === 'pending') {
            $transaction->status = 'in_progress';
            $transaction->save();
            return redirect()->back()->with('success', "Pesanan #{$transaction->id} berhasil dikonfirmasi.");
        }
        return redirect()->back()->with('error', 'Pesanan ini tidak dapat dikonfirmasi.');
    }

    /**
     * Method baru untuk membatalkan pesanan.
     */
    public function cancelOrder(Transaction $transaction)
    {
        if ($transaction->status === 'pending' || $transaction->status === 'in_progress') {
            try {
                DB::beginTransaction();

                // Kembalikan stok produk ke semula
                foreach ($transaction->details as $detail) {
                    $product = Product::find($detail->product_id);
                    if ($product) {
                        $product->stock += $detail->quantity;
                        $product->save();
                    }
                }

                // Ubah status transaksi menjadi 'canceled'
                $transaction->status = 'canceled';
                $transaction->save();

                DB::commit();
                return redirect()->back()->with('success', "Pesanan #{$transaction->id} berhasil dibatalkan.");

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Gagal membatalkan pesanan.');
            }
        }
        return redirect()->back()->with('error', 'Pesanan yang sudah selesai atau dibayar tidak dapat dibatalkan.');
    }

    public function loadOrder(Transaction $transaction)
    {
        if ($transaction->status !== 'in_progress') {
            return redirect()->route('transactions.index')->with('error', 'Hanya pesanan yang sedang diproses yang bisa dibayar.');
        }
        session()->forget('cart');
        $cart = [];
        foreach ($transaction->details as $detail) {
            $cart[$detail->product_id] = [
                "name" => $detail->product->name,
                "price" => $detail->product->price,
                "quantity" => $detail->quantity
            ];
        }
        session()->put('processing_transaction_id', $transaction->id);
        session()->put('order_notes', $transaction->notes); // Menyimpan catatan pesanan
        session()->put('cart', $cart);
        return redirect()->route('transactions.index');
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);
        if ($product->stock <= 0 || (isset($cart[$product->id]) && $cart[$product->id]['quantity'] >= $product->stock)) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi!');
        }
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = ["name" => $product->name, "price" => $product->price, "quantity" => 1];
        }
        session()->put('cart', $cart);
        return redirect()->back();
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        unset($cart[$request->product_id]);
        session()->put('cart', $cart);
        return redirect()->back();
    }

    public function complete(Request $request)
    {
        $request->validate(['paid_amount' => 'required|numeric|min:0']);
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('transactions.index')->with('error', 'Keranjang kosong!');
        }
        $total = array_reduce($cart, fn($carry, $item) => $carry + $item['price'] * $item['quantity'], 0);
        if ($request->paid_amount < $total) {
            return redirect()->back()->with('error', 'Uang yang dibayarkan tidak mencukupi.');
        }
        try {
            DB::beginTransaction();
            $processingId = session()->get('processing_transaction_id');
            $transaction = null;
            if ($processingId) {
                $transaction = Transaction::findOrFail($processingId);
                $transaction->update(['status' => 'paid', 'paid_amount' => $request->paid_amount]);
            } else {
                $transaction = Transaction::create([
                    'user_id' => Auth::id(), 'total' => $total,
                    'paid_amount' => $request->paid_amount, 'status' => 'paid',
                    'notes' => session('order_notes')
                ]);
                foreach ($cart as $id => $item) {
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id, 'product_id' => $id,
                        'quantity' => $item['quantity'], 'subtotal' => $item['price'] * $item['quantity']
                    ]);
                }
            }
            DB::commit();
            session()->forget(['cart', 'processing_transaction_id', 'order_notes']);
            return redirect()->route('transactions.success', ['id' => $transaction->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transactions.index')->with('error', 'Terjadi kesalahan saat memproses transaksi.');
        }
    }

    public function success($id)
    {
        $transaction = Transaction::with('details.product', 'user')->findOrFail($id);
        return view('transactions.success', compact('transaction'));
    }

    public function receipt(Request $request, $id)
    {
        $transaction = Transaction::with('details.product', 'user')->findOrFail($id);
        $paid_amount = $transaction->paid_amount;
        $change = $paid_amount - $transaction->total;
        $pdf = PDF::loadView('layouts.receipt', compact('transaction', 'paid_amount', 'change'));
        if ($request->has('stream')) {
            return $pdf->stream('receipt-'.$transaction->id.'.pdf');
        }
        return $pdf->download('receipt-'.$transaction->id.'.pdf');
    }
}
