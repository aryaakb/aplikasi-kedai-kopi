# Arpul – Sistem Manajemen Kedai Kopi

Aplikasi web berbasis Laravel 12 dengan role-based authentication untuk mengelola produk, transaksi, dan laporan operasional kedai kopi secara efisien.

---

## Daftar Isi

1. [Deskripsi](#deskripsi)  
2. [Fitur Utama](#fitur-utama)  
3. [Teknologi](#teknologi)  
4. [Prasyarat](#prasyarat)  
5. [Instalasi](#instalasi)  
6. [Menjalankan Aplikasi](#menjalankan-aplikasi)  
7. [Akun Default](#akun-default)  
8. [Struktur Database](#struktur-database)  
9. [Role & Permissions](#role--permissions)  
10. [Testing](#testing)  
11. [Deployment](#deployment)  
12. [Contributing](#contributing)  
13. [License](#license)  

---

## Deskripsi

Arpul adalah sistem manajemen kedai kopi berbasis web.  

Dengan antarmuka yang bersih dan terstruktur, Arpul mendukung tiga peran utama—Admin, Kasir, dan Member—untuk menjalankan operasi mulai dari manajemen produk hingga pemrosesan transaksi dan pembuatan laporan.

---

## Fitur Utama

### Admin
- CRUD produk lengkap dengan foto, kategori, stok, dan deskripsi  
- Laporan penjualan dengan filter tanggal dan ekspor PDF  
- Dashboard analitik real-time untuk memantau performa bisnis  

### Kasir
- Point of Sales (POS) interaktif untuk proses checkout cepat  
- Manajemen pesanan: konfirmasi, pembatalan, dan antrian order  
- Keranjang belanja otomatis menghitung subtotal  
- Struk digital dalam format PDF  

### Member/Pelanggan
- Menu digital dengan gambar, deskripsi, dan harga  
- Pemesanan online langsung dari aplikasi  
- Riwayat pesanan dan status pembayaran  
- Manajemen profil dan pengaturan akun  

---

## Teknologi

- Backend: Laravel 12 (PHP ≥ 8.2)  
- Frontend: Blade Templates + Tailwind CSS  
- Database: SQLite (dev) & MySQL (prod)  
- Authentication: Laravel Breeze  
- PDF Generation: DomPDF  
- Build Tools: Vite + npm  

---

## Prasyarat

- PHP 8.2 atau lebih tinggi  
- Composer  
- Node.js & npm  
- Ekstensi PHP untuk SQLite/MySQL  

---

## Instalasi

1. Clone repositori  
   ```bash
   git clone <repository-url>
   cd arpul-coffee
   ```

2. Install dependencies PHP dan Node  
   ```bash
   composer install
   npm install
   ```

3. Salin konfigurasi dan generate application key  
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Siapkan database SQLite dan migrasi + seeder  
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

5. Buat symbolic link untuk storage  
   ```bash
   php artisan storage:link
   ```

6. Build asset untuk produksi  
   ```bash
   npm run build
   ```

---

## Menjalankan Aplikasi

### Development Mode
```bash
php artisan serve
npm run dev
php artisan queue:work      # opsional, untuk queue worker
```

### Production Mode
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

---

## Akun Default

Setelah `php artisan migrate --seed`, tiga akun berikut dibuat otomatis jika belum ada:

| Role   | Nama         | Email               | Password   |
|--------|--------------|---------------------|------------|
| Admin  | Admin Arpul  | admin@arpul.com     | admin123   |
| Kasir  | Kasir Arpul  | kasir@arpul.com     | kasir123   |
| Member | Demo Member  | member@arpul.com    | member123  |

Seeder file: `database/seeders/AdminUserSeeder.php`

---

## Struktur Database

### products
- id, name, category, description, price, stock, image_path, timestamps  

### transactions
- id, user_id, total_amount, status, payment_method, created_at, updated_at  

### transaction_details
- id, transaction_id, product_id, quantity, unit_price, subtotal, timestamps  

### users
- id, name, email, password, role, is_active, email_verified_at, timestamps  

---

## Role & Permissions

| Fitur            | Admin | Kasir | Member |
|------------------|:-----:|:-----:|:------:|
| Dashboard        |   ✅   |   ✅   |   ✅    |
| Kelola Produk    |   ✅   |   ❌   |   ❌    |
| Lihat Laporan    |   ✅   |   ❌   |   ❌    |
| POS/Transaksi    |   ❌   |   ✅   |   ❌    |
| Order Menu       |   ❌   |   ❌   |   ✅    |
| Riwayat Pesanan  |   ❌   |   ❌   |   ✅    |

---

## Testing

Jalankan seluruh test suite:
```bash
php artisan test
```

---

## Deployment

1. Set environment ke production  
2. Optimasi konfigurasi dan cache  
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```  
3. Arahkan web server (Apache/Nginx) ke folder `public/`

## License

Project ini dilisensikan di bawah MIT License. Lihat [LICENSE](LICENSE) untuk detail.
