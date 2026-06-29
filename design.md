# PROMPT REDESAIN SISTEM PERPUSTAKAAN — perpus-TRPL
## Stack Baru: Laravel 12 + Bootstrap 5 + Chart.js + Alpine.js + Vite

---

## KONTEKS PROYEK

Kamu adalah seorang senior UI/UX developer yang bertugas meredesain sistem manajemen perpustakaan bernama **perpus-TRPL** — sebuah aplikasi web admin-only untuk mengelola buku, mahasiswa, peminjaman, dan pengembalian di program studi TRPL.

Stack lama menggunakan AdminLTE 3. **Hapus seluruh dependensi AdminLTE** dan bangun ulang tampilan dari nol menggunakan Bootstrap 5 + komponen kustom. Tujuannya adalah tampilan yang **modern, profesional, bersih**, dan terasa seperti SaaS enterprise — bukan panel admin generik.

---

## ATURAN GLOBAL DESAIN

### Palet Warna (definisikan di `resources/css/app.css`)
```css
:root {
  /* Primary — Indigo profesional */
  --clr-primary:     #4F46E5;
  --clr-primary-dk:  #3730A3;
  --clr-primary-lt:  #EEF2FF;
  --clr-primary-mid: #6366F1;

  /* Neutral */
  --clr-bg:          #F8FAFC;
  --clr-surface:     #FFFFFF;
  --clr-border:      #E2E8F0;
  --clr-muted:       #94A3B8;
  --clr-text:        #0F172A;
  --clr-text-sub:    #475569;

  /* Semantic */
  --clr-success:     #10B981;
  --clr-success-lt:  #D1FAE5;
  --clr-warning:     #F59E0B;
  --clr-warning-lt:  #FEF3C7;
  --clr-danger:      #EF4444;
  --clr-danger-lt:   #FEE2E2;
  --clr-info:        #3B82F6;
  --clr-info-lt:     #DBEAFE;

  /* Sidebar */
  --sidebar-bg:      #1E1B4B;   /* Deep indigo gelap */
  --sidebar-text:    #C7D2FE;
  --sidebar-active:  #4F46E5;
  --sidebar-hover:   rgba(99, 102, 241, 0.15);
  --sidebar-width:   260px;

  /* Spacing & Shape */
  --radius-sm:  6px;
  --radius-md:  10px;
  --radius-lg:  16px;
  --shadow-sm:  0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
  --shadow-md:  0 4px 12px rgba(0,0,0,0.08);
  --shadow-lg:  0 10px 30px rgba(0,0,0,0.12);
}
```

### Tipografi
- Import Google Fonts: `Inter` (300,400,500,600,700) untuk semua teks UI
- Body: 14px / line-height 1.6
- Heading section: 600 weight
- Label form: 500 weight, 13px
- Caption / muted: 12px, `var(--clr-muted)`
- **JANGAN gunakan font-size di bawah 12px**
- Gunakan `letter-spacing: -0.01em` pada heading besar

---

## STRUKTUR LAYOUT UTAMA

### File: `resources/views/layouts/app.blade.php`

Buat layout dua-kolom:
- **Sidebar kiri** fixed, lebar `var(--sidebar-width)`, tinggi 100vh, bg `var(--sidebar-bg)`
- **Main content** kanan, mengisi sisa lebar, bg `var(--clr-bg)`, overflow-y auto
- Di mobile (< 992px): sidebar collapse menjadi overlay dengan tombol hamburger di topbar

