@extends('layouts.app')

@section('title', 'Detail Buku')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0" style="font-size:14px;">
            <li class="breadcrumb-item"><a href="{{ route('admin.viewBuku') }}" style="color:var(--clr-primary);">Buku</a></li>
            <li class="breadcrumb-item active">{{ $buku->judul }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="content-card">
        <div class="card-body-custom">
            <div class="row g-4">
                {{-- Cover --}}
                <div class="col-md-4">
                    <div style="background:var(--clr-bg);border-radius:var(--radius-lg);border:1px solid var(--clr-border);padding:24px;text-align:center;">
                        @if($buku->sampul)
                            <img src="{{ asset('storage/sampul/' . $buku->sampul) }}" alt="{{ $buku->judul }}" style="max-height:320px;border-radius:var(--radius-md);box-shadow:var(--shadow-md);">
                        @else
                            <div style="height:256px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-book" style="font-size:64px;color:var(--clr-border);"></i>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Info --}}
                <div class="col-md-8">
                    <h2 style="font-size:22px;font-weight:700;color:var(--clr-text);margin-bottom:24px;letter-spacing:-0.01em;">{{ $buku->judul }}</h2>

                    <dl style="display:grid;grid-template-columns:140px 1fr;gap:16px 12px;">
                        <dt style="font-size:14px;color:var(--clr-muted);">ISBN</dt>
                        <dd><x-badge type="info" :text="$buku->isbn ?? '-'" /></dd>

                        <dt style="font-size:14px;color:var(--clr-muted);">Kategori</dt>
                        <dd style="font-size:14px;">{{ $buku->kategori->nama_kategori ?? '-' }}</dd>

                        <dt style="font-size:14px;color:var(--clr-muted);">Penulis</dt>
                        <dd style="font-size:14px;">{{ $buku->penulis->nama_penulis ?? '-' }}</dd>

                        <dt style="font-size:14px;color:var(--clr-muted);">Jumlah Halaman</dt>
                        <dd style="font-size:14px;">{{ $buku->jumlah_halaman }} Halaman</dd>

                        <dt style="font-size:14px;color:var(--clr-muted);">Bahasa</dt>
                        <dd style="font-size:14px;">{{ $buku->bahasa }}</dd>

                        <dt style="font-size:14px;color:var(--clr-muted);">Stok Tersedia</dt>
                        <dd>
                            @if($buku->stok > 3)
                                <x-badge type="success" :text="$buku->stok . ' tersedia'" />
                            @elseif($buku->stok > 0)
                                <x-badge type="warning" :text="$buku->stok . ' tersedia'" />
                            @else
                                <x-badge type="danger" text="Stok Habis" />
                            @endif
                        </dd>
                    </dl>

                    <div style="margin-top:32px;padding:16px;background:var(--clr-bg);border-radius:var(--radius-md);">
                        <p style="font-size:12px;color:var(--clr-muted);margin:0;">Terakhir diperbarui: {{ $buku->updated_at->format('d M Y, H:i') }}</p>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('admin.editBuku', $buku->id) }}" class="btn-primary-custom">
                            <i class="bi bi-pencil"></i> Edit Data
                        </a>
                        <a href="{{ route('admin.viewBuku') }}" class="btn-secondary-custom">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
