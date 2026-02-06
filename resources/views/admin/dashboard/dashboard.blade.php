{{-- resources/views/test-adminlte.blade.php --}}
@extends('adminlte::page')

@section('title', 'Dashboard Admin')
{{--  linkcss --}}



@section('content_header')
    <h1>Selamat Datang</h1>
@endsection

@section('content')
    {{-- Statistik --}}
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Mahasiswa</h6>
                            <h4 class="fw-bold mb-0">{{ $totalMahasiswa }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Stok Buku</h6>
                            <h4 class="fw-bold mb-0">{{ $stokAwal }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Buku Dipinjam</h6>
                            <h4 class="fw-bold mb-0">{{ $totalDipinjam }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Stok Buku Tersedia</h6>
                            <h4 class="fw-bold mb-0">{{ $totalStok }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- End Statistik --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1">Daftar Mahasiswa</h4>
            <p class="text-muted small mb-0">Kelola Data Mahasiswa Anda di sini.</p>
        </div>
        <a href="/admin/addMahasiswa" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow-sm"> <i
                class="bi bi-plus-lg"></i> Tambah Mahasiswa </a>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Table Mahasiswa --}}
    <div class="table-header-area">
        <form method="GET" action="{{ url()->current() }}">
            <div class="row g-3 align-items-center justify-content-between">
                <div class="col-12 col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 ps-3"><i
                                class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control border-start-0 ps-2" placeholder="Cari buku disini" />
                    </div>
                </div>

                <div class="col-12 col-md-8 text-md-end d-flex gap-2 justify-content-md-end flex-wrap">
                    <div class="d-flex gap-2 ">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 mt-3">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" width="60">No</th>
                    <th>Nama</th>
                    <th class="text-center">NIM</th>
                    <th class="text-center">Kelas</th>
                    <th class="text-center">Prodi</th>
                    <th class="text-center">Angkatan</th>
                    <th class="text-center pe-4" width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mahasiswas as $index => $mhs)
                    <tr>
                        <td class="ps-4">
                            {{ $mahasiswas->firstItem() + $index }}
                        </td>
                        <td class="fw-semibold">
                            {{ $mhs->nama }}
                        </td>
                        <td class="text-center">
                            {{ $mhs->nim }}
                        </td>
                        <td class="text-center">
                            {{ $mhs->kelas }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info text-dark">
                                {{ $mhs->prodi }}
                            </span>
                        </td>
                        <td class="text-center">
                            {{ $mhs->angkatan }}
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group gap-2">
                                <a href="{{ route('admin.mahasiswa.edit', $mhs->id) }}"
                                    class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('admin.mahasiswa.delete', $mhs->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-person-x fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-0">Belum ada data mahasiswa</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-end px-4 py-3">
            {{ $mahasiswas->links('pagination::bootstrap-5') }}
        </div>
    </div>



    {{-- <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form> --}}
@endsection
