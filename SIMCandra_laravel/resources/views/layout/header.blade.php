<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                {{-- Breadcrumb placeholder, sesuaikan dengan halaman saat ini --}}
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">@yield('title')</li>
            </ol>
            {{-- Judul halaman saat ini --}}
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                {{-- Search bar dari template (opsional) --}}
                {{-- <div class="input-group input-group-outline">
                    <label class="form-label">Type here...</label>
                    <input type="text" class="form-control">
                </div> --}}
            </div>
            <ul class="navbar-nav  justify-content-end">
                {{-- Contoh link di kanan navbar (opsional) --}}
                {{-- <li class="nav-item d-flex align-items-center">
                    <a class="btn btn-outline-primary btn-sm mb-0 me-3" target="_blank" href="#">Online Builder</a>
                </li> --}}
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    {{-- Tombol toggle sidebar untuk mobile --}}
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item px-3 d-flex align-items-center">
                    {{-- Tombol settings (opsional) --}}
                    {{-- <a href="javascript:;" class="nav-link text-body p-0">
                        <i class="material-symbols-rounded fixed-plugin-button-nav">settings</i>
                    </a> --}}
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    {{-- Dropdown notifikasi (opsional) --}}
                    {{-- <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="material-symbols-rounded">notifications</i>
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                        ...
                    </ul> --}}
                </li>
                {{-- Link Nama Pengguna --}}
                <li class="nav-item d-flex align-items-center">
                    <a href="#" class="nav-link text-body font-weight-bold px-0">
                        <i class="material-symbols-rounded me-sm-1">account_circle</i> {{-- Ikon User --}}
                        <span class="d-sm-inline d-none">
                            {{ Auth::check() ? Auth::user()->name . ' - ' . Auth::user()->role : 'Guest' }}
                        </span>
                    </a>
                </li>
                @auth
                {{-- Link Logout --}}
                <li class="nav-item d-flex align-items-center">
                    <a href="#" class="nav-link text-body font-weight-bold px-0" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="material-symbols-rounded me-sm-1">logout</i> {{-- Ikon Logout --}}
                        <span class="d-sm-inline d-none">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar --> 