#### Struktur sidebar:
```
┌─────────────────────────────┐
│  [LOGO]  perpus·TRPL        │  ← Logo + nama sistem, padding 20px 24px
├─────────────────────────────┤
│  [SEARCH QUICK]             │  ← Input kecil search (optional, Alpine.js)
├─────────────────────────────┤
│  MENU                       │  ← Label section, 10px, muted, uppercase
│  ◆ Dashboard                │  ← Icon Remix/Bootstrap Icons + label
│  ◆ Buku                     │
│  ◆ Mahasiswa                │
├─────────────────────────────┤
│  TRANSAKSI                  │
│  ◆ Peminjaman               │
│  ◆ Pengembalian             │
│  ◆ Riwayat                  │
├─────────────────────────────┤
│  [avatar] Admin             │  ← User info + logout di bottom sidebar
│  [Keluar]                   │
└─────────────────────────────┘
```

**Style nav item aktif:** background `var(--sidebar-active)` + left border 3px solid `#818CF8` + teks putih  
**Style nav item hover:** background `var(--sidebar-hover)` + teks putih  
**Icon:** gunakan Bootstrap Icons (`bi bi-*`) ukuran 18px, margin-right 10px

#### Topbar (di atas konten kanan):
- Tinggi 64px, bg white, border-bottom `var(--clr-border)`, sticky
- Kiri: tombol toggle sidebar (mobile) + breadcrumb halaman aktif
- Kanan: notifikasi bell icon + nama admin + avatar circle inisial

---

## HALAMAN 1 — DASHBOARD (`/dashboard`)

### Layout grid dashboard:
```
┌────────────┬────────────┬────────────┬────────────┐
│ STAT CARD  │ STAT CARD  │ STAT CARD  │ STAT CARD  │  ← Row 1: 4 kolom
└────────────┴────────────┴────────────┴────────────┘
┌─────────────────────────┬──────────────────────────┐
│   CHART: Peminjaman     │   CHART: Distribusi Buku │  ← Row 2: 2 kolom (7:5)
│   per Bulan (Bar)       │   per Kategori (Doughnut)│
└─────────────────────────┴──────────────────────────┘
┌─────────────────────────┬──────────────────────────┐
│  Peminjaman Aktif       │  Buku Terbaru Ditambah   │  ← Row 3: 2 kolom
│  (tabel ringkas)        │  (list cards)            │
└─────────────────────────┴──────────────────────────┘
```

### Stat Cards — desain detail:
Setiap card: bg white, border-radius `var(--radius-lg)`, padding 20px 24px, shadow `var(--shadow-sm)`, border 1px `var(--clr-border)`

Isi setiap card:
```
┌──────────────────────────────────┐
│  [icon circle]   ↗ +12% bulan ini │  ← icon 40px circle + badge trend
│                                  │
│  1.240                           │  ← angka besar, 32px, weight 700
│  Total Mahasiswa                 │  ← label, 13px, muted
└──────────────────────────────────┘
```

4 Stat Cards:
1. **Total Mahasiswa** — icon `bi-people-fill`, warna circle `var(--clr-primary-lt)`, icon color `var(--clr-primary)`
2. **Total Buku (Stok)** — icon `bi-book-fill`, warna `var(--clr-info-lt)` / `var(--clr-info)`
3. **Sedang Dipinjam** — icon `bi-arrow-left-right`, warna `var(--clr-warning-lt)` / `var(--clr-warning)`
4. **Dikembalikan Bulan Ini** — icon `bi-check-circle-fill`, warna `var(--clr-success-lt)` / `var(--clr-success)`

### Chart 1 — Peminjaman per Bulan (Bar Chart):
```javascript
// Chart.js konfigurasi
{
  type: 'bar',
  data: {
    labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
    datasets: [
      {
        label: 'Dipinjam',
        backgroundColor: '#6366F1',
        borderRadius: 6,
        data: [/* dari controller */]
      },
      {
        label: 'Dikembalikan',
        backgroundColor: '#10B981',
        borderRadius: 6,
        data: [/* dari controller */]
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { position: 'top', labels: { usePointStyle: true, font: { family: 'Inter', size: 12 } } },
      tooltip: { backgroundColor: '#1E1B4B', padding: 10, cornerRadius: 8 }
    },
    scales: {
      x: { grid: { display: false }, ticks: { font: { family: 'Inter', size: 12 } } },
      y: { grid: { color: '#F1F5F9' }, ticks: { font: { family: 'Inter', size: 12 } } }
    }
  }
}
```
Wrap dalam card tinggi 300px. Tambahkan header card: "Aktivitas Peminjaman" + dropdown filter tahun (Alpine.js).

