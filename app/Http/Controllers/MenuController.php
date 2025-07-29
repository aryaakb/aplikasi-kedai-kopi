<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Menggunakan Auth Facade

class MenuController extends Controller
{
    /**
     * Menampilkan halaman menu produk untuk member.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        $cart = session()->get('member_cart', []);
        return view('menu.index', compact('products', 'cart'));
    }

    /**
     * Menambahkan produk ke keranjang belanja member.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('member_cart', []);

        // Validasi stok sebelum menambahkan
        if ($product->stock <= 0 || (isset($cart[$product->id]) && $cart[$product->id]['quantity'] >= $product->stock)) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi!');
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1,
                "image_url" => $product->image_url,
            ];
        }

        session()->put('member_cart', $cart);
        return redirect()->back();
    }

    /**
     * Menghapus produk dari keranjang belanja member.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeFromCart(Request $request)
    {
        $cart = session()->get('member_cart', []);
        unset($cart[$request->product_id]);
        session()->put('member_cart', $cart);
        return redirect()->back();
    }

    /**
     * Menyimpan pesanan dari member ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'table_number' => 'required|string|max:50',
            'notes' => 'nullable|string|max:255',
        ]);

        $cart = session()->get('member_cart', []);
        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang Anda kosong!');
        }

        $total = array_reduce($cart, fn($carry, $item) => $carry + $item['price'] * $item['quantity'], 0);

        try {
            DB::beginTransaction();

            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'paid_amount' => 0, // Pembayaran akan dilakukan di kasir
                'status' => 'pending', // Status pesanan baru adalah 'pending'
                'table_number' => $request->table_number,
                'notes' => $request->notes,
            ]);

            foreach ($cart as $id => $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity']
                ]);

                // Mengurangi stok produk
                $product = Product::find($id);
                $product->stock -= $item['quantity'];
                $product->save();
            }

            DB::commit();
            session()->forget('member_cart');

            return redirect()->route('orders.index')->with('success', 'Pesanan Anda berhasil dibuat dan sedang diproses!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Optional: Log the error for debugging
            // Log::error('Order placement failed: ' . $e->getMessage());
            return redirect()->route('menu.index')->with('error', 'Terjadi kesalahan, pesanan Anda gagal dibuat.');
        }
    }

    /**
     * Menampilkan halaman riwayat pesanan untuk member yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function myOrders()
    {
        $orders = Transaction::with('details.product') // Memuat relasi untuk menampilkan detail item
                             ->where('user_id', Auth::id())
                             ->orderBy('created_at', 'desc')
                             ->get();

        return view('menu.my-orders', compact('orders'));
    }
}
