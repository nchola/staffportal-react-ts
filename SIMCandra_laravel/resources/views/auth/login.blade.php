@extends('layout.auth')

@section('content')
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100">
            <span class="mask bg-gradient-white opacity-6"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-dark shadow-primary border-radius-lg py-3 pe-1">
                                    {{-- Menggunakan logo dan judul dari view sebelumnya --}}
                                    <div class="row mt-2">
                                        <div class="col-12 text-center">
                                            <img src="{{ asset('template/logo.png') }}" alt="SIM Candra Logo" class="login-logo mb-2" style="width: 50px; height: 50px;">
                                            <h4 class="text-white font-weight-bolder">SIM Kepegawaian</h4>
                                            <p class="text-white text-sm">Portal Staf - Sistem Manajemen SDM</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                {{-- Display validation errors or custom login errors --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger text-white" role="alert">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- You might also check for specific session flash messages if used --}}
                                @if (session('error'))
                                    <div class="alert alert-danger text-white" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                {{-- Form Login --}}
                                <form role="form" class="text-start" action="#" method="POST"> {{-- Sesuaikan action dan method untuk route login Laravel --}}
                                    @csrf {{-- Laravel CSRF token --}}
                                    <div class="input-group input-group-outline my-3">
                                        {{-- <label class="form-label">Email</label> --}} {{-- Label di template Material Dashboard seringkali dihandle oleh JS --}}
                                        <input type="text" class="form-control" name="username" placeholder="Username" required> {{-- Gunakan name="username" --}}
                                    </div>
                                    <div class="input-group input-group-outline mb-3">
                                        {{-- <label class="form-label">Password</label> --}}
                                        <input type="password" class="form-control" name="password" placeholder="Password" required> {{-- Gunakan name="password" --}}
                                    </div>
                                    <div class="form-check form-switch d-flex align-items-center mb-3">
                                        <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" checked> {{-- Tambahkan name="remember" --}}
                                        <label class="form-check-label mb-0 ms-3" for="rememberMe">Remember me</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign in</button>
                                    </div>
                                    <div class="text-center">
                                        <a href="{{ route('register') }}" class="text-secondary text-sm">Belum punya akun? <u class="text-primary text-decoration-underline">Daftar</u></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
        </div>
    </main>

@endsection 