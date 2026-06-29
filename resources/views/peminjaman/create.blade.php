@extends('layouts.app')

@section('title', 'Peminjaman Baru')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0" style="font-size:14px;">
            <li class="breadcrumb-item"><a href="{{ route('admin.viewPeminjam') }}" style="color:var(--clr-primary);">Peminjaman</a></li>
            <li class="breadcrumb-item active">Buat Peminjaman</li>
        </ol>
    </nav>
@endsection

@section('content')
    <x-page-header title="Peminjaman Baru" subtitle="Buat peminjaman buku untuk mahasiswa" />

    @if ($errors->any())
        <div class="flash-alert flash-error" style="margin-bottom:20px;">
            <i class="bi bi-x-circle"></i>
            <div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.storePeminjam') }}" method="POST" x-data="peminjaman()">
        @csrf

        {{-- Wizard progress --}}
        <div class="wizard-progress">
            <div class="wizard-step" :class="step >= 1 ? (step > 1 ? 'completed' : 'active') : ''">
                <div class="step-circle">
                    <template x-if="step > 1"><i class="bi bi-check-lg"></i></template>
                    <template x-if="step <= 1">1</template>
                </div>
                <span class="step-label d-none d-md-inline">Pilih Mahasiswa</span>
            </div>
            <div class="step-connector" :class="step > 1 ? 'completed' : ''"></div>
            <div class="wizard-step" :class="step >= 2 ? (step > 2 ? 'completed' : 'active') : ''">
                <div class="step-circle">
                    <template x-if="step > 2"><i class="bi bi-check-lg"></i></template>
                    <template x-if="step <= 2">2</template>
                </div>
                <span class="step-label d-none d-md-inline">Pilih Buku</span>
            </div>
            <div class="step-connector" :class="step > 2 ? 'completed' : ''"></div>
            <div class="wizard-step" :class="step >= 3 ? 'active' : ''">
                <div class="step-circle">3</div>
                <span class="step-label d-none d-md-inline">Konfirmasi</span>
            </div>
        </div>

        {{-- Step 1: Pilih Mahasiswa --}}
        <div x-show="step === 1" x-transition>
            <x-form-card title="Pilih Mahasiswa" subtitle="Cari dan pilih mahasiswa peminjam">
                <div class="mb-3" style="position:relative;">
                    <label class="form-label-custom">Cari Mahasiswa <span style="color:var(--clr-danger);">*</span></label>
                    <div style="position:relative;">
                        <i class="bi bi-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--clr-muted);"></i>
                        <input type="text" class="form-input" style="padding-left:38px;" placeholder="Ketik nama atau NIM..."
                               x-model="mahasiswaSearch" @input="filterMahasiswa()">
                    </div>

                    {{-- Search results --}}
                    <div x-show="mahasiswaSearch.length > 0 && !selectedMahasiswa" class="mt-2" style="max-height:300px;overflow-y:auto;border:1px solid var(--clr-border);border-radius:var(--radius-md);">
                        <template x-for="mhs in filteredMahasiswa" :key="mhs.id">
                            <div @click="selectMahasiswa(mhs)" style="padding:12px 16px;cursor:pointer;border-bottom:1px solid var(--clr-border);display:flex;align-items:center;gap:12px;transition:background 0.15s;" onmouseover="this.style.background='var(--clr-bg)'" onmouseout="this.style.background='white'">
                                <div style="width:40px;height:40px;border-radius:50%;background:var(--clr-primary-lt);color:var(--clr-primary);display:flex;align-items:center;justify-content:center;font-weight:600;font-size:14px;" x-text="mhs.nama.charAt(0).toUpperCase()"></div>
                                <div>
                                    <div style="font-weight:500;font-size:14px;" x-text="mhs.nama"></div>
                                    <div style="font-size:12px;color:var(--clr-muted);" x-text="mhs.nim + ' · ' + mhs.kelas"></div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Selected mahasiswa card --}}
                <div x-show="selectedMahasiswa" x-transition class="info-box d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:44px;height:44px;border-radius:50%;background:var(--clr-primary);color:white;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:16px;" x-text="selectedMahasiswa ? selectedMahasiswa.nama.charAt(0).toUpperCase() : ''"></div>
                        <div>
                            <div style="font-weight:600;font-size:14px;" x-text="selectedMahasiswa ? selectedMahasiswa.nama : ''"></div>
                            <div style="font-size:13px;color:var(--clr-text-sub);" x-text="selectedMahasiswa ? selectedMahasiswa.nim + ' · ' + selectedMahasiswa.kelas : ''"></div>
                        </div>
                    </div>
                    <button type="button" @click="selectedMahasiswa = null; mahasiswaSearch = ''" class="action-btn action-delete"><i class="bi bi-x-lg"></i></button>
                </div>
                <input type="hidden" name="mahasiswa_id" :value="selectedMahasiswa ? selectedMahasiswa.id : ''">

                <div class="d-flex justify-content-end pt-4">
                    <button type="button" class="btn-primary-custom" @click="if(selectedMahasiswa) step = 2" :disabled="!selectedMahasiswa">
                        Lanjut <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </x-form-card>
        </div>

        {{-- Step 2: Pilih Buku --}}
        <div x-show="step === 2" x-transition>
            <div class="row g-4">
                <div class="col-lg-7">
                    <x-form-card title="Pilih Buku" subtitle="Cari dan tambahkan buku untuk dipinjam">
                        <div class="mb-3" style="position:relative;">
                            <i class="bi bi-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--clr-muted);z-index:1;"></i>
                            <input type="text" class="form-input" style="padding-left:38px;" placeholder="Cari judul buku..." x-model="bukuSearch">
                        </div>

                        <div style="max-height:400px;overflow-y:auto;">
                            <template x-for="buku in filteredBuku" :key="buku.id">
                                <div style="padding:12px;border:1px solid var(--clr-border);border-radius:var(--radius-md);margin-bottom:8px;display:flex;align-items:center;gap:12px;">
                                    <div style="width:48px;height:64px;border-radius:var(--radius-sm);background:var(--clr-bg);overflow:hidden;flex-shrink:0;">
                                        <template x-if="buku.sampul">
                                            <img :src="buku.sampul" style="width:100%;height:100%;object-fit:cover;">
                                        </template>
                                        <template x-if="!buku.sampul">
                                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--clr-muted);"><i class="bi bi-book"></i></div>
                                        </template>
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <div style="font-weight:500;font-size:14px;" x-text="buku.judul"></div>
                                        <div style="font-size:12px;color:var(--clr-muted);" x-text="buku.penulis + ' · ' + buku.kategori"></div>
                                        <div style="font-size:12px;color:var(--clr-text-sub);margin-top:2px;">Stok: <span x-text="buku.stok"></span> tersedia</div>
                                    </div>
                                    <button type="button" class="btn-primary-custom btn-sm-custom" @click="addBuku(buku)" x-show="!isBookSelected(buku.id)">
                                        <i class="bi bi-plus"></i> Tambah
                                    </button>
                                    <span x-show="isBookSelected(buku.id)" class="badge-custom badge-success"><i class="bi bi-check"></i> Dipilih</span>
                                </div>
                            </template>
                        </div>

                        <div class="mb-3 mt-3">
                            <label class="form-label-custom">Durasi Peminjaman (hari)</label>
                            <input type="number" name="lama_pinjam" min="1" max="14" x-model="lamaPinjam" class="form-input" style="max-width:200px;">
                        </div>

                        <div class="d-flex justify-content-between pt-3">
                            <button type="button" class="btn-secondary-custom" @click="step = 1">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </button>
                            <button type="button" class="btn-primary-custom" @click="if(selectedBooks.length > 0) step = 3" :disabled="selectedBooks.length === 0">
                                Lanjut <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </x-form-card>
                </div>

                {{-- Keranjang --}}
                <div class="col-lg-5">
                    <div class="content-card" style="position:sticky;top:80px;">
                        <div class="card-header-custom">
                            <h3 class="card-title">Keranjang</h3>
                            <x-badge type="primary" :text="'0'" x-text="selectedBooks.length + ' buku'" />
                        </div>
                        <div class="card-body-custom">
                            <template x-if="selectedBooks.length === 0">
                                <p style="text-align:center;color:var(--clr-muted);padding:24px 0;">Belum ada buku dipilih</p>
                            </template>
                            <template x-for="(book, idx) in selectedBooks" :key="book.id">
                                <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--clr-border);">
                                    <div style="flex:1;min-width:0;">
                                        <div style="font-weight:500;font-size:13px;" x-text="book.judul"></div>
                                        <div class="d-flex align-items-center gap-2 mt-1">
                                            <label style="font-size:12px;color:var(--clr-muted);">Jml:</label>
                                            <input type="number" :name="'jumlah[' + book.id + ']'" min="1" :max="book.stok" x-model="book.qty" style="width:60px;height:28px;border:1px solid var(--clr-border);border-radius:var(--radius-sm);text-align:center;font-size:12px;padding:0 4px;">
                                            <span style="font-size:12px;color:var(--clr-muted);">/ <span x-text="book.stok"></span></span>
                                        </div>
                                    </div>
                                    <button type="button" class="action-btn action-delete" @click="removeBuku(idx)"><i class="bi bi-x"></i></button>
                                    <input type="hidden" name="buku_ids[]" :value="book.id">
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Step 3: Konfirmasi --}}
        <div x-show="step === 3" x-transition>
            <x-form-card title="Konfirmasi Peminjaman" subtitle="Periksa kembali data peminjaman sebelum menyimpan">
                <div class="info-box mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <p style="font-size:12px;color:var(--clr-muted);margin-bottom:2px;">Mahasiswa</p>
                            <p style="font-weight:600;" x-text="selectedMahasiswa ? selectedMahasiswa.nama : ''"></p>
                        </div>
                        <div class="col-md-3">
                            <p style="font-size:12px;color:var(--clr-muted);margin-bottom:2px;">Durasi</p>
                            <p style="font-weight:600;" x-text="lamaPinjam + ' hari'"></p>
                        </div>
                        <div class="col-md-3">
                            <p style="font-size:12px;color:var(--clr-muted);margin-bottom:2px;">Total Buku</p>
                            <p style="font-weight:600;" x-text="selectedBooks.length + ' judul'"></p>
                        </div>
                    </div>
                </div>

                <div class="data-table-wrapper" style="border:1px solid var(--clr-border);border-radius:var(--radius-md);margin-bottom:20px;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Judul Buku</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="book in selectedBooks" :key="book.id">
                                <tr>
                                    <td x-text="book.judul" style="font-weight:500;"></td>
                                    <td x-text="book.qty + ' eksemplar'"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between pt-3">
                    <button type="button" class="btn-secondary-custom" @click="step = 2">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </button>
                    <button type="submit" class="btn-primary-custom" x-data="{ loading: false }" x-bind:disabled="loading" @click="loading = true">
                        <span x-show="loading" class="spinner-border spinner-border-sm"></span>
                        <span x-text="loading ? 'Memproses...' : 'Konfirmasi & Proses Peminjaman'"></span>
                    </button>
                </div>
            </x-form-card>
        </div>
    </form>
