@extends('layouts.app')

@section('title', 'Peminjaman')

@section('breadcrumb')
    <span style="font-size:16px;font-weight:600;color:var(--clr-text);">Peminjaman</span>
@endsection

@section('content')
    <x-page-header title="Peminjaman Aktif" subtitle="Daftar peminjaman buku yang sedang berjalan">
        <x-slot:actions>
            <a href="{{ route('admin.tambahPeminjam') }}" class="btn-primary-custom">
                <i class="bi bi-plus-lg"></i> Peminjaman Baru
            </a>
        </x-slot:actions>
    </x-page-header>

    <x-data-table title="Daftar Peminjaman">
        <x-slot:filters>
            <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center gap-2 flex-wrap w-100">
                <div class="search-input-wrapper">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Cari nama mahasiswa...">
                </div>
                <button type="submit" class="btn-primary-custom btn-sm-custom">Cari</button>
                <a href="{{ url()->current() }}" class="btn-secondary-custom btn-sm-custom">Reset</a>
            </form>
        </x-slot:filters>

        <x-slot:thead>
            <tr>
                <th>#</th>
                <th>Mahasiswa</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Status</th>
                <th class="text-end">Aksi</th>
            </tr>
        </x-slot:thead>

        @forelse($peminjamans as $pinjam)
            @php
                $jatuhTempo = \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo);
                $selisih = now()->diffInDays($jatuhTempo, false);
            @endphp
            <tr>
                <td>{{ $peminjamans->firstItem() + $loop->index }}</td>
                <td style="font-weight:500;">{{ $pinjam->mahasiswa->nama }}</td>
                <td>
                    @if($pinjam->detailPeminjaman->count() > 0)
                        {{ $pinjam->detailPeminjaman->first()->buku->judul ?? '-' }}
                        @if($pinjam->detailPeminjaman->count() > 1)
                            <x-badge type="primary" :text="'+' . ($pinjam->detailPeminjaman->count() - 1) . ' lainnya'" />
                        @endif
                    @endif
                </td>
                <td>{{ $pinjam->tanggal_pinjam->format('d M Y') }}</td>
                <td>{{ $jatuhTempo->format('d M Y') }}</td>
                <td>
                    @if($selisih < 0)
                        <x-badge type="danger" :text="'Terlambat ' . abs(intval($selisih)) . ' hari'" />
                    @elseif($selisih <= 3)
                        <x-badge type="warning" text="Mendekati" />
                    @else
                        <x-badge type="info" text="Aktif" />
                    @endif
                </td>
                <td>
                    <div class="d-flex align-items-center justify-content-end gap-1">
                        <a href="{{ route('admin.detailPeminjam', $pinjam->id) }}" class="action-btn action-view" title="Detail"><i class="bi bi-eye"></i></a>
                        <button type="button" class="action-btn action-return" data-bs-toggle="modal" data-bs-target="#returnModal{{ $pinjam->id }}" title="Kembalikan"><i class="bi bi-check-lg"></i></button>
                    </div>

                    <x-modal :id="'returnModal' . $pinjam->id" title="Konfirmasi Pengembalian" size="sm">
                        <x-slot:body>
                            <p>Konfirmasi pengembalian buku oleh <strong>{{ $pinjam->mahasiswa->nama }}</strong>?</p>
                        </x-slot:body>
                        <x-slot:footer>
                            <button type="button" class="btn-secondary-custom btn-sm-custom" data-bs-dismiss="modal">Batal</button>
                            <form action="{{ route('admin.kembalikanBuku', $pinjam->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn-success-custom btn-sm-custom">Kembalikan</button>
                            </form>
                        </x-slot:footer>
                    </x-modal>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">
                    <x-empty-state icon="bi-arrow-left-right" title="Tidak ada peminjaman aktif" description="Buat peminjaman baru" action-label="Peminjaman Baru" :action-route="route('admin.tambahPeminjam')" />
                </td>
            </tr>
        @endforelse

        <x-slot:pagination>
            {{ $peminjamans->links() }}
        </x-slot:pagination>
    </x-data-table>
@endsection
