{{-- resources/views/test-adminlte.blade.php --}}
@extends('adminlte::page')

@section('title', 'AdminPanel')

@section('content_header')
    <h1>AdminLTE Aktif</h1>
@endsection

@section('content')
    <div class="alert alert-success">
        AdminLTE berhasil berjalan 🎉
    </div>

    <!-- Logout Form -->
    {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form> --}}
@endsection
