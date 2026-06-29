@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('breadcrumb')
    <span style="font-size:16px;font-weight:600;color:var(--clr-text);">Riwayat</span>
@endsection

@section('content')
    <x-page-header title="Riwayat Peminjaman" subtitle="Daftar buku yang telah dikembalikan" />

    <x-data-table title="Riwayat">
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
                <th>Tgl Kembali</th>
                <th>Durasi</th>
                <th>Keterlambatan</th>
                <th class="text-end">Aksi</th>
            </tr>
        </x-slot:thead>

        @forelse($peminjamans as $pinjam)
            @php
                $tglPinjam = \Carbon\Carbon::parse($pinjam->tanggal_pinjam);
                $tglJatuhTempo = \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo);
                $tglKembali = $pinjam->pengembalian ? \Carbon\Carbon::parse($pinjam->pengembalian->tanggal_kembali) : $pinjam->updated_at;
                $durasi = $tglPinjam->diffInDays($tglKembali);
                $terlambat = $tglKembali->gt($tglJatuhTempo);
                $hariTerlambat = $terlambat ? $tglJatuhTempo->diffInDays($tglKembali) : 0;
            @endphp
            <tr>
                <td>{{ $peminjamans->firstItem() + $loop->index }}</td>
                <td>
                    <div style="font-weight:500;">{{ $pinjam->mahasiswa->nama }}</div>
                    <div style="font-size:12px;color:var(--clr-muted);">{{ $pinjam->mahasiswa->nim }}</div>
                </td>
                <td>
                    @if($pinjam->detailPeminjaman->count() > 0)
                        {{ $pinjam->detailPeminjaman->first()->buku->judul ?? '-' }}
                        @if($pinjam->detailPeminjaman->count() > 1)
                            <x-badge type="primary" :text="'+' . ($pinjam->detailPeminjaman->count() - 1) . ' lainnya'" />
                        @endif
                    @endif
                </td>
                <td>{{ $tglPinjam->format('d M Y') }}</td>
                <td>{{ $tglKembali->format('d M Y') }}</td>
                <td>{{ $durasi }} hari</td>
                <td>
                    @if($terlambat)
                        <x-badge type="danger" :text="'+' . $hariTerlambat . ' hari'" />
                    @else
                        <x-badge type="success" text="Tepat waktu" />
                    @endif
                </td>
                <td>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.detailPeminjamHistory', $pinjam->id) }}" class="action-btn action-view" title="Detail"><i class="bi bi-eye"></i></a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">
                    <x-empty-state icon="bi-clock-history" title="Belum ada riwayat peminjaman" />
                </td>
            </tr>
        @endforelse

        <x-slot:pagination>
            {{ $peminjamans->links() }}
        </x-slot:pagination>
    </x-data-table>
@endsection
