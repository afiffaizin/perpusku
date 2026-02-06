@extends('adminlte::page')

@section('title', 'Edit Mahasiswa')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1 mt-4">Edit Data Mahasiswa</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-sm mb-0 text-muted" style="background: transparent; padding: 0;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Mahasiswa</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Card Container --}}
    <div class="card shadow-sm">
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Form Edit Mahasiswa --}}
            <form action="{{ route('admin.updateMahasiswa', $mahasiswa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $mahasiswa->nama) }}">
                    @error('nama')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>NIM</label>
                    <input type="text" name="nim" class="form-control" value="{{ old('nim', $mahasiswa->nim) }}">
                    @error('nim')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Kelas</label>
                    <input type="text" name="kelas" class="form-control" value="{{ old('kelas', $mahasiswa->kelas) }}">
                    @error('kelas')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Prodi</label>
                    <select name="prodi" class="form-select">
                        <option value=""> Pilih Prodi </option>
                        {{-- Logika selected untuk edit --}}
                        <option value="TRPL" {{ old('prodi', $mahasiswa->prodi) == 'TRPL' ? 'selected' : '' }}>TRPL
                        </option>
                        {{-- Tambahkan opsi lain jika ada --}}
                    </select>
                    @error('prodi')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Angkatan</label>
                    <input type="number" name="angkatan" class="form-control"
                        value="{{ old('angkatan', $mahasiswa->angkatan) }}">
                    @error('angkatan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-warning">Update Data</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>

        </div>
    </div>
@endsection
