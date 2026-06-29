@extends('admin.layouts.admin')

@section('title', 'Edit Buku')
@section('page-title', 'Edit Buku')

@section('content')
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.viewBuku') }}" class="hover:text-gray-700 transition-colors">Kelola Buku</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 font-medium">Edit Buku</span>
    </nav>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('admin.updateBuku', $buku->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul Buku</label>
                    <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition @error('judul') border-red-300 @enderror">
                    @error('judul') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn', $buku->isbn) }}"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition @error('isbn') border-red-300 @enderror">
                    @error('isbn') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori Buku</label>
                        <input type="text" name="kategori" value="{{ old('kategori', $buku->kategori->nama_kategori) }}"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition @error('kategori') border-red-300 @enderror">
                        @error('kategori') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Penulis</label>
                        <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis->nama_penulis) }}"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition @error('penulis') border-red-300 @enderror">
                        @error('penulis') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Sampul Buku</label>
                    @if ($buku->sampul)
                        <div class="mb-3">
                            <img src="{{ asset('storage/sampul/' . $buku->sampul) }}" alt="{{ $buku->judul }}"
                                 class="w-20 h-28 object-cover rounded-lg border border-gray-200">
                        </div>
                    @endif
                    <input type="file" name="sampul"
                           class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-medium file:bg-slate-800 file:text-white hover:file:bg-slate-900 focus:outline-none @error('sampul') border-red-300 @enderror">
                    @error('sampul') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah Halaman</label>
                        <input type="number" name="jumlah_halaman" value="{{ old('jumlah_halaman', $buku->jumlah_halaman) }}"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition @error('jumlah_halaman') border-red-300 @enderror">
                        @error('jumlah_halaman') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Bahasa</label>
                        <input type="text" name="bahasa" value="{{ old('bahasa', $buku->bahasa) }}"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition @error('bahasa') border-red-300 @enderror">
                        @error('bahasa') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition @error('stok') border-red-300 @enderror">
                        @error('stok') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg transition-colors">Update Data</button>
                    <a href="{{ route('admin.viewBuku') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-lg transition-colors">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
