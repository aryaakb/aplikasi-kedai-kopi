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

        if ($user->role === 'admin') {
            // Dashboard Admin - Full analytics dan management
            $totalProducts = Product::count();
            $totalUsers = \App\Models\User::count();
            $totalAdmins = \App\Models\User::where('role', 'admin')->count();
            $totalKasir = \App\Models\User::where('role', 'kasir')->count();
            $totalMembers = \App\Models\User::where('role', 'member')->count();
            $activeUsers = \App\Models\User::where('is_active', true)->count();
            $todaySales = 0; // Placeholder - would come from transactions
            $totalTransactions = 0; // Placeholder
            $totalNotifications = \App\Models\Notification::count();

            return view('admin.dashboard', compact(
                'totalProducts', 'totalUsers', 'totalAdmins', 'totalKasir', 
                'totalMembers', 'activeUsers', 'todaySales', 'totalTransactions', 'totalNotifications'
            ));

        } elseif ($user->role === 'kasir') {
            // Dashboard Kasir - POS focused
            $totalProducts = Product::count();
            $todaySales = 0; // Placeholder
            $todayTransactions = 0; // Placeholder
            $popularProducts = Product::take(5)->get(); // Placeholder

            return view('kasir.dashboard', compact(
                'totalProducts', 'todaySales', 'todayTransactions', 'popularProducts'
            ));

        } elseif ($user->role === 'member') {
            // Dashboard Member - Menu dan pesanan
            $recentOrders = []; // Placeholder - would come from user's orders
            $favoriteProducts = $user->favoriteProducts()->take(6)->get();
            $totalFavorites = $user->favoriteProducts()->count();
            
            return view('member.dashboard', compact('recentOrders', 'favoriteProducts', 'totalFavorites'));
        }

        // Fallback default
        return view('dashboard');
    }
}
