<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class ProdukService
{
    /**
     * Mendapatkan semua kategori unik dari produk.
     *
     * @return SupportCollection
     */
    public function dapatkanKategori(): SupportCollection
    {
        return Product::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->orderBy('category')
            ->pluck('category');
    }

    /**
     * Mencari produk berdasarkan parameter yang diberikan.
     *
     * @param Request $request
     * @return Collection
     */
    public function cariProduk(Request $request): Collection
    {
        $query = Product::query();

        // Pencarian berdasarkan nama atau deskripsi
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', $searchTerm)
                  ->orWhere('description', 'LIKE', $searchTerm);
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Pengurutan
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        
        $allowedSorts = ['name', 'price', 'created_at', 'stock', 'category'];
        
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('name', 'asc');
        }

        Log::info('Pencarian produk dilakukan', [
            'search' => $request->search,
            'category' => $request->category,
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder
        ]);

        return $query->get();
    }

    /**
     * Menyimpan produk baru.
     *
     * @param array $data
     * @return Product
     * @throws Exception
     */
    public function simpanProduk(array $data): Product
    {
        try {
            // Proses upload gambar jika ada
            if (isset($data['image']) && $data['image']) {
                $data['image'] = $this->prosesUploadGambar($data['image']);
            }

            $produk = Product::create($data);
            
            Log::info('Produk baru berhasil disimpan', [
                'product_id' => $produk->id,
                'name' => $produk->name,
                'category' => $produk->category
            ]);

            return $produk;
        } catch (Exception $e) {
            Log::error('Gagal menyimpan produk', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            throw new Exception('Gagal menyimpan produk: ' . $e->getMessage());
        }
    }

    /**
     * Memperbarui data produk.
     *
     * @param Product $produk
     * @param array $data
     * @return Product
     * @throws Exception
     */
    public function perbaruiProduk(Product $produk, array $data): Product
    {
        try {
            // Proses upload gambar baru jika ada
            if (isset($data['image']) && $data['image']) {
                // Hapus gambar lama jika ada
                if ($produk->image) {
                    $this->hapusGambar($produk->image);
                }
                $data['image'] = $this->prosesUploadGambar($data['image']);
            }

            $produk->update($data);
            
            Log::info('Produk berhasil diperbarui', [
                'product_id' => $produk->id,
                'name' => $produk->name,
                'changes' => $produk->getChanges()
            ]);

            return $produk->fresh();
        } catch (Exception $e) {
            Log::error('Gagal memperbarui produk', [
                'product_id' => $produk->id,
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            throw new Exception('Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus produk.
     *
     * @param Product $produk
     * @return bool
     * @throws Exception
     */
    public function hapusProduk(Product $produk): bool
    {
        try {
            // Hapus gambar jika ada
            if ($produk->image) {
                $this->hapusGambar($produk->image);
            }

            $produkId = $produk->id;
            $produkNama = $produk->name;
            
            $hasil = $produk->delete();
            
            Log::info('Produk berhasil dihapus', [
                'product_id' => $produkId,
                'name' => $produkNama
            ]);

            return $hasil;
        } catch (Exception $e) {
            Log::error('Gagal menghapus produk', [
                'product_id' => $produk->id,
                'error' => $e->getMessage()
            ]);
            throw new Exception('Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    /**
     * Memproses upload gambar produk.
     *
     * @param mixed $file
     * @return string
     * @throws Exception
     */
    private function prosesUploadGambar($file): string
    {
        try {
            $path = $file->store('produk', 'public');
            
            if (!$path) {
                throw new Exception('Gagal menyimpan file gambar');
            }

            return $path;
        } catch (Exception $e) {
            Log::error('Gagal upload gambar', ['error' => $e->getMessage()]);
            throw new Exception('Gagal mengupload gambar: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus file gambar dari storage.
     *
     * @param string $path
     * @return bool
     */
    private function hapusGambar(string $path): bool
    {
        try {
            return Storage::disk('public')->delete($path);
        } catch (Exception $e) {
            Log::warning('Gagal menghapus gambar', [
                'path' => $path,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Mendapatkan statistik produk.
     *
     * @return array
     */
    public function dapatkanStatistikProduk(): array
    {
        return [
            'total_produk' => Product::count(),
            'total_kategori' => Product::distinct('category')->count('category'),
            'produk_stok_habis' => Product::where('stock', 0)->count(),
            'produk_stok_rendah' => Product::where('stock', '>', 0)->where('stock', '<=', 10)->count(),
            'nilai_total_stok' => Product::selectRaw('SUM(price * stock) as total')->value('total') ?? 0
        ];
    }
}