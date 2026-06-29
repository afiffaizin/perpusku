@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0" style="font-size:14px;">
            <li class="breadcrumb-item"><a href="{{ route('admin.mahasiswa.index') }}" style="color:var(--clr-primary);">Mahasiswa</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
@endsection

@section('content')
    <x-page-header title="Tambah Mahasiswa" subtitle="Isi formulir untuk menambahkan mahasiswa baru" />

    <div class="row">
        <div class="col-lg-7">
            <x-form-card title="Data Mahasiswa">
                <form action="{{ route('admin.storeMahasiswa') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label-custom">Nama <span style="color:var(--clr-danger);">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="form-input @error('nama') is-invalid @enderror" placeholder="Nama lengkap mahasiswa">
                        @error('nama') <div class="invalid-feedback-custom">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">NIM <span style="color:var(--clr-danger);">*</span></label>
                        <input type="text" name="nim" value="{{ old('nim') }}" class="form-input @error('nim') is-invalid @enderror" placeholder="Nomor Induk Mahasiswa">
                        @error('nim') <div class="invalid-feedback-custom">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label-custom">Kelas <span style="color:var(--clr-danger);">*</span></label>
                            <input type="text" name="kelas" value="{{ old('kelas') }}" class="form-input @error('kelas') is-invalid @enderror" placeholder="Contoh: TI-2A">
                            @error('kelas') <div class="invalid-feedback-custom">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Prodi <span style="color:var(--clr-danger);">*</span></label>
                            <select name="prodi" class="form-select-custom @error('prodi') is-invalid @enderror">
                                <option value="">Pilih Prodi</option>
                                <option value="TRPL" {{ old('prodi') == 'TRPL' ? 'selected' : '' }}>TRPL</option>
                            </select>
                            @error('prodi') <div class="invalid-feedback-custom">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Angkatan <span style="color:var(--clr-danger);">*</span></label>
                        <input type="number" name="angkatan" value="{{ old('angkatan') }}" class="form-input @error('angkatan') is-invalid @enderror" placeholder="Contoh: 2024">
                        @error('angkatan') <div class="invalid-feedback-custom">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex gap-2 pt-3">
                        <a href="{{ route('admin.mahasiswa.index') }}" class="btn-secondary-custom">Batal</a>
                        <button type="submit" class="btn-primary-custom">
                            <i class="bi bi-check-lg"></i> Simpan
                        </button>
                    </div>
                </form>
            </x-form-card>
        </div>
    </div>
@endsection
