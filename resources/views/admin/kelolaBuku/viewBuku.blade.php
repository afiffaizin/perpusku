{{-- resources/views/test-adminlte.blade.php --}}
@extends('adminlte::page')

@section('title', 'Kelola Buku')
{{--  linkcss --}}



@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mt-4 mb-1">Daftar Buku</h4>
            <p class="text-muted small mb-0">Kelola Data Buku Perpustakaan Anda di sini.</p>
        </div>
        <a href="{{ route('admin.tambahBuku') }}" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow-sm"> <i
                class="bi bi-plus-lg"></i> Tambah Buku </a>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Table Buku --}}
    <div class="table-header-area">
        <form method="GET" action="{{ url()->current() }}">
            <div class="row g-3 align-items-center justify-content-between">
                <div class="col-12 col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 ps-3"><i
                                class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control border-start-0 ps-2" placeholder="Cari buku disini" />
                    </div>
                </div>

                <div class="col-12 col-md-8 text-md-end d-flex gap-2 justify-content-md-end flex-wrap">
                    <div class="d-flex gap-2 ">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 mt-3">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" width="60">No</th>
                    <th>Judul Buku</th>
                    <th class ="text-center">ISBN</th>
                    <th class ="text-center">Kategori</th>
                    <th class ="text-center">Penulis</th>
                    <th class ="text-center">Stok</th>
                    <th class="text-center" width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bukus as $buku)
                    <tr>
                        <td class="ps-4">
                            {{ $bukus->firstItem() + $loop->index }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('storage/sampul/' . $buku->sampul) }}" alt="Buku {{ $buku->judul }}"
                                    class="product-avatar me-3"
                                    style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px;" />
                                <div>
                                    <h6 class="mb-0 fw-semibold text-dark">{{ $buku->judul }}</h6>
                                </div>
                            </div>
                        </td>
                        <td class="text-center"> {{ $buku->isbn }} </td>
                        <td class="text-center"> {{ $buku->kategori->nama_kategori }} </td>
                        <td class="text-center">
                            {{ $buku->penulis->nama_penulis }}
                            </span>
                        </td>
                        <td class="text-center"> {{ $buku->stok }} </td>
                        <td class="text-end pe-4">
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('admin.editBuku', $buku->id) }}" class="btn btn-sm btn-outline-primary"
                                    title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="{{ route('admin.detailBuku', $buku->id) }}" class="btn btn-sm btn-outline-info"
                                    title="Detail">
                                    <i class="bi bi-info-circle"></i>
                                </a>
                                <form action="{{ route('admin.deleteBuku', $buku->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"
                                        onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-person-x fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-0">Belum ada data Buku</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-end px-4 py-3">
            {{ $bukus->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection
