@extends('admin.layouts.admin')

@section('title', 'Detail Buku')
@section('page-title', 'Detail Buku')

@section('content')
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.viewBuku') }}" class="hover:text-gray-700 transition-colors">Kelola Buku</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 font-medium">{{ $buku->judul }}</span>
    </nav>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Cover --}}
            <div class="md:w-1/3 flex-shrink-0">
                <div class="bg-gray-50 rounded-xl border border-gray-200 p-4 flex items-center justify-center">
                    @if ($buku->sampul)
                        <img src="{{ asset('storage/sampul/' . $buku->sampul) }}" alt="{{ $buku->judul }}"
                             class="max-h-80 rounded-lg shadow-sm">
                    @else
                        <div class="w-full h-64 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Info --}}
            <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-900 mb-6">{{ $buku->judul }}</h2>

                <dl class="space-y-4">
                    <div class="flex items-start">
                        <dt class="w-36 text-sm text-gray-500 flex-shrink-0">ISBN</dt>
                        <dd class="text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">{{ $buku->isbn }}</span>
                        </dd>
                    </div>
                    <div class="flex items-start">
                        <dt class="w-36 text-sm text-gray-500 flex-shrink-0">Kategori</dt>
                        <dd class="text-sm text-gray-900">{{ $buku->kategori->nama_kategori ?? '-' }}</dd>
                    </div>
                    <div class="flex items-start">
                        <dt class="w-36 text-sm text-gray-500 flex-shrink-0">Penulis</dt>
                        <dd class="text-sm text-gray-900">{{ $buku->penulis->nama_penulis ?? '-' }}</dd>
                    </div>
                    <div class="flex items-start">
                        <dt class="w-36 text-sm text-gray-500 flex-shrink-0">Jumlah Halaman</dt>
                        <dd class="text-sm text-gray-900">{{ $buku->jumlah_halaman }} Halaman</dd>
                    </div>
                    <div class="flex items-start">
                        <dt class="w-36 text-sm text-gray-500 flex-shrink-0">Bahasa</dt>
                        <dd class="text-sm text-gray-900">{{ $buku->bahasa }}</dd>
                    </div>
                    <div class="flex items-start">
                        <dt class="w-36 text-sm text-gray-500 flex-shrink-0">Stok Tersedia</dt>
                        <dd>
                            @if ($buku->stok > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">{{ $buku->stok }} tersedia</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">Stok Habis</span>
                            @endif
                        </dd>
                    </div>
                </dl>

                <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-400">Terakhir diperbarui: {{ $buku->updated_at->format('d M Y, H:i') }}</p>
                </div>

                <div class="flex items-center gap-3 mt-6">
                    <a href="{{ route('admin.editBuku', $buku->id) }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg transition-colors">Edit Data</a>
                    <a href="{{ route('admin.viewBuku') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-lg transition-colors">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
