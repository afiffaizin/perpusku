<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\DetailPeminjaman;
use Illuminate\Auth\Events\Validated;


class MahasiswaController extends Controller
{
    // ambil jumlah Mahasiswa
    public function index(Request $request)
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalStok = Buku::sum('stok');
        $totalDipinjam = DetailPeminjaman::whereHas('peminjaman', function ($query) {
            $query->where('status', 'dipinjam');
        })->sum('jumlah');

        $stokAwal = $totalDipinjam + $totalStok;



        // Tampilkan data mahasiswa di dashboard 
        $mahasiswas = Mahasiswa::latest()->paginate(10);

        $search = $request->search;

        $mahasiswas = Mahasiswa::when($search, function ($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('nim', 'like', "%{$search}%");
        })
            ->orderBy('nama', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.dashboard.dashboard', compact('totalMahasiswa', 'mahasiswas', 'totalStok', 'totalDipinjam', 'stokAwal'));
    }

    // Tampilkan form tambah Mahasiswa
    public function create()
    {
        return view('admin.dashboard.addMahasiswa');
    }

    // Create data Mahasiswa
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'nim' => 'required|string|unique:mahasiswas,nim',
            'kelas' => 'required|string|max:20',
            'prodi' => 'required|in:TRPL',
            'angkatan' => 'required|integer',
        ]);

        Mahasiswa::create($validated);

        return redirect()->back()->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    // Hapus data Mahasiswa
    public function destroy($id)
    {
        try {
            $mahasiswa = Mahasiswa::findOrFail($id);
            $mahasiswa->delete();
            return redirect()->back()->with('success', 'Mahasiswa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus Mahasiswa, karena Mahasiswa sedang meminjam Buku!!');
        }
    }

    // Edit data Mahasiswa
    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('admin.dashboard.editMahasiswa', compact('mahasiswa'));
    }

    // Update data Mahasiswa
    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|unique:mahasiswas,nim,' . $mahasiswa->id,
            'kelas' => 'required|string|max:255',
            'prodi' => 'required|in:TRPL',
            'angkatan' => 'required|integer',
        ]);

        $mahasiswa->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Data Mahasiswa berhasil diperbarui!');
    }
}
