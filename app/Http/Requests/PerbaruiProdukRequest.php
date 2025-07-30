<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PerbaruiProdukRequest extends FormRequest
{
    /**
     * Menentukan apakah pengguna diotorisasi untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Mendapatkan aturan validasi yang berlaku untuk permintaan ini.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product')->id ?? null;
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')->ignore($productId)
            ],
            'category' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:1000|max:1000000',
            'stock' => 'required|integer|min:0|max:9999',
            'image_url' => 'nullable|url|max:500',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,bmp,tiff,svg,webp,ico,heic,heif|max:5120'
        ];
    }

    /**
     * Mendapatkan pesan kesalahan kustom untuk aturan validasi.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'name.unique' => 'Nama produk sudah ada, gunakan nama lain.',
            'category.required' => 'Kategori produk wajib dipilih.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.min' => 'Harga minimum adalah Rp 1.000.',
            'price.max' => 'Harga maksimum adalah Rp 1.000.000.',
            'stock.required' => 'Stok produk wajib diisi.',
            'stock.min' => 'Stok tidak boleh negatif.',
            'stock.max' => 'Stok maksimum adalah 9999.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diizinkan: jpeg, png, jpg, gif, bmp, tiff, svg, webp, ico, heic, heif.',  
            'image.max' => 'Ukuran gambar maksimum 5MB.',
            'image_url.url' => 'URL gambar tidak valid.'
        ];
    }

    /**
     * Mendapatkan nama atribut kustom untuk validasi.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama produk',
            'category' => 'kategori',
            'description' => 'deskripsi',
            'price' => 'harga',
            'stock' => 'stok',
            'image_url' => 'URL gambar',
            'image' => 'gambar'
        ];
    }
}
