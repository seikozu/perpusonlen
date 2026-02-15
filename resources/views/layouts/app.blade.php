<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Purple Admin</title>

    {{-- CSS GLOBAL --}}
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
    /* Biar tulisan kiri & icon kanan */
    .sidebar .nav .nav-item .nav-link {
        display: flex;
        justify-content: space-between; /* kiri-kanan */
        align-items: center;
    }

    /* Pastikan teks tetap di kiri */
    .sidebar .nav .nav-item .nav-link .menu-title {
        order: 1;
    }

    /* Pindahkan icon ke kanan */
    .sidebar .nav .nav-item .nav-link .menu-icon {
        order: 2;
        margin-left: auto;
    }
    </style>
</head>

<body>
<div class="container-scroller">

    {{-- NAVBAR --}}
    @include('layouts.navbar')

    <div class="container-fluid page-body-wrapper">

        {{-- SIDEBAR --}}
        @include('layouts.sidebar')

        {{-- MAIN CONTENT --}}
        @include('layouts.main')

    </div>
</div>

{{-- JS GLOBAL --}}
<script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/js/misc.js') }}"></script>

@stack('js')
</body>
</html>
