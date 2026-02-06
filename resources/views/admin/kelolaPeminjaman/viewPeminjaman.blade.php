@extends('adminlte::page')

@section('title', 'Daftar Peminjaman')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mt-4 mb-1">Daftar Peminjaman Buku</h4>
            <p class="text-muted small mb-0">Kelola Data Peminjaman Buku Perpustakaan Anda di sini.</p>
        </div>
        <a href="{{ route('admin.tambahPeminjam') }}" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow-sm">
            <i class="bi bi-plus-lg"></i> Tambah Peminjam
        </a>
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
    {{-- Table Peminjaman --}}
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
                    <th class="text-center">Petugas</th>
                    <th class="text-center">Tanggal Pinjam</th>
                    <th class="text-center">Tanggal Jatuh Tempo</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" width="120">Aksi</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamans as $pinjam)
                    <tr>
                        <td class="ps-4">
                            {{ $peminjamans->firstItem() + $loop->index }}
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $pinjam->mahasiswa->nama }}</div>
                        </td>
                        <td class="text-center">{{ $pinjam->petugas->name }}</td>
                        <td class="text-center">{{ $pinjam->tanggal_pinjam->translatedFormat('d F Y') }}</td>
                        <td class="text-center">{{ $pinjam->tanggal_jatuh_tempo->translatedFormat('d F Y') }}</td>

                        <td class="text-center">
                            @if ($pinjam->status === 'dipinjam')
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                            @else
                                <span class="badge bg-success">Dikembalikan</span>
                            @endif
                        </td>
                        <td class="text-center pe-4">
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('admin.detailPeminjam', $pinjam->id) }}"
                                    class="btn btn-sm btn-outline-info" title="Detail">
                                    <i class="bi bi-info-circle"></i>
                                </a>
                                <form action="{{ route('admin.kembalikanBuku', $pinjam->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Kembalikan"
                                        onclick="return confirm('Konfirmasi pengembalian buku ini?')">
                                        <i class="bi bi-box-arrow-in-down"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-person-x fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-0">Belum ada data peminjaman</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-end px-4 py-3">
            {{ $peminjamans->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
    </div>
    </div>
@endsection
