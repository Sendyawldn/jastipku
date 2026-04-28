# JastipKu

JastipKu adalah aplikasi web **jasa titip** berbasis Laravel yang mempertemukan:
- **Penitip (customer)** untuk membuat pesanan barang.
- **Traveler** untuk menerima, memproses, dan menyelesaikan pesanan.
- **Admin** untuk mengelola data melalui panel Filament.

## Fitur Utama

### 1) Fitur Penitip (Customer)
- Registrasi/login akun.
- Membuat pesanan baru dengan detail barang, budget, destinasi, deadline, metode pembayaran, dan lampiran foto.
- Melihat, mengedit, membatalkan, serta melakukan reorder pesanan.
- Melihat invoice dan riwayat transaksi.
- Memberi rating/review ke traveler setelah pesanan selesai.

### 2) Fitur Traveler
- Melihat daftar pesanan aktif.
- Menerima pesanan, memulai proses, menyelesaikan, atau membatalkan pesanan.
- Melihat penghasilan dan riwayat penghasilan.
- Melakukan penarikan saldo (withdrawal).

### 3) Fitur Umum & Admin
- Landing page publik dengan daftar pesanan.
- Dashboard otomatis sesuai role setelah login.
- Manajemen user/order/traveler profile/withdrawal melalui **Filament Admin Panel**.

## Teknologi yang Digunakan
- **Backend:** PHP 8.1+, Laravel 10
- **Admin Panel:** Filament 3.3
- **Frontend Build Tool:** Vite
- **Frontend Library:** Alpine.js
- **Database:** MySQL/MariaDB (disarankan)

## Kebutuhan Sistem
- PHP >= 8.1
- Composer
- Node.js + npm
- Database server (MySQL/MariaDB)

## Instalasi

1. Clone repository
   ```bash
   git clone <url-repo-anda>
   cd jastipku
   ```

2. Install dependency PHP
   ```bash
   composer install
   ```

3. Install dependency frontend
   ```bash
   npm install
   ```

4. Copy file environment
   ```bash
   cp .env.example .env
   ```

5. Generate app key
   ```bash
   php artisan key:generate
   ```

6. Atur konfigurasi database di `.env`
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=jastipku
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. Jalankan migrasi
   ```bash
   php artisan migrate
   ```

8. (Opsional) jalankan seeder
   ```bash
   php artisan db:seed
   ```

9. Jalankan server aplikasi
   ```bash
   php artisan serve
   ```

10. Jalankan Vite untuk asset frontend
   ```bash
   npm run dev
   ```

Aplikasi akan tersedia di `http://127.0.0.1:8000`.

## Struktur Peran Pengguna
- `penitip` → pengguna yang membuat pesanan.
- `traveler` → pengguna yang menerima/menjalankan pesanan.
- `admin` → pengelola sistem dari panel admin.

## Rute Penting
- `/` : Landing page
- `/dashboard` : Redirect dashboard sesuai role
- `/customer/*` : Area penitip
- `/traveler/*` : Area traveler
- `/admin` : Panel admin Filament (default path)

## Menjalankan Testing
```bash
php artisan test
```

## Catatan Pengembangan
- Proyek ini menggunakan middleware role untuk pembatasan akses fitur.
- Fitur upload gambar produk disimpan pada storage disk `public`.
- Pastikan sudah menjalankan `php artisan storage:link` jika gambar tidak tampil.

## Lisensi
Proyek ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).
