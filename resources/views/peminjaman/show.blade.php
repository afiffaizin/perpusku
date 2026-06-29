@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0" style="font-size:14px;">
            <li class="breadcrumb-item"><a href="{{ route('admin.viewPeminjam') }}" style="color:var(--clr-primary);">Peminjaman</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
@endsection

@section('content')
    <x-page-header title="Detail Peminjaman" />

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="content-card">
                <div class="card-header-custom">
                    <h3 class="card-title">Buku Dipinjam</h3>
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

                <div style="padding:16px 24px;border-top:1px solid var(--clr-border);" class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.viewPeminjam') }}" class="btn-secondary-custom">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    @if($peminjaman->status === 'dipinjam')
                        <form action="{{ route('admin.kembalikanBuku', $peminjaman->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn-success-custom" onclick="return confirm('Konfirmasi pengembalian buku?')">
                                <i class="bi bi-check-lg"></i> Kembalikan Buku
                            </button>
                        </form>
                    @else
                        <x-badge type="success" text="Sudah Dikembalikan" />
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <x-form-card title="Info Peminjaman">
                <dl style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div>
                        <dt style="font-size:12px;color:var(--clr-muted);margin-bottom:2px;">Nama</dt>
                        <dd style="font-weight:600;font-size:14px;">{{ $peminjaman->mahasiswa->nama }}</dd>
                    </div>
                    <div>
                        <dt style="font-size:12px;color:var(--clr-muted);margin-bottom:2px;">NIM</dt>
                        <dd class="font-mono" style="font-size:14px;">{{ $peminjaman->mahasiswa->nim }}</dd>
                    </div>
                    <div>
                        <dt style="font-size:12px;color:var(--clr-muted);margin-bottom:2px;">Tgl Pinjam</dt>
                        <dd style="font-size:14px;">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt style="font-size:12px;color:var(--clr-muted);margin-bottom:2px;">Jatuh Tempo</dt>
                        <dd style="font-size:14px;">{{ $peminjaman->tanggal_jatuh_tempo->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt style="font-size:12px;color:var(--clr-muted);margin-bottom:2px;">Petugas</dt>
                        <dd style="font-size:14px;">{{ $peminjaman->petugas->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt style="font-size:12px;color:var(--clr-muted);margin-bottom:2px;">Status</dt>
                        <dd>
                            @if($peminjaman->status === 'dipinjam')
                                <x-badge type="warning" text="Dipinjam" />
                            @else
                                <x-badge type="success" text="Dikembalikan" />
                            @endif
                        </dd>
                    </div>
                </dl>
            </x-form-card>
        </div>
    </div>
@endsection
