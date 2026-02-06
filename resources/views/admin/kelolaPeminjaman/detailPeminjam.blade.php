@extends('adminlte::page')

@section('title', 'Detail Peminjam')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1 mt-4">Detail Peminjaman</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-sm mb-0 text-muted" style="background: transparent; padding: 0;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.viewPeminjam') }}" class="text-decoration-none text-muted">Kelola
                            Peminjaman</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Detail: </li>
                </ol>
            </nav>
        </div>
        <div class="mt-md-4">
            <a href="{{ route('admin.viewPeminjam') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="fw-bold ">Daftar Buku Dipinjam</h5>
            <div class="d-flex mb-1">
                <div class="fw-bold" style="width: 80px;">Nama</div>
                <div class="me-2">:</div>
                <div class="fw-bold">{{ $peminjaman->mahasiswa->nama }}</div>
            </div>
            <div class="d-flex mb-2">
                <div class="fw-bold" style="width: 80px;">NIM</div>
                <div class="me-2">:</div>
                <div class="fw-bold">{{ $peminjaman->mahasiswa->nim }}</div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>ISBN</th>
                            <th>Tanggal Jatuh Tempo</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman->detailPeminjaman as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $detail->buku->judul }}</td>
                                <td>{{ $detail->buku->isbn }}</td>
                                <td>{{ $peminjaman->tanggal_jatuh_tempo->translatedFormat('d F Y') }} </td>
                                <td>{{ $detail->jumlah }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <form action="{{ route('admin.kembalikanBuku', $peminjaman->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-outline-success" title="Kembalikan"
                            onclick="return confirm('Konfirmasi pengembalian buku ini?')">
                            <i class="bi bi-box-arrow-in-down me-1"></i>
                            Kembalikan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
