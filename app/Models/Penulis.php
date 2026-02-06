<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penulis extends Model
{
    use HasFactory;

    protected $table = 'penulis';

    protected $fillable = [
        'nama_penulis',
    ];

    // Relasi ke buku
    public function buku()
    {
        return $this->hasMany(Buku::class, 'penulis_id');
    }
}
