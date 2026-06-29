@extends('admin.layouts.admin')

@section('title', 'Edit Mahasiswa')
@section('page-title', 'Edit Mahasiswa')

@section('content')
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700 transition-colors">Dashboard</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 font-medium">Edit Mahasiswa</span>
    </nav>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('admin.updateMahasiswa', $mahasiswa->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1.5">Nama</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $mahasiswa->nama) }}"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition @error('nama') border-red-300 @enderror">
                    @error('nama') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="nim" class="block text-sm font-medium text-gray-700 mb-1.5">NIM</label>
                    <input type="text" id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition @error('nim') border-red-300 @enderror">
                    @error('nim') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="kelas" class="block text-sm font-medium text-gray-700 mb-1.5">Kelas</label>
                    <input type="text" id="kelas" name="kelas" value="{{ old('kelas', $mahasiswa->kelas) }}"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition @error('kelas') border-red-300 @enderror">
                    @error('kelas') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="prodi" class="block text-sm font-medium text-gray-700 mb-1.5">Prodi</label>
                    <select id="prodi" name="prodi"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition @error('prodi') border-red-300 @enderror">
                        <option value="">Pilih Prodi</option>
                        <option value="TRPL" {{ old('prodi', $mahasiswa->prodi) == 'TRPL' ? 'selected' : '' }}>TRPL</option>
                    </select>
                    @error('prodi') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="angkatan" class="block text-sm font-medium text-gray-700 mb-1.5">Angkatan</label>
                    <input type="number" id="angkatan" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan) }}"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition @error('angkatan') border-red-300 @enderror">
                    @error('angkatan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg transition-colors">Update Data</button>
                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-lg transition-colors">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
