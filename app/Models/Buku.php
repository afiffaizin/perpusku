<?php

namespace App\Models;

use App\Models\KategoriBuku;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Buku extends Model
{
    use HasFactory;
    protected $table = 'bukus';
    protected $fillable = [
        'isbn',
        'judul',
        'kategori_id',
        'penulis_id',
        'bahasa',
        'jumlah_halaman',
        'stok',
        'sampul',
    ];

    protected $casts = [
        'jumlah_halaman' => 'integer',
        'stok' => 'integer',
    ];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'kategori_id');
    }

    // Relasi ke penulis
    public function penulis()
    {
        return $this->belongsTo(Penulis::class, 'penulis_id');
    }

    // Relasi ke detail peminjaman
    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

    // Helper: cek apakah buku tersedia
    public function isTersedia()
    {
        return $this->stok > 0;
    }

    // Helper: kurangi stok
    public function kurangiStok($jumlah)
    {
        if ($this->stok >= $jumlah) {
            $this->decrement('stok', $jumlah);
            return true;
        }
        return false;
    }

    // Helper: tambah stok
    public function tambahStok($jumlah)
    {
        $this->increment('stok', $jumlah);
    }

    // Scope: buku yang tersedia
    public function scopeTersedia($query)
    {
        return $query->where('stok', '>', 0);
    }
}
