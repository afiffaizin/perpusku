<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    public function kembalikanBuku($peminjamanId)
    {

        $peminjaman = Peminjaman::with('detailPeminjaman.buku')->findOrFail($peminjamanId);

        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error', 'Buku sudah dikembalikan');
        }

        DB::transaction(function () use ($peminjaman) {

            foreach ($peminjaman->detailPeminjaman as $detail) {
                $detail->buku->tambahStok($detail->jumlah);
            }

            $peminjaman->update([
                'status' => 'dikembalikan'
            ]);

            Pengembalian::create([
                'peminjaman_id'  => $peminjaman->id,
                'tanggal_kembali' => Carbon::now()
            ]);
        });
        return redirect()->route('admin.viewPeminjam')->with('success', 'Buku berhasil dikembalikan.');
    }
}