@endsection

@push('scripts')
<script>
function peminjaman() {
    const allMahasiswa = @json($mahasiswas);
    const sampulBaseUrl = '{{ asset("storage/sampul") }}/';
    const allBuku = @json($bukus->map(fn($b) => [
        'id' => $b->id,
        'judul' => $b->judul,
        'isbn' => $b->isbn,
        'stok' => $b->stok,
        'penulis' => $b->penulis->nama_penulis ?? '-',
        'kategori' => $b->kategori->nama_kategori ?? '-',
        'sampul' => $b->sampul,
    ])).map(b => ({ ...b, sampul: b.sampul ? sampulBaseUrl + b.sampul : null }));

    return {
        step: 1,
        mahasiswaSearch: '',
        selectedMahasiswa: null,
        filteredMahasiswa: [],
        bukuSearch: '',
        selectedBooks: [],
        lamaPinjam: 7,

        filterMahasiswa() {
            if (this.mahasiswaSearch.length < 1) { this.filteredMahasiswa = []; return; }
            const q = this.mahasiswaSearch.toLowerCase();
            this.filteredMahasiswa = allMahasiswa.filter(m =>
                m.nama.toLowerCase().includes(q) || m.nim.toLowerCase().includes(q)
            ).slice(0, 10);
        },

        selectMahasiswa(mhs) {
            this.selectedMahasiswa = mhs;
            this.mahasiswaSearch = '';
            this.filteredMahasiswa = [];
        },

        get filteredBuku() {
            if (this.bukuSearch.length < 1) return allBuku;
            const q = this.bukuSearch.toLowerCase();
            return allBuku.filter(b => b.judul.toLowerCase().includes(q));
        },

        isBookSelected(id) {
            return this.selectedBooks.some(b => b.id === id);
        },

        addBuku(buku) {
            if (!this.isBookSelected(buku.id)) {
                this.selectedBooks.push({ ...buku, qty: 1 });
            }
        },

        removeBuku(idx) {
            this.selectedBooks.splice(idx, 1);
        }
    }
}
</script>
@endpush
