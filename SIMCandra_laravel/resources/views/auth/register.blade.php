@extends('layout.auth')

@section('content')
<main class="main-content mt-0">
    <div class="page-header align-items-start min-vh-100">
        <span class="mask bg-gradient-white opacity-6"></span>
        <div class="container my-auto">
            <div class="row">
                <div class="col-lg-4 col-md-8 col-12 mx-auto">
                    <div class="card z-index-0 fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-dark shadow-primary border-radius-lg py-3 pe-1">
                                <div class="row mt-2">
                                    <div class="col-12 text-center">
                                        <img src="{{ asset('template/logo.png') }}" alt="SIM Candra Logo" class="login-logo mb-2" style="width: 50px; height: 50px;">
                                        <h4 class="text-white font-weight-bolder">SIM Candra</h4>
                                        <p class="text-white text-sm">Pendaftaran Calon Karyawan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger text-white" role="alert">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form role="form" class="text-start" action="{{ route('register') }}" method="POST">
                                @csrf
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" class="form-control" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username') }}" required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password" required>
                                </div>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" class="form-control" name="phone" placeholder="Nomor HP (opsional)" value="{{ old('phone') }}">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Daftar</button>
                                </div>
                                <div class="text-center">
                                    <a href="{{ route('login') }}" class="text-dark text-sm">Sudah punya akun? Login</a>
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