<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\peminjamController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PengembalianController;



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Route khusus admin
Route::get('/', function () {
    return view('admin.login.login');
});

Route::middleware(['auth', 'admin'])->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard.dashboard');
    })->name('admin.dashboard');
    Route::get('/admin/dashboard', [MahasiswaController::class, 'index'])->name('admin.dashboard'); // Tmpil data mahasiswa
    Route::get('/admin/addMahasiswa', [MahasiswaController::class, 'create'])->name('admin.addMahasiswa'); //Form tambah
    Route::post('/admin/addMahasiswa', [MahasiswaController::class, 'store'])->name('admin.storeMahasiswa'); //Simpan data
    Route::delete('/admin/mahasiswa/{id}', [MahasiswaController::class, 'destroy'])->name('admin.mahasiswa.delete'); //Hapus
    Route::get('/admin/mahasiswa/edit/{id}', [MahasiswaController::class, 'edit'])->name('admin.mahasiswa.edit'); //Edit
    Route::put('/admin/mahasiswa/edit/{id}', [MahasiswaController::class, 'update'])->name('admin.updateMahasiswa'); //Update

    // Tambah Buku
    Route::get('/admin/tambahBuku', [BukuController::class, 'create'])->name('admin.tambahBuku');
    Route::post('/admin/tambahBuku', [BukuController::class, 'store'])->name('admin.storeBuku');
    Route::get('/admin/viewBuku', [BukuController::class, 'index'])->name('admin.viewBuku');
    Route::get('/admin/editBuku/{id}', [BukuController::class, 'edit'])->name('admin.editBuku');
    Route::put('/admin/editBuku/{id}', [BukuController::class, 'update'])->name('admin.updateBuku');
    Route::delete('/admin/deleteBuku/{id}', [BukuController::class, 'destroy'])->name('admin.deleteBuku');
    Route::get('/admin/detailBuku/{id}', [BukuController::class, 'show'])->name('admin.detailBuku');

    // Kelola Peminjaman
    Route::get('/admin/viewPeminjam', [peminjamController::class, 'index'])->name('admin.viewPeminjam');
    Route::get('/admin/addPeminjam', [peminjamController::class, 'create'])->name('admin.tambahPeminjam');
    Route::post('/admin/addPeminjam', [peminjamController::class, 'store'])->name('admin.storePeminjam');
    Route::get('/admin/detailPeminjam/{id}', [PeminjamController::class, 'show'])->name('admin.detailPeminjam');


    // Pengembalian
    Route::put('admin/kembalikanBuku/{peminjamanId}', [PengembalianController::class, 'kembalikanBuku'])->name('admin.kembalikanBuku');

    // History
    Route::get('/admin/historyPeminjam', [HistoryController::class, 'history'])->name('admin.historyPeminjam');
    Route::get('/admin/historyPeminjam/{id}', [HistoryController::class, 'detailHistory'])->name('admin.detailPeminjamHistory');



    // Route::get('/admin/tambahPeminjam', function () {
    //     return view('admin.tambahPeminjam');
    // })->name('admin.tambahPeminjam');
});

require __DIR__ . '/auth.php';
