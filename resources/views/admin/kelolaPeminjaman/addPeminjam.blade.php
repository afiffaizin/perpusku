@extends('adminlte::page')

@section('title', 'Add Peminjam')

@section('content_header')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-2 gap-3">
        <div>
            <h4 class="fw-bold mb-1">Tambah Data Peminjam</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-sm mb-0 text-muted" style="background: transparent; padding: 0;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.viewPeminjam') }}" class="text-decoration-none text-muted">
                            Kelola Peminjam
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tambah Peminjam
                    </li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title text-white">Form Peminjaman Buku</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.storePeminjam') }}" method="POST">
                @csrf
                <!-- Row untuk Mahasiswa dan Buku berjejer -->
                <div class="row">

                    <!-- Pilih Mahasiswa -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Mahasiswa <span class="text-danger">*</span></label>

                        <select name="mahasiswa_id" id="mahasiswa_id" class="form-control select2" required>
                            <option value="">-- Pilih Mahasiswa --</option>
                            @foreach ($mahasiswas as $mhs)
                                <option value="{{ $mhs->id }}" {{ old('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>
                                    {{ $mhs->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('mahasiswa_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        {{-- Lama Peminjaman --}}
                        <label class="fw-bold">Lama Peminjaman (Hari)</label>
                        <input type="number" name="lama_pinjam" id="lama_pinjam" class="form-control" min="1"
                            value="1" required>
                    </div>

                    <!-- Pilih Buku (Multiple) -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Judul Buku <span class="text-danger">*</span></label>

                        <select name="buku_ids[]" id="buku_ids" class="form-control js-example-basic-multiple" multiple
                            required>

                            @foreach ($bukus as $buku)
                                <option value="{{ $buku->id }}" data-judul="{{ $buku->judul }}"
                                    data-penulis="{{ $buku->penulis->nama_penulis ?? '-' }}" data-isbn="{{ $buku->isbn }}"
                                    data-kategori="{{ $buku->kategori->nama_kategori ?? '-' }}"
                                    data-stok="{{ $buku->stok }}"
                                    data-sampul="{{ asset('storage/sampul/' . $buku->sampul) }}">
                                    {{ $buku->judul }}
                                </option>
                            @endforeach
                        </select>

                        @error('buku_ids')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>



                    <!-- Detail Buku yang Dipilih -->
                    <div id="detail-buku-container" class="mt-4">
                        <h5 class="fw-bold mb-3">Detail Buku yang Dipilih</h5>
                        <div id="detail-buku-list" class="row">
                            <!-- Detail buku akan muncul di sini -->
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Peminjaman
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
            </form>
        </div>
    </div>
@endsection