### Chart 2 — Distribusi Buku per Kategori (Doughnut):
```javascript
{
  type: 'doughnut',
  data: {
    labels: [/* nama kategori */],
    datasets: [{
      data: [/* jumlah per kategori */],
      backgroundColor: ['#4F46E5','#10B981','#F59E0B','#EF4444','#3B82F6','#8B5CF6'],
      borderWidth: 0,
      hoverOffset: 8
    }]
  },
  options: {
    cutout: '70%',
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { position: 'right', labels: { font: { family: 'Inter', size: 12 }, padding: 16, usePointStyle: true } }
    }
  }
}
```
Di tengah doughnut tampilkan total buku via CSS absolute positioning.

### Tabel Peminjaman Aktif (row 3 kiri):
- Header card: "Peminjaman Aktif" + badge count merah + link "Lihat semua →"
- Tabel ringan: kolom Nama Mahasiswa | Judul Buku | Tgl Jatuh Tempo | Status
- Status badge: "Tepat Waktu" (success) / "Mendekati" (warning) / "Terlambat" (danger)
- Maksimal 5 baris, tanpa paginasi

### Buku Terbaru (row 3 kanan):
- List 5 buku terbaru ditambahkan
- Setiap item: sampul kecil (40x56px, object-fit cover, radius 4px) + judul + penulis + stok badge
- Stok > 3: badge success | stok 1-3: badge warning | stok 0: badge danger "Habis"

---

## HALAMAN 2 — DAFTAR BUKU (`/buku`)

### Header halaman:
```
Manajemen Buku                          [+ Tambah Buku]
4 kategori · 128 judul tersedia         ← stat ringkas
```
Tombol "+ Tambah Buku": bg `var(--clr-primary)`, teks putih, radius `var(--radius-md)`, ikon `bi-plus-lg`

### Filter & Search bar:
Row dengan 4 elemen:
1. Search input (placeholder "Cari judul, ISBN, atau penulis...") — flex-grow
2. Dropdown filter Kategori
3. Dropdown filter Bahasa  
4. Dropdown filter Stok (Tersedia / Habis / Semua)

Style input: border `var(--clr-border)`, radius `var(--radius-md)`, height 40px, focus border `var(--clr-primary)`, transisi smooth

### Tabel Buku:
Card putih, shadow `var(--shadow-sm)`, radius `var(--radius-lg)`, overflow hidden

Header tabel: bg `#F8FAFC`, teks 12px uppercase muted, font-weight 600

Kolom:
| # | Sampul | Judul & ISBN | Kategori | Penulis | Stok | Aksi |
|---|--------|--------------|----------|---------|------|------|

- **Sampul**: thumbnail 48x64px, object-fit cover, radius 6px, placeholder grey jika kosong
- **Judul**: font-weight 500, 14px. Di bawahnya: ISBN dalam teks muted 12px
- **Kategori**: badge pill warna `var(--clr-info-lt)` + `var(--clr-info)`, radius 20px
- **Stok**: badge berwarna sesuai jumlah (success/warning/danger)
- **Aksi**: 3 tombol icon: Detail (bi-eye), Edit (bi-pencil), Hapus (bi-trash) — ghost style, hover warna sesuai aksi

Row hover: background `#F8FAFC`, transisi 150ms

Paginasi: Bootstrap pagination, style kustom warna primary

---

## HALAMAN 3 — FORM TAMBAH/EDIT BUKU (`/buku/create`, `/buku/{id}/edit`)

