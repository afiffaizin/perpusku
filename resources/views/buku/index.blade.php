@extends('layouts.app')

@section('title', 'Manajemen Buku')

@section('breadcrumb')
    <span style="font-size:16px;font-weight:600;color:var(--clr-text);">Manajemen Buku</span>
@endsection

@section('content')
    <x-page-header title="Manajemen Buku" :subtitle="$totalKategori . ' kategori · ' . $totalBuku . ' judul tersedia'">
        <x-slot:actions>
            <a href="{{ route('admin.tambahBuku') }}" class="btn-primary-custom">
                <i class="bi bi-plus-lg"></i> Tambah Buku
            </a>
        </x-slot:actions>
    </x-page-header>

    <x-data-table title="Daftar Buku">
        <x-slot:filters>
            <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center gap-2 flex-wrap w-100">
                <div class="search-input-wrapper">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Cari judul, ISBN, atau penulis...">
                </div>
                <select name="kategori" class="filter-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
                <select name="stok" class="filter-select">
                    <option value="">Semua Stok</option>
                    <option value="tersedia" {{ request('stok') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="habis" {{ request('stok') == 'habis' ? 'selected' : '' }}>Habis</option>
                </select>
                <button type="submit" class="btn-primary-custom btn-sm-custom">Cari</button>
                <a href="{{ url()->current() }}" class="btn-secondary-custom btn-sm-custom">Reset</a>
            </form>
        </x-slot:filters>

        <x-slot:thead>
            <tr>
                <th>#</th>
                <th>Sampul</th>
                <th>Judul & ISBN</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Stok</th>
                <th class="text-end">Aksi</th>
            </tr>
        </x-slot:thead>

        @forelse($bukus as $buku)
            <tr>
                <td>{{ $bukus->firstItem() + $loop->index }}</td>
                <td>
                    @if($buku->sampul)
                        <img src="{{ asset('storage/sampul/' . $buku->sampul) }}" alt="{{ $buku->judul }}" class="table-thumbnail">
                    @else
                        <div class="table-thumbnail-placeholder"><i class="bi bi-book"></i></div>
                    @endif
                </td>
                <td>
                    <div style="font-weight:500;">{{ $buku->judul }}</div>
                    <div style="font-size:12px;color:var(--clr-muted);">{{ $buku->isbn }}</div>
                </td>
                <td><x-badge type="info" :text="$buku->kategori->nama_kategori ?? '-'" /></td>
                <td>{{ $buku->penulis->nama_penulis ?? '-' }}</td>
                <td>
                    @if($buku->stok > 3)
                        <x-badge type="success" :text="(string)$buku->stok" />
                    @elseif($buku->stok > 0)
                        <x-badge type="warning" :text="(string)$buku->stok" />
                    @else
                        <x-badge type="danger" text="Habis" />
                    @endif
                </td>
                <td>
                    <div class="d-flex align-items-center justify-content-end gap-1">
                        <a href="{{ route('admin.detailBuku', $buku->id) }}" class="action-btn action-view" title="Detail"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('admin.editBuku', $buku->id) }}" class="action-btn action-edit" title="Edit"><i class="bi bi-pencil"></i></a>
                        <button type="button" class="action-btn action-delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $buku->id }}" title="Hapus"><i class="bi bi-trash"></i></button>
                    </div>

                    {{-- Delete modal --}}
                    <x-modal :id="'deleteModal' . $buku->id" title="Konfirmasi Hapus" size="sm">
                        <x-slot:body>
                            <p>Yakin ingin menghapus buku <strong>{{ $buku->judul }}</strong>?</p>
                        </x-slot:body>
                        <x-slot:footer>
                            <button type="button" class="btn-secondary-custom btn-sm-custom" data-bs-dismiss="modal">Batal</button>
                            <form action="{{ route('admin.deleteBuku', $buku->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger-custom btn-sm-custom">Hapus</button>
                            </form>
                        </x-slot:footer>
                    </x-modal>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">
                    <x-empty-state icon="bi-book" title="Belum ada data buku" description="Tambahkan buku pertama ke perpustakaan" action-label="Tambah Buku" :action-route="route('admin.tambahBuku')" />
                </td>
            </tr>
        @endforelse

        <x-slot:pagination>
            {{ $bukus->links() }}
        </x-slot:pagination>
    </x-data-table>
@endsection
