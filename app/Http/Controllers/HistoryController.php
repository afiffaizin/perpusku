<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function history(Request $request)
    {
        $search = $request->search;

        $peminjamans = Peminjaman::with('mahasiswa', 'petugas')
            ->where('status', 'dikembalikan')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('mahasiswa', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.historyPeminjaman.historyPeminjaman', compact('peminjamans'));
    }
    // Detail History Peminjaman
    public function detailHistory($id)
    {
        $peminjaman = Peminjaman::with('mahasiswa', 'petugas', 'detailPeminjaman.buku', 'pengembalian')->findOrFail($id);
        return view('admin.historyPeminjaman.detailHistory', compact('peminjaman'));
    }
}