### Layout dua kolom (8:4):
```
┌──────────────────────────┬──────────────────┐
│  Informasi Buku          │  Sampul Buku     │
│  ─────────────────────   │  ──────────────  │
│  Judul Buku *            │  [Upload Area]   │
│  ─────────────────────   │                  │
│  ISBN *                  │  Preview image   │
│  ─────────────────────   │                  │
│  Kategori *  [+ Baru]    │  Stok & Info     │
│  ─────────────────────   │  ──────────────  │
│  Penulis *   [+ Baru]    │  Stok *          │
│  ─────────────────────   │  Halaman *       │
│  Bahasa *                │  Bahasa          │
│                          │                  │
│  [Batal]    [Simpan →]   │                  │
└──────────────────────────┴──────────────────┘
```

### Upload Area Sampul:
```
┌─────────────────────────┐
│                         │
│   [bi-cloud-upload]     │  ← icon 48px, muted
│   Klik atau drag & drop │
│   PNG, JPG maks 2MB     │
│                         │
└─────────────────────────┘
```
- Border: 2px dashed `var(--clr-border)`, radius `var(--radius-lg)`, padding 32px
- Saat drag-over: border color `var(--clr-primary)`, bg `var(--clr-primary-lt)`
- Setelah upload: tampilkan preview image menggantikan area upload
- Implementasi dengan Alpine.js (`@dragover`, `@drop`, `@change`)

### Style form elements:
- Label: 13px, font-weight 500, `var(--clr-text)`, margin-bottom 6px
- Input: full width, height 42px, border 1px `var(--clr-border)`, radius `var(--radius-md)`, padding 0 12px
- Focus: border-color `var(--clr-primary)`, box-shadow `0 0 0 3px var(--clr-primary-lt)`
- Error state: border-color `var(--clr-danger)`, error message 12px merah di bawah input
- Select kategori & penulis: dengan tombol "+ Baru" kecil di sebelahnya → buka modal inline

### Modal "Tambah Kategori Baru" / "Tambah Penulis Baru":
- Backdrop semi-transparan
- Modal kecil (400px lebar), radius `var(--radius-lg)`, shadow `var(--shadow-lg)`
- Satu input + tombol Simpan + Batal
- Animasi fade+scale masuk dengan Alpine.js `x-transition`

---

## HALAMAN 4 — DAFTAR MAHASISWA (`/mahasiswa`)

Serupa dengan halaman Buku. Perbedaan:

### Tabel Mahasiswa:
Kolom: | # | NIM | Nama | Kelas | Angkatan | Peminjaman Aktif | Aksi |

- **NIM**: font-mono 13px
- **Peminjaman Aktif**: jika 0 tampil "—", jika > 0 tampil badge count primary dengan link ke filter peminjaman mahasiswa tersebut
- **Angkatan**: format "2022/2023"

### Kartu profil quick-view (opsional, hover):
Saat hover baris mahasiswa, tampilkan tooltip card kecil dengan info ringkas (nama, nim, total pinjam, status terakhir) — implementasi Alpine.js.

---

## HALAMAN 5 — FORM PEMINJAMAN BARU (`/peminjaman/create`)

### Layout wizard tiga langkah (progress bar di atas):
```
① Pilih Mahasiswa  →  ② Pilih Buku  →  ③ Konfirmasi
```
Progress bar: 3 step circles + connector line, step aktif warna primary, selesai checklist hijau

### Step 1 — Pilih Mahasiswa:
- Search input real-time (Alpine.js + fetch `/api/mahasiswa?q=...`)
- Hasil muncul sebagai dropdown list card:
  ```
  ┌──────────────────────────────────┐
  │ [avatar inisial]  Nama Mahasiswa │
  │                   NIM · Kelas    │
  └──────────────────────────────────┘
  ```
- Setelah dipilih: tampilkan "mahasiswa terpilih" card di bawah search dengan tombol X untuk batal pilih

