<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — Perpusku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="background: var(--clr-bg);">
    <div class="login-wrapper">
        {{-- Left panel --}}
        <div class="login-left">
            <div class="login-left-content">
                <div
                    style="width:72px;height:72px;background:rgba(255,255,255,0.12);border-radius:var(--radius-lg);display:flex;align-items:center;justify-content:center;margin:0 auto 24px;">
                    <i class="bi bi-book-half" style="font-size:32px;color:white;"></i>
                </div>
                <h2 style="font-size:28px;font-weight:700;margin-bottom:8px;letter-spacing:-0.01em;">Perpusku</h2>
                <p style="font-size:14px;color:#C7D2FE;line-height:1.7;margin-bottom:40px;">
                    Kelola perpustakaan dengan lebih efisien.<br>
                    Sistem manajemen modern untuk buku, mahasiswa, dan peminjaman.
                </p>
                {{-- SVG illustration: bookshelves --}}
                <svg viewBox="0 0 300 160" fill="none" xmlns="http://www.w3.org/2000/svg"
                    style="width:260px;opacity:0.6;margin:0 auto;">
                    <rect x="20" y="120" width="260" height="4" rx="2" fill="rgba(255,255,255,0.2)" />
                    <rect x="20" y="60" width="260" height="4" rx="2" fill="rgba(255,255,255,0.2)" />
                    <rect x="40" y="64" width="20" height="56" rx="3" fill="#6366F1" />
                    <rect x="65" y="74" width="18" height="46" rx="3" fill="#818CF8" />
                    <rect x="88" y="68" width="22" height="52" rx="3" fill="#4F46E5" />
                    <rect x="115" y="78" width="16" height="42" rx="3" fill="#A5B4FC" />
                    <rect x="136" y="70" width="20" height="50" rx="3" fill="#6366F1" />
                    <rect x="161" y="64" width="24" height="56" rx="3" fill="#4338CA" />
                    <rect x="190" y="76" width="18" height="44" rx="3" fill="#818CF8" />
                    <rect x="213" y="68" width="22" height="52" rx="3" fill="#6366F1" />
                    <rect x="240" y="80" width="16" height="40" rx="3" fill="#A5B4FC" />
                </svg>
                <div style="display:flex;justify-content:center;gap:48px;margin-top:32px;">
                    <div style="text-align:center;">
                        <div style="font-size:24px;font-weight:700;">500+</div>
                        <div style="font-size:12px;color:#C7D2FE;">Koleksi Buku</div>
                    </div>
                    <div style="text-align:center;">
                        <div style="font-size:24px;font-weight:700;">200+</div>
                        <div style="font-size:12px;color:#C7D2FE;">Mahasiswa</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right panel: form --}}
        <div class="login-right">
            <div class="login-form-box">
                <div class="d-lg-none text-center mb-4">
                    <div
                        style="width:56px;height:56px;background:var(--sidebar-bg);border-radius:var(--radius-lg);display:inline-flex;align-items:center;justify-content:center;margin-bottom:8px;">
                        <i class="bi bi-book-half" style="font-size:24px;color:white;"></i>
                    </div>
                </div>

                <div class="text-center mb-4">
                    <h3 style="font-size:24px;font-weight:700;color:var(--clr-text);margin-bottom:4px;">Selamat datang
                        kembali</h3>
                    <p style="font-size:14px;color:var(--clr-muted);">Masuk ke sistem perpustakaan</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label-custom" for="email">Email</label>
                        <div style="position:relative;">
                            <i class="bi bi-envelope"
                                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--clr-muted);font-size:16px;"></i>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="form-input @error('email') is-invalid @enderror" style="padding-left:38px;"
                                placeholder="admin@gmail.com" required autofocus>
                        </div>
                        @error('email')
                            <div class="invalid-feedback-custom">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom" for="password">Password</label>
                        <div style="position:relative;">
                            <i class="bi bi-lock"
                                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--clr-muted);font-size:16px;"></i>
                            <input type="password" id="password" name="password" class="form-input"
                                style="padding-left:38px;" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-custom w-100 justify-content-center"
                        style="height:46px;font-size:15px;">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
