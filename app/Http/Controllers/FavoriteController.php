<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $favorites = $user->favoriteProducts()->with(['favorites'])->paginate(12);
        
        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Product $product)
    {
        $user = Auth::user();
        
        $favorite = Favorite::where('user_id', $user->id)
                           ->where('product_id', $product->id)
                           ->first();
        
        if ($favorite) {
            $favorite->delete();
            $status = 'removed';
            $message = 'Produk dihapus dari favorit';
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $status = 'added';
            $message = 'Produk ditambahkan ke favorit';
        }
        
        if (request()->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'favorites_count' => $product->favoritesCount()
            ]);
        }
        
        return back()->with('success', $message);
    }

    public function add(Product $product)
    {
        $user = Auth::user();
        
        $exists = Favorite::where('user_id', $user->id)
                         ->where('product_id', $product->id)
                         ->exists();
        
        if (!$exists) {
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            
            $message = 'Produk ditambahkan ke favorit';
        } else {
            $message = 'Produk sudah ada di favorit';
        }
        
        if (request()->ajax()) {
            return response()->json([
                'status' => !$exists ? 'added' : 'exists',
                'message' => $message,
                'favorites_count' => $product->favoritesCount()
            ]);
        }
        
        return back()->with('success', $message);
    }

    public function remove(Product $product)
    {
        $user = Auth::user();
        
        $favorite = Favorite::where('user_id', $user->id)
                           ->where('product_id', $product->id)
                           ->first();
        
        if ($favorite) {
            $favorite->delete();
            $message = 'Produk dihapus dari favorit';
            $status = 'removed';
        } else {
            $message = 'Produk tidak ada di favorit';
            $status = 'not_found';
        }
        
        if (request()->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'favorites_count' => $product->favoritesCount()
            ]);
        }
        
        return back()->with('success', $message);
    }
}