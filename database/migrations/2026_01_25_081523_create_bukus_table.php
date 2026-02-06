<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->unique()->nullable();
            $table->string('judul');
            $table->foreignId('kategori_id')->constrained('kategori_bukus')->onDelete('restrict');
            $table->foreignId('penulis_id')->constrained('penulis')->onDelete('restrict');
            $table->string('bahasa')->nullable();
            $table->integer('jumlah_halaman')->nullable();
            $table->integer('stok')->default(0);
            $table->string('sampul')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
