<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class peminjamController extends Controller
{
    public function create()
    {
        $mahasiswas = Mahasiswa::select('id', 'nama')
            ->orderBy('nama', 'asc')
            ->get();

        $bukus = Buku::tersedia()
            ->with('penulis')
            ->with('kategori')
            ->select('id', 'judul', 'isbn', 'stok', 'penulis_id', 'kategori_id', 'sampul')
            ->orderBy('judul')
            ->get();

        return view('admin.kelolaPeminjaman.addPeminjam', compact('mahasiswas', 'bukus'));
    }


    // Logic untuk menyimpan data peminjaman akan ditambahkan di sini

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'lama_pinjam' => 'required|integer|min:1|max:30',
            'buku_ids' => 'required|array|min:1',
            'buku_ids.*' => 'exists:bukus,id',
            'jumlah'       => 'required|array|min:1',
            'jumlah.*'     => 'required|integer|min:1',
        ]);
        // Cek Stok Buku
        foreach ($validated['buku_ids'] as $buku_id) {
            $buku = Buku::find($buku_id);
            if (!$buku || !$buku->isTersedia()) {
                return back()->withErrors(['buku_ids' => "Buku dengan ID {$buku_id} tidak tersedia."])->withInput();
            }
        }

        // Hitung tanggal jatuh tempo
        $tanggal_pinjam = Carbon::now();
        $tanggal_jatuh_tempo = $tanggal_pinjam->copy()->addDays((int)$validated['lama_pinjam']);

        // Simpan data peminjaman
        $peminjaman = Peminjaman::create([
            'mahasiswa_id' => $validated['mahasiswa_id'],
            'petugas_id' =>  Auth::id(),
            'tanggal_pinjam' => $tanggal_pinjam,
            'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
            'status' => 'dipinjam',
        ]);

        // Simpan data detail peminjaman, jumlah setiap buku dan kurangi stok buku
        foreach ($validated['buku_ids'] as $buku_id) {
            $buku = Buku::find($buku_id);
            $peminjaman->detailPeminjaman()->create([
                'buku_id' => $buku_id,
                'jumlah' => $validated['jumlah'][$buku_id],
            ]);
            $buku->kurangiStok($validated['jumlah'][$buku_id]);
        }
        return redirect()->route('admin.viewPeminjam')->with('success', 'Peminjaman berhasil disimpan!');
    }

    // Tampilkan data peminjaman
    public function index(Request $request)
    {
        $search = $request->search;

        $peminjamans = Peminjaman::with('mahasiswa', 'petugas')
            ->where('status', 'dipinjam')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('mahasiswa', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            })
            ->orderBy('tanggal_pinjam', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kelolaPeminjaman.viewPeminjaman', compact('peminjamans'));
    }


    // Detail Peminjaman
    public function show($id)
    {
        $peminjaman = Peminjaman::with('mahasiswa', 'petugas', 'detailPeminjaman.buku')->findOrFail($id);
        return view('admin.kelolaPeminjaman.detailPeminjam', compact('peminjaman'));
    }
}
