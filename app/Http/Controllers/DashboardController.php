<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the appropriate dashboard based on user role.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();

        if ($user->role === 'admin' || $user->role === 'cashier') {
            // Logika untuk dashboard Admin & Kasir
            $totalProducts = Product::count();
            $todaySales = Transaction::whereDate('created_at', Carbon::today())->sum('total');
            $totalTransactions = Transaction::count();

            return view('dashboard', compact('totalProducts', 'todaySales', 'totalTransactions'));

        } elseif ($user->role === 'member') {
            // Arahkan member ke halaman menu mereka
            return redirect()->route('menu.index');
        }

        // Fallback default, jika peran tidak dikenali
        return view('dashboard');
    }
}
