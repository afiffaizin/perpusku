<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Penulis;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    // tampilkan daftar buku
    public function index(Request $request)
    {
        $search = $request->search;
        $kategoriFilter = $request->kategori;
        $stokFilter = $request->stok;

        $kategoris = KategoriBuku::orderBy('nama_kategori')->get();

        $bukus = Buku::with('kategori', 'penulis')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                      ->orWhere('isbn', 'like', "%{$search}%")
                      ->orWhereHas('penulis', function ($q2) use ($search) {
                          $q2->where('nama_penulis', 'like', "%{$search}%");
                      });
                });
            })
            ->when($kategoriFilter, function ($query) use ($kategoriFilter) {
                $query->where('kategori_id', $kategoriFilter);
            })
            ->when($stokFilter === 'tersedia', function ($query) {
                $query->where('stok', '>', 0);
            })
            ->when($stokFilter === 'habis', function ($query) {
                $query->where('stok', 0);
            })
            ->orderBy('judul', 'asc')
            ->paginate(10)
            ->withQueryString();

        $totalKategori = KategoriBuku::count();
        $totalBuku = Buku::count();

        return view('buku.index', compact('bukus', 'kategoris', 'totalKategori', 'totalBuku'));
    }

    // tampilkan form tambah buku
    public function create()
    {
        $kategoris = KategoriBuku::orderBy('nama_kategori')->get();
        $penulisList = Penulis::orderBy('nama_penulis')->get();
        return view('buku.create', compact('kategoris', 'penulisList'));
    }

    // tambah buku
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|min:3|max:255',
            'isbn' => 'required|string|max:20|unique:bukus,isbn',
            'kategori' => 'required|string|max:40',
            'penulis' => 'required|string|max:40',
            'bahasa' => 'required|string|max:30',
            'stok' => 'required|integer|min:0',
            'jumlah_halaman' => 'required|integer',
            'sampul' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $kategori = KategoriBuku::firstOrCreate(['nama_kategori' => $validated['kategori']]);
        $penulis = Penulis::firstOrCreate(['nama_penulis' => $validated['penulis']]);

        $fileName = null;
        if ($request->hasFile('sampul')) {
            $file = $request->file('sampul');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('sampul', $fileName, 'public');
        }

        Buku::create([
            'isbn' => $validated['isbn'],
            'judul' => $validated['judul'],
            'kategori_id' => $kategori->id,
            'penulis_id' => $penulis->id,
            'bahasa' => $validated['bahasa'],
            'jumlah_halaman' => $validated['jumlah_halaman'],
            'stok' => $validated['stok'],
            'sampul' => $fileName,
        ]);

        return redirect()->route('admin.viewBuku')->with('success', 'Buku berhasil ditambahkan!');
    }

    // edit buku
    public function edit($id)
    {
        $buku = Buku::with('kategori', 'penulis')->findOrFail($id);
        $kategoris = KategoriBuku::orderBy('nama_kategori')->get();
        $penulisList = Penulis::orderBy('nama_penulis')->get();
        return view('buku.edit', compact('buku', 'kategoris', 'penulisList'));
    }

    // Update buku
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $validated = $request->validate([
            'judul' => 'required|string|min:3|max:255',
            'isbn' => 'required|string|max:20|unique:bukus,isbn,' . $id,
            'kategori' => 'required|string|max:40',
            'penulis' => 'required|string|max:40',
            'bahasa' => 'required|string|max:30',
            'stok' => 'required|integer|min:0',
            'jumlah_halaman' => 'required|integer|min:1',
            'sampul' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $kategori = KategoriBuku::firstOrCreate(['nama_kategori' => $validated['kategori']]);
        $penulis = Penulis::firstOrCreate(['nama_penulis' => $validated['penulis']]);

        $fileName = $buku->sampul;
        if ($request->hasFile('sampul')) {
            if ($buku->sampul && Storage::disk('public')->exists('sampul/' . $buku->sampul)) {
                Storage::disk('public')->delete('sampul/' . $buku->sampul);
            }
            $file = $request->file('sampul');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('sampul', $fileName, 'public');
        }

        $buku->update([
            'isbn' => $validated['isbn'],
            'judul' => $validated['judul'],
            'kategori_id' => $kategori->id,
            'penulis_id' => $penulis->id,
            'bahasa' => $validated['bahasa'],
            'jumlah_halaman' => $validated['jumlah_halaman'],
            'stok' => $validated['stok'],
            'sampul' => $fileName,
        ]);

        return redirect()->route('admin.viewBuku')->with('success', 'Buku berhasil diperbarui!');
    }

    // Hapus buku
    public function destroy($id)
    {
        try {
            $buku = Buku::findOrFail($id);
            $buku->delete();
            return redirect()->back()->with('success', 'Buku berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus buku ini, Karena ada mahasiswa yang sedang meminjam buku ini!!');
        }
    }

    // detail buku
    public function show($id)
    {
        $buku = Buku::with('kategori', 'penulis')->findOrFail($id);
        return view('buku.show', compact('buku'));
    }
}
