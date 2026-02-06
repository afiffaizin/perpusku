@extends('adminlte::page')

@section('title', 'Add Mahasiswa')
@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1 mt-4">Tambah Data Mahasiswa</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-sm mb-0 text-muted" style="background: transparent; padding: 0;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Mahasiswa</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Form add mahasiswa --}}
    <div class="card-body">

        {{-- Alert sukses --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.storeMahasiswa') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}">
                @error('nama')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>NIM</label>
                <input type="text" name="nim" class="form-control" value="{{ old('nim') }}">
                @error('nim')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Kelas</label>
                <input type="text" name="kelas" class="form-control" value="{{ old('kelas') }}">
                @error('kelas')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Prodi</label>
                <select name="prodi" class="form-select">
                    <option value=""> Pilih Prodi </option>
                    <option value="TRPL" {{ old('prodi') == 'TRPL' ? 'selected' : '' }}>TRPL</option>
                </select>
                @error('prodi')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Angkatan</label>
                <input type="number" name="angkatan" class="form-control" value="{{ old('angkatan') }}">
                @error('angkatan')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
        </form>

    </div>
    </div>

@endsection
