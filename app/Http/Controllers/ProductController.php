<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk dengan search, filter, dan sort.
     */
    public function index(Request $request)
    {
        $query = Product::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('description', 'LIKE', '%' . $request->search . '%');
        }
        
        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }
        
        // Sorting functionality
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        
        $allowedSorts = ['name', 'price', 'created_at', 'stock'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('name', 'asc');
        }
        
        $products = $query->get();
        $categories = Product::select('category')->distinct()->pluck('category');
        
        // Debug log untuk memastikan data ada
        \Log::info('ProductController@index called. Products count: ' . $products->count());
        
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        // Mengambil semua kategori yang unik dari database untuk dropdown
        $categories = Product::select('category')->distinct()->pluck('category');
        
        // Mengirim data kategori ke view
        return view('products.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        
        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Menampilkan detail dari satu produk.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function edit(Product $product)
    {
        // Mengambil semua kategori yang unik dari database untuk dropdown
        $categories = Product::select('category')->distinct()->pluck('category');
        
        // Mengirim data produk dan kategori ke view
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Memperbarui data produk di database.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        
        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}
