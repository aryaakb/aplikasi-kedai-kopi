# No F*cking Coffee - Coffee Shop Management System

Aplikasi manajemen kedai kopi berbasis web yang dibangun menggunakan Laravel 12 dengan sistem role-based authentication untuk mengelola operasional kedai kopi secara efisien.

## 🚀 Fitur Utama

### 👑 Admin
- **Manajemen Produk**: CRUD produk lengkap dengan foto, kategori, dan stok
- **Laporan Penjualan**: Analisis pendapatan dengan filter tanggal
- **Export Laporan**: Generate laporan PDF untuk keperluan akuntansi
- **Dashboard Analitik**: Overview performa bisnis

### 👨‍💼 Kasir
- **Point of Sales (POS)**: Interface penjualan yang user-friendly
- **Manajemen Pesanan**: Konfirmasi dan pembatalan pesanan pelanggan
- **Cart System**: Sistem keranjang belanja dengan kalkulasi otomatis
- **Struk Digital**: Generate receipt/struk untuk pelanggan
- **Order Queue**: Antrian pesanan real-time

### 👤 Member/Pelanggan
- **Menu Digital**: Browse menu dengan gambar dan deskripsi
- **Order Online**: Pemesanan langsung dari aplikasi
- **Riwayat Pesanan**: Tracking order history
- **Profile Management**: Kelola data pribadi

## 🛠️ Teknologi Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade Templates + Tailwind CSS
- **Database**: SQLite (Development)
- **Authentication**: Laravel Breeze
- **PDF Generation**: DomPDF
- **Build Tools**: Vite

## 📋 Prerequisites

- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & NPM
- SQLite extension untuk PHP

## 🚀 Instalasi

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd nofvcking-coffee
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

5. **Storage Link**
   ```bash
   php artisan storage:link
   ```

6. **Build Assets**
   ```bash
   npm run build
   ```

## 🏃‍♂️ Menjalankan Aplikasi

### Development Mode
```bash
composer run dev
```
Atau secara manual:
```bash
# Terminal 1 - Laravel Server
php artisan serve

# Terminal 2 - Queue Worker
php artisan queue:listen

# Terminal 3 - Logs
php artisan pail

# Terminal 4 - Vite
npm run dev
```

### Production Mode
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

## 👥 Default Users

Setelah seeding, tersedia user default:

- **Admin**: admin@coffee.com
- **Kasir**: cashier@coffee.com  
- **Member**: member@coffee.com

*Password default: `password`*

## 📁 Struktur Database

### Products
- ID, Name, Category, Description, Price, Stock
- Image upload & URL support
- Timestamps

### Transactions  
- ID, User, Total, Status, Payment info
- Order number generation
- Paid amount tracking

### Transaction Details
- Product details per transaction
- Quantity & price tracking
- Subtotal calculation

### Users
- Standard Laravel auth fields
- Role-based access (admin/cashier/member)

## 🔐 Role & Permissions

| Fitur | Admin | Kasir | Member |
|-------|-------|-------|--------|
| Dashboard | ✅ | ✅ | ✅ |
| Kelola Produk | ✅ | ❌ | ❌ |
| Laporan | ✅ | ❌ | ❌ |
| POS/Transaksi | ❌ | ✅ | ❌ |
| Order Menu | ❌ | ❌ | ✅ |
| Riwayat Order | ❌ | ❌ | ✅ |

## 🧪 Testing

```bash
php artisan test
```

## 📝 API Endpoints

### Debug/Testing Routes
- `/debug` - Debug information
- `/auto-login-admin` - Auto login sebagai admin (development only)
- `/fresh-products` - Test products display
- `/fresh-reports` - Test reports display

## 🚀 Deployment

1. Set environment ke production
2. Optimize aplikasi:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
3. Set web server (Apache/Nginx) ke folder `public/`

## 🤝 Contributing

1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 License

Project ini menggunakan [MIT License](https://opensource.org/licenses/MIT).

## 📞 Support

Untuk pertanyaan atau bantuan, silakan buat issue di repository ini.

---

*Dibuat dengan ❤️ untuk mendigitalkan operasional kedai kopi*