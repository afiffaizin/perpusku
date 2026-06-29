@extends('admin.layouts.admin')

@section('title', 'Detail Peminjaman')
@section('page-title', 'Detail Peminjaman')

@section('content')
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.viewPeminjam') }}" class="hover:text-gray-700 transition-colors">Kelola Peminjaman</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 font-medium">Detail Peminjaman</span>
    </nav>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        {{-- Student info --}}
        <div class="mb-6">
            <h3 class="text-base font-semibold text-gray-900 mb-4">Daftar Buku Dipinjam</h3>
            <div class="flex flex-col sm:flex-row gap-6">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-500">Nama:</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $peminjaman->mahasiswa->nama }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-500">NIM:</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $peminjaman->mahasiswa->nim }}</span>
                </div>
            </div>
        </div>

        {{-- Books table --}}
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Judul Buku</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">ISBN</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Jatuh Tempo</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($peminjaman->detailPeminjaman as $detail)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $detail->buku->judul }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $detail->buku->isbn }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $peminjaman->tanggal_jatuh_tempo->translatedFormat('d F Y') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600 text-center">{{ $detail->jumlah }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('admin.viewPeminjam') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-lg transition-colors">Kembali</a>
            @if ($peminjaman->status === 'dipinjam')
                <form action="{{ route('admin.kembalikanBuku', $peminjaman->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors"
                            onclick="return confirm('Konfirmasi pengembalian buku ini?')">
                        Kembalikan Buku
                    </button>
                </form>
            @else
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Sudah Dikembalikan</span>
            @endif
        </div>
    </div>
@endsection
