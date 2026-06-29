@extends('layouts.app')

@section('title', 'Mahasiswa')

@section('breadcrumb')
    <span style="font-size:16px;font-weight:600;color:var(--clr-text);">Mahasiswa</span>
@endsection

@section('content')
    <x-page-header title="Manajemen Mahasiswa" subtitle="Kelola data mahasiswa program studi TRPL">
        <x-slot:actions>
            <a href="{{ route('admin.addMahasiswa') }}" class="btn-primary-custom">
                <i class="bi bi-plus-lg"></i> Tambah Mahasiswa
            </a>
        </x-slot:actions>
    </x-page-header>

    <x-data-table title="Daftar Mahasiswa">
        <x-slot:filters>
            <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center gap-2 flex-wrap w-100">
                <div class="search-input-wrapper">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Cari nama atau NIM...">
                </div>
                <button type="submit" class="btn-primary-custom btn-sm-custom">Cari</button>
                <a href="{{ url()->current() }}" class="btn-secondary-custom btn-sm-custom">Reset</a>
            </form>
        </x-slot:filters>

        <x-slot:thead>
            <tr>
                <th>#</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Angkatan</th>
                <th>Peminjaman Aktif</th>
                <th class="text-end">Aksi</th>
            </tr>
        </x-slot:thead>

        @forelse($mahasiswas as $index => $mhs)
            <tr>
                <td>{{ $mahasiswas->firstItem() + $index }}</td>
                <td class="font-mono">{{ $mhs->nim }}</td>
                <td style="font-weight:500;">{{ $mhs->nama }}</td>
                <td>{{ $mhs->kelas }}</td>
                <td>{{ $mhs->angkatan }}</td>
                <td>
                    @if(($mhs->peminjaman_count ?? 0) > 0)
                        <x-badge type="primary" :text="$mhs->peminjaman_count . ' aktif'" />
                    @else
                        <span style="color:var(--clr-muted);">—</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex align-items-center justify-content-end gap-1">
                        <a href="{{ route('admin.mahasiswa.edit', $mhs->id) }}" class="action-btn action-edit" title="Edit"><i class="bi bi-pencil"></i></a>
                        <button type="button" class="action-btn action-delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $mhs->id }}" title="Hapus"><i class="bi bi-trash"></i></button>
                    </div>

                    <x-modal :id="'deleteModal' . $mhs->id" title="Konfirmasi Hapus" size="sm">
                        <x-slot:body>
                            <p>Yakin ingin menghapus mahasiswa <strong>{{ $mhs->nama }}</strong>?</p>
                        </x-slot:body>
                        <x-slot:footer>
                            <button type="button" class="btn-secondary-custom btn-sm-custom" data-bs-dismiss="modal">Batal</button>
                            <form action="{{ route('admin.mahasiswa.delete', $mhs->id) }}" method="POST" class="d-inline">
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
                    <x-empty-state icon="bi-people" title="Belum ada data mahasiswa" description="Tambahkan mahasiswa baru" action-label="Tambah Mahasiswa" :action-route="route('admin.addMahasiswa')" />
                </td>
            </tr>
        @endforelse

        <x-slot:pagination>
            {{ $mahasiswas->links() }}
        </x-slot:pagination>
    </x-data-table>
@endsection
