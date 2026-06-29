<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 5">
  <img src="https://img.shields.io/badge/Chart.js-4-FF6384?style=for-the-badge&logo=chartdotjs&logoColor=white" alt="Chart.js">
  <img src="https://img.shields.io/badge/Alpine.js-3-8BC0D0?style=for-the-badge&logo=alpinedotjs&logoColor=white" alt="Alpine.js">
  <img src="https://img.shields.io/badge/Vite-7-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
</p>

<h1 align="center">📚 Perpusku</h1>

<p align="center">
  Sistem Manajemen Perpustakaan berbasis web — modern, profesional, dan mudah digunakan.<br>
  Dibangun dengan <strong>Laravel 12</strong>, <strong>Bootstrap 5</strong>, <strong>Chart.js</strong>, dan <strong>Alpine.js</strong>.
</p>

---

## 📖 Tentang Proyek

**Perpusku** adalah aplikasi web admin-only untuk mengelola operasional perpustakaan, meliputi:

- 📚 Manajemen koleksi buku (CRUD lengkap dengan upload sampul)
- 🎓 Manajemen data mahasiswa
- 🔄 Proses peminjaman buku (wizard 3 langkah)
- ✅ Proses pengembalian buku (deteksi keterlambatan otomatis)
- 📊 Dashboard analitik dengan grafik interaktif
- 📜 Riwayat peminjaman lengkap

Aplikasi ini dirancang dengan tampilan **SaaS enterprise** — bersih, responsif, dan profesional.

---

## 🛠️ Tech Stack

### Backend

| Teknologi      | Versi      | Fungsi                  |
| -------------- | ---------- | ----------------------- |
| PHP            | ^8.2       | Runtime                 |
| Laravel        | 12         | Framework backend       |
| Laravel Breeze | 2.3        | Scaffolding autentikasi |
| MySQL          | 5.7+ / 8.0 | Database                |

### Frontend

| Teknologi       | Versi | Fungsi                                                  |
| --------------- | ----- | ------------------------------------------------------- |
| Bootstrap       | 5.3   | CSS framework & komponen UI                             |
| Bootstrap Icons | 1.13  | Icon library                                            |
| Alpine.js       | 3.x   | Interaktivitas ringan (sidebar, wizard, flash messages) |
| Chart.js        | 4.x   | Grafik dashboard (bar chart, doughnut chart)            |
| Vite            | 7.x   | Build tool & HMR                                        |

---

## 📁 Struktur Proyek

