@extends('adminlte::page')

@section('title', 'Edit Buku')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1 mt-4">Edit Buku</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-sm mb-0 text-muted" style="background: transparent; padding: 0;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.viewBuku') }}" class="text-decoration-none text-muted">kelola Buku</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Buku</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            {{-- Alert sukses --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.updateBuku', $buku->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Judul Buku --}}
                <div class="mb-3">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $buku->judul) }}">
                    @error('judul')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- ISBN --}}
                <div class="mb-3">
                    <label>ISBN</label>
                    <input type="text" name="isbn" class="form-control" value="{{ old('isbn', $buku->isbn) }}">
                    @error('isbn')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Kategori Buku --}}
                <div class="mb-3">
                    <label>Kategori Buku</label>
                    <input type="text" name="kategori" class="form-control"
                        value="{{ old('kategori', $buku->kategori->nama_kategori) }}">
                    @error('kategori ')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Penulis --}}
                <div class="mb-3">
                    <label>Penulis</label>
                    <input type="text" name="penulis" class="form-control"
                        value="{{ old('penulis', $buku->penulis->nama_penulis) }}">
                    @error('penulis')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Sampul Buku --}}
                <div class="mb-3">
                    <label>Sampul Buku</label>
                    <input type="file" name="sampul" class="form-control">
                    @error('sampul')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Jumlah Halaman --}}
                <div class="mb-3">
                    <label>Jumlah Halaman</label>
                    <input type="number" name="jumlah_halaman" class="form-control"
                        value="{{ old('jumlah_halaman', $buku->jumlah_halaman) }}">
                    @error('jumlah_halaman')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Bahasa Buku --}}
                <div class="mb-3">
                    <label>Bahasa Buku</label>
                    <input type="text" name="bahasa" class="form-control" value="{{ old('bahasa', $buku->bahasa) }}">
                    @error('bahasa')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Stok --}}
                <div class="mb-3">
                    <label>Stok</label>
                    <input type="number" name="stok" class="form-control" value="{{ old('stok', $buku->stok) }}">
                    @error('stok')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning">Update Data</button>
                <a href="{{ route('admin.viewBuku') }}" class="btn btn-secondary">Kembali</a>
            </form>

        </div>
    </div>
@endsection
