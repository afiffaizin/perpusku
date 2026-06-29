<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\DetailPeminjaman;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswas = Mahasiswa::all();
        $bukus = Buku::where('stok', '>', 0)->get();
        $admin = User::where('role', 'admin')->first();

        for ($i = 0; $i < 50; $i++) {
            $mahasiswa = $mahasiswas->random();
            $tanggalPinjam = Carbon::now()->subDays(rand(1, 60));
            $lamaPinjam = rand(7, 14);
            $tanggalJatuhTempo = $tanggalPinjam->copy()->addDays($lamaPinjam);

            // First 25 active, last 25 returned
            $isDikembalikan = $i >= 25;

            $peminjaman = Peminjaman::create([
                'mahasiswa_id' => $mahasiswa->id,
                'petugas_id' => $admin->id,
                'tanggal_pinjam' => $tanggalPinjam,
                'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
                'status' => $isDikembalikan ? 'dikembalikan' : 'dipinjam',
            ]);

            // 1-3 books per peminjaman
            $jumlahBuku = rand(1, 3);
            $availableBooks = $bukus->where('stok', '>', 0);

            if ($availableBooks->isEmpty()) {
                continue;
            }

            $selectedBooks = $availableBooks->random(min($jumlahBuku, $availableBooks->count()));

            // Ensure collection
            if (!$selectedBooks instanceof \Illuminate\Support\Collection) {
                $selectedBooks = collect([$selectedBooks]);
            }

            foreach ($selectedBooks as $buku) {
                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'buku_id' => $buku->id,
                    'jumlah' => 1,
                ]);

                // Decrement stock for active loans only
                if (!$isDikembalikan) {
                    $buku->decrement('stok');
                }
            }

            // Create pengembalian record for returned loans
            if ($isDikembalikan) {
                $tanggalKembali = $tanggalJatuhTempo->copy()->subDays(rand(0, 3));
                Pengembalian::create([
                    'peminjaman_id' => $peminjaman->id,
                    'tanggal_kembali' => $tanggalKembali,
                ]);
            }
        }
    }
}
