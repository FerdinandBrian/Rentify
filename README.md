# 🚗 Rentify - Aplikasi Penyewaan Mobil

Rentify adalah aplikasi manajemen penyewaan mobil berbasis web yang dibangun dengan framework **Laravel 12**, **Tailwind CSS**, dan **Alpine.js** (menggunakan Laravel Breeze). Proyek ini dirancang untuk memudahkan manajemen rental mobil bagi admin, karyawan (employee), dan pelanggan (customer).

---

## 🛠️ Prasyarat (Prerequisites)

Sebelum menjalankan proyek ini, pastikan perangkat Anda telah terpasang:
- **PHP** (Minimal versi 8.2)
- **Composer** (Untuk mengelola dependency PHP)
- **Node.js & NPM** (Untuk mengelola dependency frontend & compile asset)
- **MySQL / MariaDB** (Sebagai database server)
- **Git** (Untuk clone repositori)

---

## 🚀 Langkah-Langkah Instalasi & Penjalanan

Ikuti panduan berikut langkah-demi-langkah untuk menjalankan aplikasi Rentify di lingkungan lokal Anda.

### 1. Clone Repositori
Clone proyek ini ke komputer lokal Anda menggunakan Git:
```bash
git clone https://github.com/FerdinandBrian/Rentify.git
cd Rentify
```

### 2. Salin dan Sesuaikan Konfigurasi Environment (`.env`)
Salin file konfigurasi template `.env.example` menjadi `.env`:
- **Windows (PowerShell/CMD):**
  ```powershell
  copy .env.example .env
  ```
- **Linux / macOS:**
  ```bash
  cp .env.example .env
  ```

Buka file `.env` di text editor Anda, lalu sesuaikan konfigurasi database berikut dengan server database lokal Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pdpl_tugasbesar
DB_USERNAME=username_database_anda
DB_PASSWORD=password_database_anda
```
*Catatan: Pastikan Anda telah membuat database kosong di MySQL dengan nama `pdpl_tugasbesar` (atau nama lain sesuai isian `DB_DATABASE`).*

Lalu sesuaikan juga konfigurasi **email SMTP** agar fitur OTP bisa mengirim email:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email-gmail-anda@gmail.com
MAIL_PASSWORD=app-password-gmail-anda
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="email-gmail-anda@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
```
*Catatan: `MAIL_PASSWORD` harus menggunakan **App Password** dari Google, bukan password Gmail biasa. Buat di: https://myaccount.google.com/apppasswords*

### 3. Install Dependency PHP
Jalankan perintah berikut untuk mengunduh semua library PHP yang dibutuhkan oleh Laravel:
```bash
composer install
```

### 4. Generate Application Key
Generate key keamanan untuk aplikasi Anda:
```bash
php artisan key:generate
```

### 5. Jalankan Migrasi Database dan Seeders
Jalankan migrasi untuk membuat tabel-tabel di database serta mengisinya dengan data uji coba awal (roles, users, data mobil, dll.):
```bash
php artisan migrate --seed
```

### 6. Install Dependency Frontend (NPM)
Jalankan perintah ini untuk menginstal semua library frontend (Tailwind CSS, Alpine.js, Vite, dll.):
```bash
npm install
```

---

## 🖥️ Menjalankan Aplikasi di Lingkungan Lokal

Ada dua cara untuk menjalankan server lokal dan kompilasi asset:

### Metode A: Menjalankan Perintah Terpisah (Standard)
Buka **dua terminal terpisah**:

*   **Terminal 1:** Jalankan Laravel backend server
    ```bash
    php artisan serve
    ```
    Aplikasi Anda akan berjalan di `http://127.0.0.1:8000` atau `http://localhost:8000`.

*   **Terminal 2:** Jalankan Vite development server untuk asset css dan js
    ```bash
    npm run dev
    ```

---

### Metode B: Menggunakan Shortcut Composer (Direkomendasikan)
Di proyek ini sudah dikonfigurasi perintah kustom di dalam `composer.json`. Anda cukup menjalankan **satu perintah** berikut untuk menjalankan seluruh proses backend, database queue, log, serta Vite server secara bersamaan:
```bash
composer run dev
```
