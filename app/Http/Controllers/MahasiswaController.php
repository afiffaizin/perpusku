<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\DetailPeminjaman;

class MahasiswaController extends Controller
{
    // Dashboard — now handled by DashboardController
    // This index now shows mahasiswa list page
    public function index(Request $request)
    {
        $search = $request->search;

        $mahasiswas = Mahasiswa::withCount(['peminjaman' => function ($query) {
                $query->where('status', 'dipinjam');
            }])
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%");
            })
            ->orderBy('nama', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('mahasiswa.index', compact('mahasiswas'));
    }

    // Tampilkan form tambah Mahasiswa
    public function create()
    {
        return view('mahasiswa.create');
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

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan!');
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
        return view('mahasiswa.edit', compact('mahasiswa'));
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

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data Mahasiswa berhasil diperbarui!');
    }
}
