@extends('admin.layouts.admin')

@section('title', 'Tambah Peminjam')
@section('page-title', 'Tambah Peminjaman')

@section('content')
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.viewPeminjam') }}" class="hover:text-gray-700 transition-colors">Kelola Peminjaman</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 font-medium">Tambah Peminjam</span>
    </nav>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-base font-semibold text-gray-900 mb-6">Form Peminjaman Buku</h3>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-800 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.storePeminjam') }}" method="POST" class="space-y-6" x-data="peminjaman()">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Left: Mahasiswa + Duration --}}
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Mahasiswa <span class="text-red-500">*</span></label>
                        <select name="mahasiswa_id" required
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition">
                            <option value="">-- Pilih Mahasiswa --</option>
                            @foreach ($mahasiswas as $mhs)
                                <option value="{{ $mhs->id }}" {{ old('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>{{ $mhs->nama }}</option>
                            @endforeach
                        </select>
                        @error('mahasiswa_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Lama Peminjaman (Hari)</label>
                        <input type="number" name="lama_pinjam" min="1" value="{{ old('lama_pinjam', 7) }}" required
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition">
                    </div>
                </div>

                {{-- Right: Books --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul Buku <span class="text-red-500">*</span></label>
                    <select name="buku_ids[]" multiple required x-ref="bukuSelect" @change="updateSelectedBooks()"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition min-h-[120px]">
                        @foreach ($bukus as $buku)
                            <option value="{{ $buku->id }}"
                                    data-judul="{{ $buku->judul }}"
                                    data-penulis="{{ $buku->penulis->nama_penulis ?? '-' }}"
                                    data-isbn="{{ $buku->isbn }}"
                                    data-kategori="{{ $buku->kategori->nama_kategori ?? '-' }}"
                                    data-stok="{{ $buku->stok }}"
                                    data-sampul="{{ asset('storage/sampul/' . $buku->sampul) }}">
                                {{ $buku->judul }} (Stok: {{ $buku->stok }})
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-400">Tahan Ctrl/Cmd untuk memilih beberapa buku</p>
                    @error('buku_ids') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Selected books detail with jumlah input --}}
            <div x-show="selectedBooks.length > 0" x-transition class="mt-2">
                <h4 class="text-sm font-semibold text-gray-900 mb-3">Buku yang Dipilih</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    <template x-for="book in selectedBooks" :key="book.id">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <img :src="book.sampul" class="w-10 h-14 object-cover rounded border border-gray-200" :alt="book.judul">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate" x-text="book.judul"></p>
                                <p class="text-xs text-gray-500" x-text="book.penulis"></p>
                                <div class="flex items-center gap-2 mt-1.5">
                                    <label class="text-xs text-gray-500">Jml:</label>
                                    <input type="number" :name="'jumlah[' + book.id + ']'" min="1" :max="book.stok" value="1"
                                           class="w-16 px-2 py-1 bg-white border border-gray-200 rounded text-xs text-center focus:outline-none focus:ring-1 focus:ring-slate-800/20 focus:border-slate-800">
                                    <span class="text-xs text-gray-400">/ <span x-text="book.stok"></span></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg transition-colors">Simpan Peminjaman</button>
                <a href="{{ route('admin.viewPeminjam') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-lg transition-colors">Kembali</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
function peminjaman() {
    return {
        selectedBooks: [],
        updateSelectedBooks() {
            const select = this.$refs.bukuSelect;
            const selected = Array.from(select.selectedOptions);
            this.selectedBooks = selected.map(opt => ({
                id: opt.value,
                judul: opt.dataset.judul,
                penulis: opt.dataset.penulis,
                isbn: opt.dataset.isbn,
                kategori: opt.dataset.kategori,
                stok: parseInt(opt.dataset.stok),
                sampul: opt.dataset.sampul,
            }));
        }
    }
}
</script>
@endpush
