@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0" style="font-size:14px;">
            <li class="breadcrumb-item"><a href="{{ route('admin.viewBuku') }}" style="color:var(--clr-primary);">Buku</a></li>
            <li class="breadcrumb-item active">Tambah Buku</li>
        </ol>
    </nav>
@endsection

@section('content')
    <x-page-header title="Tambah Buku" subtitle="Isi formulir untuk menambahkan buku baru" />

    <form action="{{ route('admin.storeBuku') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            {{-- Left: Info buku --}}
            <div class="col-lg-8">
                <x-form-card title="Informasi Buku" subtitle="Data lengkap buku yang akan ditambahkan">
                    <div class="mb-3">
                        <label class="form-label-custom">Judul Buku <span style="color:var(--clr-danger);">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul') }}" class="form-input @error('judul') is-invalid @enderror" placeholder="Masukkan judul buku">
                        @error('judul') <div class="invalid-feedback-custom">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">ISBN <span style="color:var(--clr-danger);">*</span></label>
                        <input type="text" name="isbn" value="{{ old('isbn') }}" class="form-input @error('isbn') is-invalid @enderror" placeholder="Masukkan ISBN buku">
                        @error('isbn') <div class="invalid-feedback-custom">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label-custom">Kategori <span style="color:var(--clr-danger);">*</span></label>
                            <input type="text" name="kategori" value="{{ old('kategori') }}" class="form-input @error('kategori') is-invalid @enderror" placeholder="Nama kategori" list="kategoriList">
                            <datalist id="kategoriList">
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat->nama_kategori }}">
                                @endforeach
                            </datalist>
                            @error('kategori') <div class="invalid-feedback-custom">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Penulis <span style="color:var(--clr-danger);">*</span></label>
                            <input type="text" name="penulis" value="{{ old('penulis') }}" class="form-input @error('penulis') is-invalid @enderror" placeholder="Nama penulis" list="penulisList">
                            <datalist id="penulisList">
                                @foreach($penulisList as $pen)
                                    <option value="{{ $pen->nama_penulis }}">
                                @endforeach
                            </datalist>
                            @error('penulis') <div class="invalid-feedback-custom">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Bahasa <span style="color:var(--clr-danger);">*</span></label>
                        <input type="text" name="bahasa" value="{{ old('bahasa') }}" class="form-input @error('bahasa') is-invalid @enderror" placeholder="Contoh: Indonesia">
                        @error('bahasa') <div class="invalid-feedback-custom">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex gap-2 pt-3">
                        <a href="{{ route('admin.viewBuku') }}" class="btn-secondary-custom">Batal</a>
                        <button type="submit" class="btn-primary-custom" x-data="{ loading: false }" x-bind:disabled="loading" @click="loading = true">
                            <span x-show="loading" class="spinner-border spinner-border-sm"></span>
                            <span x-text="loading ? 'Memproses...' : 'Simpan'">Simpan</span>
                            <i class="bi bi-arrow-right" x-show="!loading"></i>
                        </button>
                    </div>
                </x-form-card>
            </div>

            {{-- Right: Sampul + detail --}}
            <div class="col-lg-4">
                <x-form-card title="Sampul Buku" subtitle="Upload cover buku">
                    <div x-data="fileUpload()" class="mb-3">
                        <div class="upload-area" @click="$refs.fileInput.click()" @dragover.prevent="dragOver = true" @dragleave="dragOver = false" @drop.prevent="handleDrop($event)" :class="dragOver ? 'drag-over' : ''">
                            <template x-if="!preview">
                                <div>
                                    <i class="bi bi-cloud-upload upload-icon"></i>
                                    <p class="upload-text">Klik atau drag & drop</p>
                                    <p class="upload-hint">PNG, JPG maks 2MB</p>
                                </div>
                            </template>
                            <template x-if="preview">
                                <img :src="preview" class="upload-preview">
                            </template>
                        </div>
                        <input type="file" name="sampul" x-ref="fileInput" @change="handleFile($event)" style="display:none" accept="image/*">
                        @error('sampul') <div class="invalid-feedback-custom">{{ $message }}</div> @enderror
                    </div>
                </x-form-card>

                <div class="mt-3">
                    <x-form-card title="Stok & Info">
                        <div class="mb-3">
                            <label class="form-label-custom">Stok <span style="color:var(--clr-danger);">*</span></label>
                            <input type="number" name="stok" value="{{ old('stok', 0) }}" min="0" class="form-input @error('stok') is-invalid @enderror">
                            @error('stok') <div class="invalid-feedback-custom">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label-custom">Jumlah Halaman <span style="color:var(--clr-danger);">*</span></label>
                            <input type="number" name="jumlah_halaman" value="{{ old('jumlah_halaman') }}" min="1" class="form-input @error('jumlah_halaman') is-invalid @enderror">
                            @error('jumlah_halaman') <div class="invalid-feedback-custom">{{ $message }}</div> @enderror
                        </div>
                    </x-form-card>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
function fileUpload() {
    return {
        preview: null,
        dragOver: false,
        handleFile(event) {
            const file = event.target.files[0];
            if (file) this.preview = URL.createObjectURL(file);
        },
        handleDrop(event) {
            this.dragOver = false;
            const file = event.dataTransfer.files[0];
            if (file) {
                this.$refs.fileInput.files = event.dataTransfer.files;
                this.preview = URL.createObjectURL(file);
            }
        }
    }
}
</script>
@endpush
