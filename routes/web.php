<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\peminjamController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengembalianController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Login page
Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Mahasiswa
    Route::get('/admin/mahasiswa', [MahasiswaController::class, 'index'])->name('admin.mahasiswa.index');
    Route::get('/admin/addMahasiswa', [MahasiswaController::class, 'create'])->name('admin.addMahasiswa');
    Route::post('/admin/addMahasiswa', [MahasiswaController::class, 'store'])->name('admin.storeMahasiswa');
    Route::delete('/admin/mahasiswa/{id}', [MahasiswaController::class, 'destroy'])->name('admin.mahasiswa.delete');
    Route::get('/admin/mahasiswa/edit/{id}', [MahasiswaController::class, 'edit'])->name('admin.mahasiswa.edit');
    Route::put('/admin/mahasiswa/edit/{id}', [MahasiswaController::class, 'update'])->name('admin.updateMahasiswa');

    // Buku
    Route::get('/admin/viewBuku', [BukuController::class, 'index'])->name('admin.viewBuku');
    Route::get('/admin/tambahBuku', [BukuController::class, 'create'])->name('admin.tambahBuku');
    Route::post('/admin/tambahBuku', [BukuController::class, 'store'])->name('admin.storeBuku');
    Route::get('/admin/editBuku/{id}', [BukuController::class, 'edit'])->name('admin.editBuku');
    Route::put('/admin/editBuku/{id}', [BukuController::class, 'update'])->name('admin.updateBuku');
    Route::delete('/admin/deleteBuku/{id}', [BukuController::class, 'destroy'])->name('admin.deleteBuku');
    Route::get('/admin/detailBuku/{id}', [BukuController::class, 'show'])->name('admin.detailBuku');

    // Peminjaman
    Route::get('/admin/viewPeminjam', [peminjamController::class, 'index'])->name('admin.viewPeminjam');
    Route::get('/admin/addPeminjam', [peminjamController::class, 'create'])->name('admin.tambahPeminjam');
    Route::post('/admin/addPeminjam', [peminjamController::class, 'store'])->name('admin.storePeminjam');
    Route::get('/admin/detailPeminjam/{id}', [peminjamController::class, 'show'])->name('admin.detailPeminjam');

    // Pengembalian
    Route::get('/admin/pengembalian/{peminjamanId}', [PengembalianController::class, 'create'])->name('admin.pengembalian.create');
    Route::put('admin/kembalikanBuku/{peminjamanId}', [PengembalianController::class, 'kembalikanBuku'])->name('admin.kembalikanBuku');

    // History / Riwayat
    Route::get('/admin/historyPeminjam', [HistoryController::class, 'history'])->name('admin.historyPeminjam');
    Route::get('/admin/historyPeminjam/{id}', [HistoryController::class, 'detailHistory'])->name('admin.detailPeminjamHistory');
});

require __DIR__ . '/auth.php';
