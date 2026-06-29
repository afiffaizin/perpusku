@extends('layouts.app')

@section('title', 'Pengembalian Buku')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0" style="font-size:14px;">
            <li class="breadcrumb-item"><a href="{{ route('admin.viewPeminjam') }}" style="color:var(--clr-primary);">Peminjaman</a></li>
            <li class="breadcrumb-item active">Pengembalian</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <x-form-card title="Proses Pengembalian Buku" subtitle="Konfirmasi pengembalian buku mahasiswa">

                {{-- Info mahasiswa --}}
                <div class="info-box mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:44px;height:44px;border-radius:50%;background:var(--clr-primary);color:white;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:16px;">
                            {{ strtoupper(substr($peminjaman->mahasiswa->nama, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight:600;font-size:15px;">{{ $peminjaman->mahasiswa->nama }}</div>
                            <div style="font-size:13px;color:var(--clr-text-sub);">NIM: {{ $peminjaman->mahasiswa->nim }}</div>
                        </div>
                    </div>
                </div>

                {{-- Buku table --}}
                <div class="data-table-wrapper" style="border:1px solid var(--clr-border);border-radius:var(--radius-md);margin-bottom:20px;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjaman->detailPeminjaman as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="font-weight:500;">{{ $detail->buku->judul }}</td>
                                    <td>{{ $detail->jumlah }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Date info --}}
                @php
                    $jatuhTempo = \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo);
                    $terlambat = now()->gt($jatuhTempo);
                    $selisihHari = $terlambat ? now()->diffInDays($jatuhTempo) : 0;
                @endphp

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div style="padding:12px 16px;background:var(--clr-bg);border-radius:var(--radius-md);">
                            <div style="font-size:12px;color:var(--clr-muted);">Tgl Pinjam</div>
                            <div style="font-weight:600;">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="padding:12px 16px;background:var(--clr-bg);border-radius:var(--radius-md);">
                            <div style="font-size:12px;color:var(--clr-muted);">Jatuh Tempo</div>
                            <div style="font-weight:600;">{{ $jatuhTempo->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="padding:12px 16px;background:var(--clr-bg);border-radius:var(--radius-md);">
                            <div style="font-size:12px;color:var(--clr-muted);">Tgl Kembali</div>
                            <div style="font-weight:600;">{{ now()->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>

                {{-- Status alert --}}
                @if($terlambat)
                    <div class="flash-alert flash-error" style="margin-bottom:20px;">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span>Terlambat {{ $selisihHari }} hari</span>
                    </div>
                @else
                    <div class="flash-alert flash-success" style="margin-bottom:20px;">
                        <i class="bi bi-check-circle"></i>
                        <span>Dikembalikan tepat waktu</span>
                    </div>
                @endif

                {{-- Action --}}
                <form action="{{ route('admin.kembalikanBuku', $peminjaman->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn-success-custom w-100 justify-content-center" style="height:46px;" x-data="{ loading: false }" x-bind:disabled="loading" @click="loading = true">
                        <span x-show="loading" class="spinner-border spinner-border-sm"></span>
                        <span x-text="loading ? 'Memproses...' : 'Konfirmasi Pengembalian'"></span>
                    </button>
                </form>
            </x-form-card>
        </div>
    </div>
@endsection