```
perpus-TRPL/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                    # Autentikasi (Breeze)
│   │   │   ├── DashboardController.php  # Dashboard + chart data
│   │   │   ├── BukuController.php       # CRUD buku
│   │   │   ├── MahasiswaController.php  # CRUD mahasiswa
│   │   │   ├── peminjamController.php   # CRUD peminjaman
│   │   │   ├── PengembalianController.php # Proses pengembalian
│   │   │   └── HistoryController.php    # Riwayat peminjaman
│   │   └── Middleware/
│   │       └── IsAdmin.php              # Middleware role admin
│   ├── Models/
│   │   ├── User.php                     # Admin / Petugas
│   │   ├── Mahasiswa.php                # Data mahasiswa
│   │   ├── Buku.php                     # Data buku
│   │   ├── KategoriBuku.php             # Kategori buku
│   │   ├── Penulis.php                  # Data penulis
│   │   ├── Peminjaman.php               # Transaksi peminjaman
│   │   ├── DetailPeminjaman.php         # Detail buku per peminjaman
│   │   └── Pengembalian.php             # Data pengembalian
│   └── Providers/
│       └── AppServiceProvider.php       # Bootstrap 5 pagination
│
├── resources/
│   ├── css/
│   │   ├── app.css                      # CSS variables + global styles
│   │   └── components/
│   │       ├── sidebar.css              # Sidebar styles
│   │       ├── cards.css                # Stat cards, content cards
│   │       ├── tables.css               # Data tables, action buttons
│   │       └── forms.css                # Form inputs, buttons, upload area
│   ├── js/
│   │   └── app.js                       # Bootstrap + Alpine.js + Chart.js setup
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php            # Layout utama (sidebar + topbar)
│       ├── components/
│       │   ├── stat-card.blade.php       # Kartu statistik
│       │   ├── page-header.blade.php     # Header halaman
│       │   ├── data-table.blade.php      # Wrapper tabel data
│       │   ├── badge.blade.php           # Badge status
│       │   ├── modal.blade.php           # Modal dialog
│       │   ├── form-card.blade.php       # Card container form
│       │   └── empty-state.blade.php     # Tampilan data kosong
│       ├── auth/
│       │   └── login.blade.php           # Halaman login split-screen
│       ├── dashboard.blade.php           # Dashboard + Chart.js
│       ├── buku/
│       │   ├── index.blade.php           # Daftar buku
│       │   ├── create.blade.php          # Tambah buku
│       │   ├── edit.blade.php            # Edit buku
│       │   └── show.blade.php            # Detail buku
│       ├── mahasiswa/
│       │   ├── index.blade.php           # Daftar mahasiswa
│       │   ├── create.blade.php          # Tambah mahasiswa
│       │   └── edit.blade.php            # Edit mahasiswa
│       ├── peminjaman/
│       │   ├── index.blade.php           # Daftar peminjaman aktif
│       │   ├── create.blade.php          # Form peminjaman (wizard)
│       │   └── show.blade.php            # Detail peminjaman
│       ├── pengembalian/
│       │   └── create.blade.php          # Proses pengembalian
│       └── riwayat/
│           ├── index.blade.php           # Riwayat peminjaman
│           └── show.blade.php            # Detail riwayat
│
├── routes/
│   ├── web.php                          # Route utama
│   └── auth.php                         # Route autentikasi (Breeze)
│
├── database/
│   └── migrations/                      # 10 migration files
│
├── vite.config.js                       # Konfigurasi Vite
├── package.json                         # Dependencies NPM
└── composer.json                        # Dependencies PHP
```

---

## 🗄️ Skema Database

```
┌──────────────┐     ┌──────────────┐     ┌──────────────────┐
│    users     │     │  mahasiswas  │     │   kategori_bukus │
├──────────────┤     ├──────────────┤     ├──────────────────┤
│ id           │     │ id           │     │ id               │
│ name         │     │ nim (unique) │     │ nama_kategori    │
│ email        │     │ nama         │     └────────┬─────────┘
│ password     │     │ prodi        │              │
│ role         │     │ kelas        │     ┌────────┴─────────┐
└──────┬───────┘     │ angkatan     │     │     penulis      │
       │             └──────┬───────┘     ├──────────────────┤
       │                    │             │ id               │
       │                    │             │ nama_penulis     │
       │                    │             └────────┬─────────┘
       │                    │                      │
       │             ┌──────┴───────┐     ┌────────┴─────────┐
       │             │  peminjaman  │     │      bukus       │
       │             ├──────────────┤     ├──────────────────┤
       └────────────►│ id           │     │ id               │
        petugas_id   │ mahasiswa_id ├────►│ isbn (unique)    │
                     │ petugas_id   │     │ judul            │
                     │ tanggal_pinjam     │ kategori_id ─────┘
                     │ tanggal_jatuh_tempo│ penulis_id ───────┘
                     │ status       │     │ bahasa           │
                     └──────┬───────┘     │ jumlah_halaman   │
                            │             │ stok             │
                     ┌──────┴──────────┐  │ sampul           │
                     │detail_peminjaman│  └──────────────────┘
                     ├────────────────┤           ▲
                     │ id             │           │
                     │ peminjaman_id  │           │
                     │ buku_id  ──────┼───────────┘
                     │ jumlah         │
                     └────────────────┘
                            │
                     ┌──────┴───────┐
                     │pengembalians │
                     ├──────────────┤
                     │ id           │
                     │ peminjaman_id│
                     │tanggal_kembali
                     └──────────────┘
```

---

## 🚀 Instalasi

### Prasyarat

- **PHP** >= 8.2
- **Composer** >= 2.x
- **Node.js** >= 18.x & **NPM** >= 9.x
- **MySQL** >= 5.7 atau 8.0
- **Git**

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/username/perpus-TRPL.git
cd perpus-TRPL