### Step 2 — Pilih Buku:
- Search buku + filter kategori
- Setiap buku tampil sebagai card horizontal:
  ```
  ┌─────────────────────────────────────────────┐
  │ [sampul]  Judul Buku             [+ Tambah] │
  │           Penulis · Kategori                │
  │           Stok: 5 tersedia                  │
  └─────────────────────────────────────────────┘
  ```
- Buku yang dipilih masuk ke panel "Keranjang" di kanan (sticky)
- Di keranjang: daftar buku terpilih + input jumlah + tombol hapus + total ringkasan
- Input durasi pinjam (default 7 hari, max 14 hari) dengan date picker

### Step 3 — Konfirmasi:
- Ringkasan: mahasiswa + daftar buku + durasi + tanggal jatuh tempo
- Tombol "Konfirmasi & Proses Peminjaman" — loading spinner saat submit
- Tombol "Kembali" ke step sebelumnya

---

## HALAMAN 6 — DAFTAR PEMINJAMAN AKTIF (`/peminjaman`)

### Filter tab horizontal:
```
[Semua] [Aktif] [Mendekati Jatuh Tempo] [Terlambat]
```
Tab style: bawah border aktif warna primary, teks primary; inactive teks muted

### Tabel Peminjaman:
Kolom: | # | Mahasiswa | Buku (detail_peminjaman) | Tgl Pinjam | Jatuh Tempo | Status | Aksi |

- **Buku**: tampilkan judul buku pertama + "+N lainnya" jika lebih dari 1
- **Status badge**:
  - "Aktif" → `var(--clr-info-lt)` / `var(--clr-info)`
  - "Mendekati" (< 3 hari) → `var(--clr-warning-lt)` / `var(--clr-warning)` + icon warning
  - "Terlambat" → `var(--clr-danger-lt)` / `var(--clr-danger)` + icon danger + "N hari"
- **Aksi**: tombol "Kembalikan" (success style) + "Detail"

---

## HALAMAN 7 — PROSES PENGEMBALIAN (`/pengembalian/create/{peminjaman}`)

### Layout konfirmasi:
Card centered, maks 640px

Header card: "Proses Pengembalian Buku"

Isi:
1. Info mahasiswa (nama + NIM) dalam info box
2. Tabel buku yang dikembalikan (dari detail_peminjaman)
3. Info tanggal: Tgl Pinjam | Jatuh Tempo | Tgl Kembali (hari ini, editable)
4. Status keterlambatan (kalkulasi otomatis dengan Alpine.js):
   - Jika tepat waktu: alert success "Dikembalikan tepat waktu"
   - Jika terlambat: alert warning "Terlambat N hari"
5. Tombol "Konfirmasi Pengembalian" full-width

---

## HALAMAN 8 — RIWAYAT PEMINJAMAN (`/riwayat`)

### Filter advanced:
Row: Search | Filter Periode (date range) | Filter Mahasiswa | Export CSV

### Tabel Riwayat:
Kolom: | # | Mahasiswa | Buku | Tgl Pinjam | Tgl Kembali | Durasi | Keterlambatan |

- **Durasi**: "7 hari"
- **Keterlambatan**: "Tepat waktu" (success) / "+3 hari" (danger)

---

## KOMPONEN REUSABLE (Blade Components)

### 1. `<x-stat-card>` — Kartu Statistik
Props: `title`, `value`, `icon`, `color` (primary/success/warning/danger/info), `trend` (opsional)

### 2. `<x-page-header>` — Header Halaman
Props: `title`, `subtitle`, `breadcrumb` (array)
Slot: `actions` (untuk tombol di kanan)

### 3. `<x-data-table>` — Wrapper Tabel
Slot: thead, tbody. Props: `title`, `subtitle`
Include: header card dengan judul + slot actions (search/filter)

### 4. `<x-badge>` — Badge Status
Props: `type` (success/warning/danger/info/primary), `text`

### 5. `<x-modal>` — Modal Dialog
Props: `id`, `title`, `size` (sm/md/lg)
Slot: body, footer

