<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Perpusku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body x-data="{ sidebarOpen: false }">

    {{-- Sidebar backdrop mobile --}}
    <div class="sidebar-backdrop" :class="sidebarOpen ? 'show' : ''" @click="sidebarOpen = false"></div>

    <div class="app-wrapper">
        {{-- SIDEBAR --}}
        <aside class="sidebar" :class="sidebarOpen ? 'show' : ''">
            {{-- Logo --}}
            <div class="sidebar-logo">
                <div class="logo-icon">
                    <i class="bi bi-book-half"></i>
                </div>
                <div class="logo-text">
                    <h1>Perpusku</h1>
                    <span>Library System</span>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="sidebar-nav">
                <p class="nav-section">Menu</p>
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
                <a href="{{ route('admin.viewBuku') }}"
                    class="nav-item {{ request()->routeIs('admin.viewBuku', 'admin.tambahBuku', 'admin.editBuku', 'admin.detailBuku') ? 'active' : '' }}">
                    <i class="bi bi-book-fill"></i> Buku
                </a>
                <a href="{{ route('admin.mahasiswa.index') }}"
                    class="nav-item {{ request()->routeIs('admin.mahasiswa*', 'admin.addMahasiswa', 'admin.storeMahasiswa', 'admin.updateMahasiswa') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Mahasiswa
                </a>

                <p class="nav-section">Transaksi</p>
                <a href="{{ route('admin.viewPeminjam') }}"
                    class="nav-item {{ request()->routeIs('admin.viewPeminjam', 'admin.tambahPeminjam', 'admin.detailPeminjam') ? 'active' : '' }}">
                    <i class="bi bi-arrow-left-right"></i> Peminjaman
                </a>
                <a href="{{ route('admin.historyPeminjam') }}"
                    class="nav-item {{ request()->routeIs('admin.historyPeminjam', 'admin.detailPeminjamHistory') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i> Riwayat
                </a>
            </nav>

            {{-- User --}}
            <div class="sidebar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="user-details">
                    <p class="user-name">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="user-role">Administrator</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn" title="Keluar">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <div class="main-content">
            {{-- Topbar --}}
            <header class="topbar">
                <div class="breadcrumb-area">
                    <button class="toggle-sidebar" @click="sidebarOpen = !sidebarOpen">
                        <i class="bi bi-list" style="font-size: 20px;"></i>
                    </button>
                    <nav aria-label="breadcrumb">
                        @yield('breadcrumb')
                    </nav>
                </div>
                <div class="user-area">
                    <button class="notification-btn" title="Notifikasi">
                        <i class="bi bi-bell"></i>
                    </button>
                    <div class="user-info">
                        <span class="user-name d-none d-md-inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                        <div class="avatar-circle">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page body --}}
            <div class="page-body">
                {{-- Flash messages --}}
                @if (session('success'))
                    <div class="flash-alert flash-success" x-data="{ show: true }" x-show="show" x-transition
                        x-init="setTimeout(() => show = false, 4000)">
                        <i class="bi bi-check-circle"></i>
                        <span style="flex:1">{{ session('success') }}</span>
                        <button class="flash-close" @click="show = false"><i class="bi bi-x"></i></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="flash-alert flash-error" x-data="{ show: true }" x-show="show" x-transition
                        x-init="setTimeout(() => show = false, 4000)">
                        <i class="bi bi-x-circle"></i>
                        <span style="flex:1">{{ session('error') }}</span>
                        <button class="flash-close" @click="show = false"><i class="bi bi-x"></i></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
