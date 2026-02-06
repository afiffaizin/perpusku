<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    //
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'mahasiswa_id',
        'petugas_id',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'status',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_jatuh_tempo' => 'date',
    ];

    // Relasi ke mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    // Relasi ke petugas
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    // Relasi ke detail peminjaman
    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

    // Relasi ke pengembalian
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }

    // Helper: total buku yang dipinjam
    public function totalBuku()
    {
        return $this->detailPeminjaman->sum('jumlah');
    }
    // Scope: peminjaman aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'dipinjam');
    }

    // Scope: peminjaman selesai
    public function scopeSelesai($query)
    {
        return $query->where('status', 'dikembalikan');
    }
}
