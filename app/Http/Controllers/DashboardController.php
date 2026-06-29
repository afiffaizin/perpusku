<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\KategoriBuku;
use App\Models\DetailPeminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalStok = Buku::sum('stok');
        $totalDipinjam = DetailPeminjaman::whereHas('peminjaman', function ($query) {
            $query->where('status', 'dipinjam');
        })->sum('jumlah');
        $stokAwal = $totalDipinjam + $totalStok;

        $dikembalikanBulanIni = Pengembalian::whereMonth('tanggal_kembali', now()->month)
            ->whereYear('tanggal_kembali', now()->year)
            ->count();

        // Chart: Peminjaman per bulan
        $chartPeminjaman = Peminjaman::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_pinjam', date('Y'))
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // Chart: Pengembalian per bulan
        $chartPengembalian = Pengembalian::selectRaw('MONTH(tanggal_kembali) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_kembali', date('Y'))
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // Chart: Distribusi buku per kategori
        $chartKategori = KategoriBuku::withCount('buku')->get();

        // Peminjaman aktif (5 terakhir)
        $peminjamanAktif = Peminjaman::with(['mahasiswa', 'detailPeminjaman.buku'])
            ->where('status', 'dipinjam')
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->take(5)
            ->get();

        // Buku terbaru
        $bukuTerbaru = Buku::with('penulis')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalMahasiswa',
            'totalStok',
            'totalDipinjam',
            'stokAwal',
            'dikembalikanBulanIni',
            'chartPeminjaman',
            'chartPengembalian',
            'chartKategori',
            'peminjamanAktif',
            'bukuTerbaru'
        ));
    }
}
