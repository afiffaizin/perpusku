@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <span style="font-size:16px;font-weight:600;color:var(--clr-text);">Dashboard</span>
@endsection

@section('content')
    {{-- Row 1: Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <x-stat-card title="Total Mahasiswa" :value="$totalMahasiswa" icon="bi-people-fill" color="primary" />
        </div>
        <div class="col-sm-6 col-lg-3">
            <x-stat-card title="Total Buku (Stok)" :value="$stokAwal" icon="bi-book-fill" color="info" />
        </div>
        <div class="col-sm-6 col-lg-3">
            <x-stat-card title="Sedang Dipinjam" :value="$totalDipinjam" icon="bi-arrow-left-right" color="warning" />
        </div>
        <div class="col-sm-6 col-lg-3">
            <x-stat-card title="Dikembalikan Bulan Ini" :value="$dikembalikanBulanIni" icon="bi-check-circle-fill" color="success" />
        </div>
    </div>

    {{-- Row 2: Charts --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-7">
            <div class="content-card">
                <div class="card-header-custom">
                    <div>
                        <h3 class="card-title">Aktivitas Peminjaman</h3>
                        <p class="card-subtitle">Data peminjaman & pengembalian per bulan</p>
                    </div>
                </div>
                <div class="card-body-custom">
                    <div class="chart-wrapper">
                        <canvas id="chartPeminjaman"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="content-card">
                <div class="card-header-custom">
                    <div>
                        <h3 class="card-title">Distribusi Buku</h3>
                        <p class="card-subtitle">Jumlah buku per kategori</p>
                    </div>
                </div>
                <div class="card-body-custom">
                    <div class="chart-wrapper" style="position:relative;">
                        <div class="doughnut-center">
                            <div class="center-value">{{ $stokAwal }}</div>
                            <div class="center-label">Total</div>
                        </div>
                        <canvas id="chartKategori"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Row 3: Active loans + Recent books --}}
    <div class="row g-3">
        <div class="col-lg-7">
            <div class="content-card">
                <div class="card-header-custom">
                    <div class="d-flex align-items-center gap-2">
                        <h3 class="card-title mb-0">Peminjaman Aktif</h3>
                        @if($peminjamanAktif->count() > 0)
                            <span class="badge-custom badge-danger">{{ $peminjamanAktif->count() }}</span>
                        @endif
                    </div>
                    <a href="{{ route('admin.viewPeminjam') }}" style="font-size:13px;color:var(--clr-primary);font-weight:500;">
                        Lihat semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="data-table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama Mahasiswa</th>
                                <th>Judul Buku</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjamanAktif as $pinjam)
                                @php
                                    $jatuhTempo = \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo);
                                    $selisih = now()->diffInDays($jatuhTempo, false);
                                @endphp
                                <tr>
                                    <td style="font-weight:500;">{{ $pinjam->mahasiswa->nama }}</td>
                                    <td>
                                        @if($pinjam->detailPeminjaman->count() > 0)
                                            {{ $pinjam->detailPeminjaman->first()->buku->judul ?? '-' }}
                                            @if($pinjam->detailPeminjaman->count() > 1)
                                                <span class="badge-custom badge-primary" style="font-size:11px;">+{{ $pinjam->detailPeminjaman->count() - 1 }} lainnya</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $jatuhTempo->format('d M Y') }}</td>
                                    <td>
                                        @if($selisih < 0)
                                            <x-badge type="danger" :text="'Terlambat ' . abs($selisih) . ' hari'" />
                                        @elseif($selisih <= 3)
                                            <x-badge type="warning" text="Mendekati" />
                                        @else
                                            <x-badge type="success" text="Tepat Waktu" />
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <x-empty-state icon="bi-inbox" title="Tidak ada peminjaman aktif" />
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="content-card">
                <div class="card-header-custom">
                    <h3 class="card-title">Buku Terbaru Ditambahkan</h3>
                </div>
                <div class="card-body-custom" style="padding-top:8px;padding-bottom:8px;">
                    @forelse($bukuTerbaru as $buku)
                        <div class="book-list-item">
                            @if($buku->sampul)
                                <img src="{{ asset('storage/sampul/' . $buku->sampul) }}" alt="{{ $buku->judul }}" class="book-cover">
                            @else
                                <div class="book-cover-placeholder">
                                    <i class="bi bi-book"></i>
                                </div>
                            @endif
                            <div class="book-info">
                                <p class="book-title">{{ $buku->judul }}</p>
                                <p class="book-author">{{ $buku->penulis->nama_penulis ?? '-' }}</p>
                            </div>
                            @if($buku->stok > 3)
                                <x-badge type="success" :text="$buku->stok . ' stok'" />
                            @elseif($buku->stok > 0)
                                <x-badge type="warning" :text="$buku->stok . ' stok'" />
                            @else
                                <x-badge type="danger" text="Habis" />
                            @endif
                        </div>
                    @empty
                        <x-empty-state icon="bi-book" title="Belum ada buku" />
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const dataPeminjaman = @json($chartPeminjaman);
    const dataPengembalian = @json($chartPengembalian);
    const dataKategoriLabels = @json($chartKategori->pluck('nama_kategori'));
    const dataKategoriValues = @json($chartKategori->pluck('buku_count'));
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bar chart — Peminjaman per bulan
    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    const peminjamanData = months.map((_, i) => dataPeminjaman[i + 1] || 0);
    const pengembalianData = months.map((_, i) => dataPengembalian[i + 1] || 0);

    new Chart(document.getElementById('chartPeminjaman'), {
        type: 'bar',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Dipinjam',
                    backgroundColor: '#6366F1',
                    borderRadius: 6,
                    data: peminjamanData
                },
                {
                    label: 'Dikembalikan',
                    backgroundColor: '#10B981',
                    borderRadius: 6,
                    data: pengembalianData
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { usePointStyle: true, font: { family: 'Inter', size: 12 } } },
                tooltip: { backgroundColor: '#1E1B4B', padding: 10, cornerRadius: 8 }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { family: 'Inter', size: 12 } } },
                y: { grid: { color: '#F1F5F9' }, ticks: { font: { family: 'Inter', size: 12 } } }
            }
        }
    });

    // Doughnut chart — Buku per kategori
    new Chart(document.getElementById('chartKategori'), {
        type: 'doughnut',
        data: {
            labels: dataKategoriLabels,
            datasets: [{
                data: dataKategoriValues,
                backgroundColor: ['#4F46E5','#10B981','#F59E0B','#EF4444','#3B82F6','#8B5CF6','#EC4899','#14B8A6'],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            cutout: '70%',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right', labels: { font: { family: 'Inter', size: 12 }, padding: 16, usePointStyle: true } }
            }
        }
    });
});
</script>
@endpush