### 6. `<x-form-card>` — Card Container Form
Props: `title`, `subtitle`

### 7. `<x-empty-state>` — Tampilan Data Kosong
Props: `icon`, `title`, `description`, `action-label`, `action-route`

---

## NOTIFIKASI & FEEDBACK

### Flash Messages (session-based):
Tampilkan di bawah topbar, auto-dismiss setelah 4 detik dengan Alpine.js:
```html
<div x-data="{ show: true }" x-show="show" x-transition
     x-init="setTimeout(() => show = false, 4000)">
  <!-- alert bootstrap dengan icon -->
</div>
```
- Success: bg `var(--clr-success-lt)`, border-left 4px `var(--clr-success)`, icon `bi-check-circle`
- Error: bg `var(--clr-danger-lt)`, border-left 4px `var(--clr-danger)`, icon `bi-x-circle`

### Loading State:
Tombol submit saat diklik: disabled + spinner kecil + teks berubah "Memproses..."
```html
<button x-bind:disabled="loading" @click="loading = true">
  <span x-show="loading" class="spinner-border spinner-border-sm"></span>
  <span x-text="loading ? 'Memproses...' : 'Simpan'"></span>
</button>
```

### Konfirmasi Hapus:
Gunakan modal Bootstrap (bukan `confirm()` browser). Tombol hapus di tabel buka modal konfirmasi kecil dengan pesan spesifik nama item yang akan dihapus.

---

## IMPLEMENTASI CHART.JS DI DASHBOARD

### Setup di `resources/js/app.js`:
```javascript
import Chart from 'chart.js/auto';
window.Chart = Chart;

// Defaults global
Chart.defaults.font.family = 'Inter, sans-serif';
Chart.defaults.font.size = 12;
Chart.defaults.color = '#94A3B8';
Chart.defaults.plugins.legend.labels.boxWidth = 10;
Chart.defaults.plugins.legend.labels.usePointStyle = true;
```

### Data dari Controller ke Blade:
```php
// DashboardController.php
$chartPeminjaman = Peminjaman::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
    ->whereYear('tanggal_pinjam', date('Y'))
    ->groupBy('bulan')
    ->pluck('total', 'bulan')
    ->toArray();

$chartKategori = KategoriBuku::withCount('bukus')->get();

return view('dashboard', [
    'chartPeminjaman' => $chartPeminjaman,
    'chartKategori' => $chartKategori,
    // ...stats lainnya
]);
```

```blade
{{-- Di view --}}
<script>
  const dataPeminjaman = @json($chartPeminjaman);
  const dataKategori = @json($chartKategori);
</script>
```

---

## HALAMAN LOGIN (`/login`)

### Layout full-screen split:
```
┌────────────────────┬───────────────────────────┐
│                    │                           │
│   Panel kiri       │   Form Login              │
│   bg indigo gelap  │   bg putih                │
│                    │                           │
│   [Logo]           │   [Logo kecil]            │
│   perpus·TRPL      │   Selamat datang kembali  │
│                    │                           │
│   "Kelola          │   Email                   │
│   perpustakaan     │   ───────────────────     │
│   TRPL dengan      │   Password                │
│   lebih efisien"   │   ───────────────────     │
│                    │   [ Masuk ]               │
│   [Ilustrasi SVG   │                           │
│   buku/rak]        │                           │
│                    │                           │
└────────────────────┴───────────────────────────┘
```
- Panel kiri: gradient `linear-gradient(135deg, #1E1B4B 0%, #312E81 100%)`
- Teks panel kiri: putih, tagline 24px, deskripsi 14px muted
- Tombol Masuk: bg `var(--clr-primary)`, full width, height 46px, radius `var(--radius-md)`
- Tambahkan ilustrasi SVG sederhana (rak buku, buku terbuka) di panel kiri

---

## RESPONSIVE & MOBILE