# 2. Install dependencies PHP
composer install

# 3. Install dependencies NPM
npm install

# 4. Salin file environment
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Konfigurasi database di file .env
#    Sesuaikan DB_DATABASE, DB_USERNAME, DB_PASSWORD
```

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_perpustakaanku
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# 7. Jalankan migrasi database
php artisan migrate

# 8. Buat symlink storage untuk upload sampul
php artisan storage:link

# 9. Build assets frontend
npm run build

# 10. Jalankan server
php artisan serve
```

Akses aplikasi di: **http://127.0.0.1:8000**

---

## ⚡ Development Mode

Untuk development dengan hot-reload:

```bash
# Terminal 1 — Laravel server
php artisan serve

# Terminal 2 — Vite dev server
npm run dev
```

Atau jalankan keduanya sekaligus:

```bash
composer dev
```

---

## 🔑 Login Default

Setelah migrasi, buat user admin via Tinker:

```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@gmail.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
]);
```

| Email             | Password   |
| ----------------- | ---------- |
| `admin@gmail.com` | `password` |

---

## 🗺️ Daftar Route

| Method   | URI                           | Nama Route                    | Fungsi                  |
| -------- | ----------------------------- | ----------------------------- | ----------------------- |
| `GET`    | `/`                           | —                             | Halaman login           |
| `GET`    | `/admin/dashboard`            | `admin.dashboard`             | Dashboard               |
| `GET`    | `/admin/mahasiswa`            | `admin.mahasiswa.index`       | Daftar mahasiswa        |
| `GET`    | `/admin/addMahasiswa`         | `admin.addMahasiswa`          | Form tambah mahasiswa   |
| `POST`   | `/admin/addMahasiswa`         | `admin.storeMahasiswa`        | Simpan mahasiswa        |
| `GET`    | `/admin/mahasiswa/edit/{id}`  | `admin.mahasiswa.edit`        | Form edit mahasiswa     |
| `PUT`    | `/admin/mahasiswa/edit/{id}`  | `admin.updateMahasiswa`       | Update mahasiswa        |
| `DELETE` | `/admin/mahasiswa/{id}`       | `admin.mahasiswa.delete`      | Hapus mahasiswa         |
| `GET`    | `/admin/viewBuku`             | `admin.viewBuku`              | Daftar buku             |
| `GET`    | `/admin/tambahBuku`           | `admin.tambahBuku`            | Form tambah buku        |
| `POST`   | `/admin/tambahBuku`           | `admin.storeBuku`             | Simpan buku             |
| `GET`    | `/admin/editBuku/{id}`        | `admin.editBuku`              | Form edit buku          |
| `PUT`    | `/admin/editBuku/{id}`        | `admin.updateBuku`            | Update buku             |
| `DELETE` | `/admin/deleteBuku/{id}`      | `admin.deleteBuku`            | Hapus buku              |
| `GET`    | `/admin/detailBuku/{id}`      | `admin.detailBuku`            | Detail buku             |
| `GET`    | `/admin/viewPeminjam`         | `admin.viewPeminjam`          | Daftar peminjaman aktif |
| `GET`    | `/admin/addPeminjam`          | `admin.tambahPeminjam`        | Form peminjaman baru    |
| `POST`   | `/admin/addPeminjam`          | `admin.storePeminjam`         | Simpan peminjaman       |
| `GET`    | `/admin/detailPeminjam/{id}`  | `admin.detailPeminjam`        | Detail peminjaman       |
| `GET`    | `/admin/pengembalian/{id}`    | `admin.pengembalian.create`   | Halaman pengembalian    |
| `PUT`    | `/admin/kembalikanBuku/{id}`  | `admin.kembalikanBuku`        | Proses pengembalian     |
| `GET`    | `/admin/historyPeminjam`      | `admin.historyPeminjam`       | Riwayat peminjaman      |
| `GET`    | `/admin/historyPeminjam/{id}` | `admin.detailPeminjamHistory` | Detail riwayat          |

---

## 📄 Lisensi

Proyek ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).
