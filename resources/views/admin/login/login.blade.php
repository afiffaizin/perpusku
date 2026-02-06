@extends('admin.layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="card login-container border-0 shadow-lg rounded-4 overflow-hidden w-100 m-3">
        <div class="row g-0">
            {{-- KIRI: Carousel --}}
            <div class="col-lg-6 d-none d-lg-block p-0">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/carousel/carousel3.png') }}" class="d-block w-100 carousel-img"
                                alt="Slide 1">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/carousel/carousel2.png') }}" class="d-block w-100 carousel-img"
                                alt="Slide 2">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/carousel/carousel1.png') }}" class="d-block w-100 carousel-img"
                                alt="Slide 3">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            {{-- KANAN: Form --}}
            <div class="col-lg-6 bg-white p-5 d-flex flex-column justify-content-center">
                <div class="text-center mb-4">
                    <i class="bi bi-book-half display-4 text-navy"></i>
                    <h3 class="fw-bold mt-3">Selamat Datang</h3>
                    <p class="text-secondary small">Sistem Peminjaman Buku</p>
                </div>
                {{-- Alert untuk login gagal --}}
                {{-- @if ($errors->has('login_error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $errors->first('login_error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="div">
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-person text-secondary"></i>
                            </span>
                            <input type="email" name="email"
                                class="form-control bg-light border-start-0 ps-0 @error('email') is-invalid @enderror"
                                placeholder="Email" required autofocus>
                        </div>
                        @error('email')
                            <div class="text-danger small ">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="input-group mb-4">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-lock text-secondary"></i>
                        </span>
                        <input type="password" name="password" class="form-control bg-light border-start-0 ps-0"
                            placeholder="Password" required>
                    </div>

                    <button class="btn btn-navy w-100 py-2 rounded-3 fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
                    </button>
                </form>
            </div>

        </div>
    </div>
@endsection