### Breakpoints (Bootstrap 5):
- **Desktop (≥992px)**: Sidebar visible, layout normal
- **Tablet (768–991px)**: Sidebar collapse, toggle via hamburger, overlay dengan backdrop
- **Mobile (<768px)**: Full stack, tabel scrollable horizontal, stat card 2-kolom grid

### Sidebar Mobile:
```javascript
// Alpine.js
x-data="{ sidebarOpen: false }"
// Sidebar: x-show="sidebarOpen" + fixed overlay z-50
// Backdrop: klik tutup sidebar
```

### Tabel Responsive:
Wrap setiap tabel dengan `<div class="table-responsive">` dan tambahkan `white-space: nowrap` pada cell yang perlu.

---

## FILE STRUCTURE (Resources)

```
resources/
├── css/
│   ├── app.css          ← CSS variables + custom styles
│   └── components/
│       ├── sidebar.css
│       ├── cards.css
│       ├── tables.css
│       └── forms.css
├── js/
│   ├── app.js           ← Chart.js setup + Alpine.js
│   └── charts/
│       ├── dashboard-bar.js
│       └── dashboard-doughnut.js
└── views/
    ├── layouts/
    │   └── app.blade.php
    ├── components/
    │   ├── stat-card.blade.php
    │   ├── page-header.blade.php
    │   ├── data-table.blade.php
    │   ├── badge.blade.php
    │   ├── modal.blade.php
    │   └── empty-state.blade.php
    ├── dashboard.blade.php
    ├── buku/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    ├── mahasiswa/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    ├── peminjaman/
    │   ├── index.blade.php
    │   └── create.blade.php
    ├── pengembalian/
    │   └── create.blade.php
    ├── riwayat/
    │   └── index.blade.php
    └── auth/
        └── login.blade.php
```

---

## PACKAGES YANG DIPERLUKAN

### NPM:
```bash
npm install bootstrap @popperjs/core chart.js alpinejs bootstrap-icons
npm remove @tailwindcss/vite tailwindcss  # hapus tailwind jika tidak dipakai
```

### `vite.config.js`:
```javascript
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel({ input: ['resources/css/app.css', 'resources/js/app.js'], refresh: true })
  ]
})
```

### `resources/js/app.js`:
```javascript
import 'bootstrap'
import Alpine from 'alpinejs'
import Chart from 'chart.js/auto'

window.Alpine = Alpine
window.Chart = Chart

// Chart.js global defaults
Chart.defaults.font.family = "'Inter', sans-serif"
Chart.defaults.color = '#94A3B8'

Alpine.start()
```

### `resources/css/app.css`:
```css
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
@import 'bootstrap/dist/css/bootstrap.min.css';
@import 'bootstrap-icons/font/bootstrap-icons.min.css';

/* CSS Variables seperti di atas */
/* Custom styles per komponen */
```

---

## CATATAN PENTING

1. **HAPUS** semua referensi AdminLTE: `@extends('adminlte::page')`, config `adminlte.php`, dan dependensi `jeroennoten/laravel-adminlte`
2. Semua route tetap sama — hanya view yang berubah
3. Logic controller, model, dan migration **TIDAK DIUBAH**
4. Middleware `auth` dan `admin` tetap berjalan normal
5. Pagination menggunakan Bootstrap 5: tambahkan `Paginator::useBootstrapFive()` di `AppServiceProvider::boot()`
6. Form validation error: tampilkan dengan class Bootstrap `is-invalid` + `<div class="invalid-feedback">`
7. CSRF token sudah ada via `@csrf` di setiap form
8. Image upload sampul: simpan di `storage/app/public/sampul` via `Storage::disk('public')`, jalankan `php artisan storage:link`

---

*Prompt ini mencakup seluruh redesain perpus-TRPL. Implementasikan halaman per halaman dimulai dari layout utama (app.blade.php) dan dashboard, kemudian lanjut ke halaman CRUD.*
