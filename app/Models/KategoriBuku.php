<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriBuku extends Model
{
    use HasFactory;

    protected $table = 'kategori_bukus';

    protected $fillable = [
        'nama_kategori',
    ];

    // Relasi ke buku
    public function buku()
    {
        return $this->hasMany(Buku::class, 'kategori_id');
    }
}
