<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\SimpanProdukRequest;
use App\Http\Requests\PerbaruiProdukRequest;
use App\Services\ProdukService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Exception;

class ProductController extends Controller
{
    protected ProdukService $produkService;

    public function __construct(ProdukService $produkService)
    {
        $this->produkService = $produkService;
    }

    /**
     * Menampilkan daftar semua produk dengan pencarian, filter, dan pengurutan.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        try {
            $products = $this->produkService->cariProduk($request);
            $categories = $this->produkService->dapatkanKategori();
            $statistik = $this->produkService->dapatkanStatistikProduk();

            return view('products.index', compact('products', 'categories', 'statistik'));
        } catch (Exception $e) {
            Log::error('Gagal memuat halaman produk', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return view('products.index', [
                'products' => collect([]),
                'categories' => collect([]),
                'statistik' => []
            ])->with('error', 'Terjadi kesalahan saat memuat data produk.');
        }
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     *
     * @return View
     */
    public function create(): View
    {
        try {
            $categories = $this->produkService->dapatkanKategori();
            return view('products.create', compact('categories'));
        } catch (Exception $e) {
            Log::error('Gagal memuat form tambah produk', ['error' => $e->getMessage()]);
            
            return view('products.create', ['categories' => collect([])])
                ->with('error', 'Terjadi kesalahan saat memuat form.');
        }
    }

    /**
     * Menyimpan produk baru ke database.
     *
     * @param SimpanProdukRequest $request
     * @return RedirectResponse
     */
    public function store(SimpanProdukRequest $request): RedirectResponse
    {
        try {
            $this->produkService->simpanProduk($request->validated());
            
            return redirect()
                ->route('products.index')
                ->with('success', 'Produk berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error('Gagal menyimpan produk', [
                'error' => $e->getMessage(),
                'data' => $request->validated()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan produk. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan detail dari satu produk.
     *
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        try {
            return view('products.show', compact('product'));
        } catch (Exception $e) {
            Log::error('Gagal memuat detail produk', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->route('products.index')
                ->with('error', 'Terjadi kesalahan saat memuat detail produk.');
        }
    }

    /**
     * Menampilkan form untuk mengedit produk.
     *
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        try {
            $categories = $this->produkService->dapatkanKategori();
            return view('products.edit', compact('product', 'categories'));
        } catch (Exception $e) {
            Log::error('Gagal memuat form edit produk', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->route('products.index')
                ->with('error', 'Terjadi kesalahan saat memuat form edit.');
        }
    }

    /**
     * Memperbarui data produk di database.
     *
     * @param PerbaruiProdukRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(PerbaruiProdukRequest $request, Product $product): RedirectResponse
    {
        try {
            $this->produkService->perbaruiProduk($product, $request->validated());
            
            return redirect()
                ->route('products.index')
                ->with('success', 'Produk berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error('Gagal memperbarui produk', [
                'product_id' => $product->id,
                'error' => $e->getMessage(),
                'data' => $request->validated()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui produk. Silakan coba lagi.');
        }
    }

    /**
     * Menghapus produk dari database.
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            $this->produkService->hapusProduk($product);
            
            return redirect()
                ->route('admin.admin.products.index')
                ->with('success', 'Produk berhasil dihapus.');
        } catch (Exception $e) {
            Log::error('Gagal menghapus produk', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->route('admin.admin.products.index')
                ->with('error', 'Gagal menghapus produk. Silakan coba lagi.');
        }
    }
}
