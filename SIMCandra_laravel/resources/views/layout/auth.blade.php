<!DOCTYPE html>
<html lang="en">

@include('layout.head')

<body class="bg-gray-200"> {{-- Menggunakan class body dari template login --}}

    @yield('content')

    @include('layout.scripts')

</body>

</html> 