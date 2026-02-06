@extends('adminlte::page')

@section('title', 'Detail Buku')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1 mt-4">Detail Buku</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-sm mb-0 text-muted" style="background: transparent; padding: 0;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.viewBuku') }}" class="text-decoration-none text-muted">Kelola Buku</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Detail: {{ $buku->judul }}</li>
                </ol>
            </nav>
        </div>
        <div class="mt-md-4">
            <a href="{{ route('admin.viewBuku') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('admin.editBuku', $buku->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Data
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                {{-- Gambar --}}
                <div class="col-md-4 text-center mb-4">
                    <div class="p-3 border rounded bg-light">
                        @if ($buku->sampul)
                            <img src="{{ asset('storage/sampul/' . $buku->sampul) }}" alt="{{ $buku->judul }}"
                                class="img-fluid rounded shadow-sm" style="max-height: 400px;">
                        @else
                            <img src="{{ asset('images/no-cover.jpg') }}" alt="No Image"
                                class="img-fluid rounded shadow-sm">
                        @endif
                    </div>
                </div>

                {{-- Informasi Detail --}}
                <div class="col-md-8">
                    <h3 class="fw-bold text-primary mb-3">{{ $buku->judul }}</h3>
                    <hr>

                    <table class="table table-borderless mt-3">
                        <tr>
                            <th width="30%">ISBN</th>
                            <td width="5%">:</td>
                            <td><span class="badge badge-info">{{ $buku->isbn }}</span></td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>:</td>
                            <td>{{ $buku->kategori->nama_kategori ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Penulis</th>
                            <td>:</td>
                            <td>{{ $buku->penulis->nama_penulis ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Halaman</th>
                            <td>:</td>
                            <td>{{ $buku->jumlah_halaman }} Halaman</td>
                        </tr>
                        <tr>
                            <th>Bahasa</th>
                            <td>:</td>
                            <td>{{ $buku->bahasa }}</td>
                        </tr>
                        <tr>
                            <th>Stok Tersedia</th>
                            <td>:</td>
                            <td>
                                @if ($buku->stok > 0)
                                    <span class="text-success fw-bold">{{ $buku->stok }} </span>
                                @else
                                    <span class="text-danger fw-bold">Stok Habis</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <div class="mt-4 p-3 bg-light rounded">
                        <small class="text-muted">Data ini terakhir diperbarui pada:
                            {{ $buku->updated_at->format('d M Y, H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
