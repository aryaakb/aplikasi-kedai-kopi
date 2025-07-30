<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Kolom yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category', 
        'description',
        'price',
        'stock',
        'image',
        'image_url'
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Atribut yang akan disembunyikan untuk serialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Atribut yang akan ditambahkan ke serialisasi.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'gambar_url',
        'harga_format',
        'status_stok',
        'nama_slug'
    ];

    /**
     * Mendapatkan URL gambar produk dengan prioritas.
     * 
     * @return Attribute
     */
    protected function gambarUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Prioritas: image_url dari database, lalu image upload, lalu default
                if (!empty($this->attributes['image_url'])) {
                    return $this->attributes['image_url'];
                }
                
                if (!empty($this->image) && Storage::disk('public')->exists($this->image)) {
                    return asset('storage/' . $this->image);
                }
                
                return asset('images/default-product.jpg');
            }
        );
    }

    /**
     * Mendapatkan harga dalam format Rupiah.
     *
     * @return Attribute
     */
    protected function hargaFormat(): Attribute
    {
        return Attribute::make(
            get: function () {
                return 'Rp ' . number_format($this->price, 0, ',', '.');
            }
        );
    }

    /**
     * Mendapatkan status stok produk.
     *
     * @return Attribute
     */
    protected function statusStok(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->stock == 0) {
                    return 'Habis';
                } elseif ($this->stock <= 10) {
                    return 'Rendah';
                } elseif ($this->stock <= 50) {
                    return 'Normal';
                } else {
                    return 'Banyak';
                }
            }
        );
    }

    /**
     * Mendapatkan slug dari nama produk.
     *
     * @return Attribute
     */
    protected function namaSlug(): Attribute
    {
        return Attribute::make(
            get: function () {
                return \Illuminate\Support\Str::slug($this->name);
            }
        );
    }

    /**
     * Scope untuk mencari produk berdasarkan nama atau deskripsi.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCari($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhere('category', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope untuk filter berdasarkan kategori.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $category
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeKategori($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope untuk produk yang tersedia (stok > 0).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTersedia($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope untuk produk dengan stok rendah.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $batas
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStokRendah($query, $batas = 10)
    {
        return $query->where('stock', '>', 0)->where('stock', '<=', $batas);
    }

    /**
     * Scope untuk produk yang habis stok.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStokHabis($query)
    {
        return $query->where('stock', 0);
    }

    /**
     * Relasi ke tabel transaction_details.
     */
    public function detailTransaksi()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Mengecek apakah produk tersedia untuk dibeli.
     *
     * @param int $jumlah
     * @return bool
     */
    public function tersedia($jumlah = 1): bool
    {
        return $this->stock >= $jumlah;
    }

    /**
     * Mengurangi stok produk.
     *
     * @param int $jumlah
     * @return bool
     */
    public function kurangiStok($jumlah): bool
    {
        if (!$this->tersedia($jumlah)) {
            return false;
        }

        $this->decrement('stock', $jumlah);
        return true;
    }

    /**
     * Menambah stok produk.
     *
     * @param int $jumlah
     * @return bool
     */
    public function tambahStok($jumlah): bool
    {
        $this->increment('stock', $jumlah);
        return true;
    }

    /**
     * Mendapatkan total penjualan produk.
     *
     * @return int
     */
    public function totalTerjual(): int
    {
        return $this->detailTransaksi()->sum('quantity') ?? 0;
    }

    /**
     * Mendapatkan pendapatan dari produk ini.
     *
     * @return float
     */
    public function totalPendapatan(): float
    {
        return $this->detailTransaksi()->sum('subtotal') ?? 0;
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function favoritesCount(): int
    {
        return $this->favorites()->count();
    }
}