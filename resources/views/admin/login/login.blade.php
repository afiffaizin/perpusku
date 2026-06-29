<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — Perpus TRPL</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-[Inter] bg-gray-50 flex items-center justify-center p-4">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-xl overflow-hidden flex">
        {{-- Left: Visual --}}
        <div class="hidden lg:flex lg:w-1/2 bg-slate-800 relative items-center justify-center p-12">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-800 via-slate-700 to-slate-900"></div>
            <div class="relative z-10 text-center">
                <div class="flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur rounded-2xl mx-auto mb-8">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white mb-3">Perpus TRPL</h2>
                <p class="text-slate-300 text-sm leading-relaxed">Sistem Manajemen Perpustakaan<br>Program Studi TRPL</p>
                <div class="mt-10 flex justify-center gap-8 text-slate-400 text-xs">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">500+</div>
                        <div>Koleksi Buku</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">200+</div>
                        <div>Mahasiswa</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Form --}}
        <div class="w-full lg:w-1/2 p-8 sm:p-12 flex flex-col justify-center">
            <div class="lg:hidden flex items-center justify-center w-14 h-14 bg-slate-800 rounded-xl mx-auto mb-6">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>

            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-900">Selamat Datang</h3>
                <p class="text-gray-500 text-sm mt-2">Masuk ke sistem perpustakaan</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                        <input type="email" id="email" name="email"
                               class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition @error('email') border-red-300 focus:ring-red-500/20 focus:border-red-500 @enderror"
                               placeholder="admin@gmail.com" required autofocus>
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password" id="password" name="password"
                               class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition"
                               placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit"
                        class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-800">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</body>
</html>
