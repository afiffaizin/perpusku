@extends('adminlte::page')

@section('title', 'History Peminjaman')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mt-4 mb-1">History Peminjaman Buku</h4>
            <p class="text-muted small mb-0">
                Daftar buku yang telah dikembalikan oleh mahasiswa
            </p>
        </div>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter --}}

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


    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle mt-3">
            <thead class="table-light">
                <tr>
                    <th width="60">No</th>
                    <th>Nama Mahasiswa</th>
                    <th class="text-center">Petugas</th>
                    <th class="text-center">Tanggal Pinjam</th>
                    <th class="text-center">Tanggal Dikembalikan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamans as $pinjam)
                    <tr>
                        <td>
                            {{ $peminjamans->firstItem() + $loop->index }}
                        </td>
                        <td>
                            <div class="fw-bold">{{ $pinjam->mahasiswa->nama }}</div>
                            <small class="text-muted">{{ $pinjam->mahasiswa->nim }}</small>
                        </td>
                        <td class="text-center">
                            {{ $pinjam->petugas->name ?? '-' }}
                        </td>
                        <td class="text-center">
                            {{ $pinjam->tanggal_pinjam->translatedFormat('d F Y') }}
                        </td>
                        <td class="text-center">
                            {{ $pinjam->updated_at->translatedFormat('d F Y') }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success">Dikembalikan</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.detailPeminjamHistory', $pinjam->id) }}"
                                class="btn btn-sm btn-outline-info" title="Detail">
                                <i class="bi bi-info-circle"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-clock-history fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-0">
                                Belum ada history peminjaman
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-end mt-3">
            {{ $peminjamans->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
