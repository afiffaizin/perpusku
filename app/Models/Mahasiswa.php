<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswas';

    protected $fillable = [
        'nim',
        'nama',
        'prodi',
        'angkatan',
        'kelas'
    ];
    // Relasi ke peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
    // Helper: cek apakah mahasiswa sedang pinjam buku
    public function sedangMeminjam()
    {
        return $this->peminjaman()->where('status', 'dipinjam')->exists();
    }

    // Helper: total buku yang sedang dipinjam
    public function totalBukuDipinjam()
    {
        return $this->peminjaman()
            ->where('status', 'dipinjam')
            ->with('detailPeminjaman')
            ->get()
            ->sum(function ($peminjaman) {
                return $peminjaman->detailPeminjaman->sum('jumlah');
            });
    }
}
