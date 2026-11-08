# UIS Grand Academic Challenge 🏆

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4.0-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

Aplikasi Web **Live Stage & Dashboard Manajemen Lomba Cerdas Cermat** untuk kegiatan **UIS Grand Academic Challenge** (Universitas Ibnu Sina). 

Sistem ini dirancang khusus untuk memfasilitasi jalannya kompetisi cerdas cermat secara interaktif, menampilkan *Layar Panggung (Live Stage)* dengan timer dan scoreboard real-time, podium juara 3D dengan efek konfeti, serta *Panel Administrator* untuk mengontrol jalannya pertandingan secara remote.

---

## 📑 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Struktur Halaman & Rute](#-struktur-halaman--rute)
- [Kebutuhan Sistem](#-kebutuhan-sistem)
- [Panduan Instalasi & Setup](#-panduan-instalasi--setup)
- [Akun Default Administrator](#-akun-default-administrator)
- [Pengujian (Testing)](#-pengujian-testing)
- [Lisensi](#-lisensi)

---

## ✨ Fitur Utama

### 1. 📺 Layar Panggung Interaktif (Live Stage Display)
- **Real-time Countdown Timer:** Timer panggung otomatis yang dapat diatur durasinya (misal 15 detik), dengan status *Running*, *Paused*, dan *Stopped*.
- **Audio Buzzer / Alarm:** Bunyi alarm otomatis saat waktu menjawab habis.
- **Scoreboard Dinamis 3 Meja/Slot:** Menampilkan 3 regu yang sedang bertanding di panggung (Slot 1, Slot 2, Slot 3) beserta skor yang tersinkronisasi langsung dari panel juri/admin tanpa refresh halaman.
- **Tampilan Modern & Responsif:** Desain panggung elegan dengan tipografi kontras tinggi yang mudah dibaca di layar proyektor / videotron.

### 2. 🥇 Layar Juara & Podium 3D (`/juara`)
- **Podium Visual 3D:** Menampilkan Juara 1 (Emas), Juara 2 (Perak), dan Juara 3 (Perunggu).
- **Efek Konfeti & Sound Effect:** Animasi perayaan kemenangan saat penentuan sang juara.
- **Data Real-time:** Nilai dan nama pemenang terhubung langsung dengan rekapitulasi skor.

### 3. 🎛️ Dashboard & Remote Control Pertandingan
- **Kontrol Timer Panggung:** Tombol remote *Start*, *Pause*, *Reset*, dan pilihan durasi cepat (10s, 15s, 30s, 60s).
- **Pengaturan Poin Cepat:** Tombol instan penambahan (+10, +20, +50, +100) atau pengurangan (-10, -50) skor per slot meja.
- **Slot Switcher:** Penempatan sekolah/regu peserta ke meja Slot 1, Slot 2, atau Slot 3 panggung.

### 4. 🏫 Manajemen Sekolah & Regu Peserta
- **CRUD Data Sekolah:** Pengelolaan nama sekolah, regu (Regu A, B, C, dst.), status keaktifan, dan inisialisasi skor.
- **Yajra DataTables:** Tabel interaktif dengan pencarian instan, sorting, dan pagination server-side.
- **SweetAlert2 Notifications:** Konfirmasi aksi dan notifikasi interaktif yang menarik.

### 5. 📊 Rekapitulasi Nilai & Cetak Laporan
- **Leaderboard Lengkap:** Rekapitulasi total nilai seluruh peserta dari peringkat tertinggi hingga terendah.
- **Format Cetak Formal:** Halaman cetak laporan rekapitulasi siap cetak (print/PDF) lengkap dengan kop dokumen resmi UIS, rincian skor, dan kolom tanda tangan dewan juri/panitia.

### 6. 👥 Manajemen Pengguna & Keamanan
- Autentikasi berbasis session dengan middleware proteksi role (`checkrole:admin`).
- CRUD akun administrator dan fitur ubah password admin.

---

## 🛠️ Teknologi yang Digunakan

| Kategori | Teknologi |
| --- | --- |
| **Backend Framework** | [Laravel 13.x](https://laravel.com) |
| **Bahasa Pemrograman** | [PHP 8.4+](https://php.net) |
| **Database** | [MySQL 8.x / MariaDB](https://mysql.com) |
| **Frontend Styling** | [Bootstrap 5](https://getbootstrap.com) & [Tailwind CSS 4](https://tailwindcss.com) |
| **Build Tool** | [Vite 7](https://vitejs.dev) |
| **DataTables** | [Yajra Laravel DataTables](https://yajrabox.com) |
| **Alerts & Dialog** | [RealRashid SweetAlert](https://sweetalert2.github.io) |
| **Icons & Font** | Bootstrap Icons, Boxicons, Google Fonts (Montserrat, Poppins, Bebas Neue) |

---

## 🗺️ Struktur Halaman & Rute

| Rute URL | Metode | Middleware | Keterangan |
| --- | --- | --- | --- |
| `/` | `GET` | Guest | Layar Panggung utama (Scoreboard 3 Meja & Timer) |
| `/juara` | `GET` | Guest | Layar Panggung Podium 3D Juara 1, 2, 3 |
| `/login` | `GET/POST` | Guest | Halaman login administrator |
| `/dashboard` | `GET` | Auth, Role Admin | Dashboard utama & remote control skor/timer |
| `/dashboard/schools` | `RESOURCE` | Auth, Role Admin | Manajemen data sekolah & regu peserta |
| `/dashboard/rekapitulasi` | `GET` | Auth, Role Admin | Halaman rekapitulasi nilai dan pemenang |
| `/dashboard/rekapitulasi/cetak` | `GET` | Auth, Role Admin | Format cetak dokumen resmi rekapitulasi |
| `/dashboard/users` | `RESOURCE` | Auth, Role Admin | Manajemen akun admin |
| `/api/stage-data` | `GET` | Public | Endpoint data real-time untuk layar panggung |
| `/api/stage-timer` | `POST` | Public | Endpoint kontrol timer layar panggung |

---

## ⚙️ Kebutuhan Sistem

- **PHP** >= 8.4 (ekstensi `pdo_mysql`, `mbstring`, `openssl`, `bcmath`, `curl`)
- **Composer** >= 2.x
- **Node.js** >= 18.x & **NPM**
- **MySQL / MariaDB** (atau lingkungan lokal seperti Laragon / XAMPP)

---

## 🚀 Panduan Instalasi & Setup

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal:

### 1. Masuk ke Direktori Proyek
```bash
cd c:/laragon/www/uischallenge
```

### 2. Install Dependensi PHP & JavaScript
```bash
composer install
npm install
```

### 3. Konfigurasi Lingkungan (`.env`)
Salin file konfigurasi jika belum ada:
```bash
cp .env.example .env
```
Pastikan pengaturan koneksi database pada `.env` telah disesuaikan:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=uischallenge
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Buat Database & Jalankan Migrasi + Seeder
Pastikan service MySQL Anda sudah berjalan, lalu jalankan:
```bash
php artisan migrate --seed
```
*Perintah ini akan membuat struktur tabel serta mengisikan akun admin default dan data sampel sekolah peserta.*

### 6. Build Aset Frontend
```bash
# Untuk kompilasi produksi:
npm run build

# Atau untuk mode pengembangan (watch mode):
npm run dev
```

### 7. Jalankan Server Aplikasi
Jika menggunakan Laragon, aplikasi dapat langsung diakses melalui virtual host:
`http://uischallenge.test`

Atau jalankan server bawaan Laravel:
```bash
php artisan serve
```
Akses di browser melalui: `http://localhost:8000`

---

## 🔑 Akun Default Administrator

Setelah menjalankan seeder database, Anda dapat login dengan akun berikut:

- **URL Login:** `http://localhost:8000/login`
- **Email:** `admin@gmail.com`
- **Password:** `password`
- **Role:** `admin`

> ⚠️ *Disarankan untuk segera mengubah password default pada menu profil admin setelah instalasi pertama.*

---

## 🧪 Pengujian (Testing)

Aplikasi ini telah dilengkapi dengan rangkaian Feature Test dan Unit Test otomatis:

```bash
php artisan test
```

Uji otomatis mencakup:
- Aksesibilitas Layar Panggung & API data panggung.
- Autentikasi Admin & Proteksi Dashboard.
- Operasi CRUD Sekolah (Schools) dengan DataTables.
- Operasi CRUD Pengguna (Users).
- Remote API Controller untuk Timer & Scoreboard.

---

## 📄 Lisensi

Aplikasi ini dikembangkan untuk kegiatan **UIS Grand Academic Challenge** dan dirilis di bawah lisensi [MIT License](LICENSE).
