<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Penulis;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    // tambah buku
    public function store(Request $request)
    {
        // Validasi inputan
        $validated = $request->validate([
            'judul' => 'required|string|min:10|max:30',
            'isbn' => 'required|string|max:20|unique:bukus,isbn',
            'kategori' => 'required|string|max:40',
            'penulis' => 'required|string|max:40',
            'bahasa' => 'required|string|max:30',
            'stok' => 'required|integer|min:0',
            'jumlah_halaman' => 'required|integer',
            'sampul' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Cari atau buat kategori
        $kategori = KategoriBuku::firstOrCreate(['nama_kategori' => $validated['kategori']]);

        // Cari atau buat penulis
        $penulis = Penulis::firstOrCreate(['nama_penulis' => $validated['penulis']]);

        // Handle file upload
        $fileName = null;
        if ($request->hasFile('sampul')) {
            $file = $request->file('sampul');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('sampul', $fileName, 'public');
        }

        // Siapkan data untuk database
        $bukuData = [
            'isbn' => $validated['isbn'],
            'judul' => $validated['judul'],
            'kategori_id' => $kategori->id,
            'penulis_id' => $penulis->id,
            'bahasa' => $validated['bahasa'],
            'jumlah_halaman' => $validated['jumlah_halaman'],
            'stok' => $validated['stok'],
            'sampul' => $fileName,
        ];


        Buku::create($bukuData);
        return redirect()->back()->with('success', 'Buku berhasil ditambahkan!');
    }

    // tampilkan form tambah tambahBuku
    public function create()
    {
        return view('admin.kelolaBuku.addBuku');
    }

    // tampilkan daftar buku
    public function index(Request $request)
    {
        $search = $request->search;
        $bukus = Buku::with('kategori', 'penulis')
            ->when($search, function ($query) use ($search) {
                $query->where('judul', 'like', "%{$search}%");
            })
            ->orderBy('judul', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kelolaBuku.viewBuku', compact('bukus'));
    }

    // edit buku
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('admin.kelolaBuku.editBuku', compact('buku'));
    }

    // Update buku
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $validated = $request->validate([
            'judul' => 'required|string|min:10|max:30',
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

        // Handle file upload
        $fileName = $buku->sampul;

        if ($request->hasFile('sampul')) {
            // Hapus sampul lama jika ada
            if ($buku->sampul && Storage::disk('public')->exists('sampul/' . $buku->sampul)) {
                Storage::disk('public')->delete('sampul/' . $buku->sampul);
            }

            // Upload sampul baru
            $file = $request->file('sampul');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('sampul', $fileName, 'public');
        }

        // UPDATE DATA BUKU
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
        return view('admin.kelolaBuku.detailBuku', compact('buku'));
    }
}
