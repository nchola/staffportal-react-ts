<!DOCTYPE html>
<html lang="en">

@include('layout.head')

<body class="g-sidenav-show  bg-gray-100">

    {{-- Bagian Sidebar --}}
    @include('layout.sidebar')

    {{-- <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg "> --}}
    <main class="main-content position-relative border-radius-lg ">

        {{-- Bagian Header (Navbar) --}}
        @include('layout.header')

        {{-- Bagian Konten Utama --}}
        <div class="container-fluid py-4">
            @yield('content')
        </div>

        {{-- Bagian Footer --}}
        @include('layout.footer')

    </main>

    {{-- Fixed Plugin (Optional, jika ada di template) --}}
    {{-- <div class="fixed-plugin"> ... </div> --}}

    @include('layout.scripts')

</body>

</html> 