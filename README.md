# API Perpustakaan 📚

## Judul Proyek
API Perpustakaan (Web Service Manajemen Perpustakaan)

## Deskripsi Singkat
API Perpustakaan adalah web service berbasis **Laravel** yang digunakan untuk mengelola data perpustakaan, seperti data buku, kategori, peminjaman, dan pengguna.  
API ini dibuat untuk mendukung aplikasi frontend atau client lain dengan konsep **REST API**.

---

## Cara Menjalankan Sistem

Ikuti langkah-langkah berikut untuk menjalankan project ini di lokal:

### 1. Clone Repository
```bash
git clone https://github.com/AbiyyuNMS/api_perpustakaan.git
cd api_perpustakaan
code . (untuk langsung membuka project menggunakan VS Code)
```

### 2. Install Dependency
Pastikan **Composer** sudah terinstall, lalu jalankan:
```bash / terminal
composer install
```

### 3. Konfigurasi File `.env`
- Salin file `.env.example` menjadi `.env`
```bash / terminal
cp .env.example .env
```

- Atur konfigurasi database di file `.env`
```env
DB_DATABASE=api_perpustakaan
DB_USERNAME=root
```

### 4. Generate Application Key
```bash / terminal
php artisan key:generate
```

### 5. Migrasi Database
```bash / terminal
php artisan migrate
```

### 6. Menjalankan Server
```bash / terminal
php artisan serve
```

Aplikasi akan berjalan di:
```
http://127.0.0.1:8000
```

---

## Dokumentasi API
Dokumentasi API berisi daftar endpoint, method, parameter, dan contoh response.

- **Postman Collection**  
  [Link Dokumentasi POSTMAN](https://documenter.getpostman.com/view/41346794/2sBXVfir7o)


Contoh endpoint API:
- `POST /api/login`
- `GET /api/books`
- `POST /api/books`
- `GET /api/categories`
- `POST /api/loans`

---

## Teknologi yang Digunakan
- PHP 8+
- Laravel Framework
- MySQL
- REST API

---