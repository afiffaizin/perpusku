@extends('layouts.app')

@section('title', 'Detail Riwayat')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0" style="font-size:14px;">
            <li class="breadcrumb-item"><a href="{{ route('admin.historyPeminjam') }}" style="color:var(--clr-primary);">Riwayat</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
@endsection

@section('content')
    <x-page-header title="Detail Riwayat Peminjaman" />

    @php
        $tglPinjam = \Carbon\Carbon::parse($peminjaman->tanggal_pinjam);
        $tglJatuhTempo = \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo);
        $tglKembali = $peminjaman->pengembalian ? \Carbon\Carbon::parse($peminjaman->pengembalian->tanggal_kembali) : $peminjaman->updated_at;
        $durasi = $tglPinjam->diffInDays($tglKembali);
        $terlambat = $tglKembali->gt($tglJatuhTempo);
        $hariTerlambat = $terlambat ? $tglJatuhTempo->diffInDays($tglKembali) : 0;
    @endphp

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="content-card">
                <div class="card-header-custom">
                    <h3 class="card-title">Buku yang Dikembalikan</h3>
                </div>
                <div class="data-table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>ISBN</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjaman->detailPeminjaman as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="font-weight:500;">{{ $detail->buku->judul }}</td>
                                    <td class="font-mono">{{ $detail->buku->isbn }}</td>
                                    <td>{{ $detail->jumlah }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="padding:16px 24px;border-top:1px solid var(--clr-border);">
                    <a href="{{ route('admin.historyPeminjam') }}" class="btn-secondary-custom">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <x-form-card title="Info Peminjaman">
                <dl style="display:grid;gap:16px;">
                    <div>
                        <dt style="font-size:12px;color:var(--clr-muted);margin-bottom:2px;">Nama</dt>
                        <dd style="font-weight:600;">{{ $peminjaman->mahasiswa->nama }}</dd>
                    </div>
                    <div>
                        <dt style="font-size:12px;color:var(--clr-muted);margin-bottom:2px;">NIM</dt>
                        <dd class="font-mono">{{ $peminjaman->mahasiswa->nim }}</dd>
                    </div>
                    <div>
                        <dt style="font-size:12px;color:var(--clr-muted);margin-bottom:2px;">Tgl Pinjam</dt>
                        <dd>{{ $tglPinjam->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt style="font-size:12px;color:var(--clr-muted);margin-bottom:2px;">Jatuh Tempo</dt>
                        <dd>{{ $tglJatuhTempo->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt style="font-size:12px;color:var(--clr-muted);margin-bottom:2px;">Tgl Kembali</dt>
                        <dd>{{ $tglKembali->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt style="font-size:12px;color:var(--clr-muted);margin-bottom:2px;">Durasi</dt>
                        <dd>{{ $durasi }} hari</dd>
                    </div>
                    <div>
                        <dt style="font-size:12px;color:var(--clr-muted);margin-bottom:2px;">Status</dt>
                        <dd>
                            @if($terlambat)
                                <x-badge type="danger" :text="'Terlambat +' . $hariTerlambat . ' hari'" />
                            @else
                                <x-badge type="success" text="Tepat waktu" />
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt style="font-size:12px;color:var(--clr-muted);margin-bottom:2px;">Petugas</dt>
                        <dd>{{ $peminjaman->petugas->name ?? '-' }}</dd>
                    </div>
                </dl>
            </x-form-card>
        </div>
    </div>
@endsection
