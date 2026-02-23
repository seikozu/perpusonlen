<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Perpus</title>

    <!-- CSS TEMPLATE PURPLE -->
    <link rel="stylesheet" href="{{ asset('purple/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('purple/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('purple/assets/css/style.css') }}">
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    
                    @yield('content')

                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS TEMPLATE -->
<script src="{{ asset('purple/assets/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('purple/assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('purple/assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('purple/assets/js/template.js') }}"></script>
</body>
</html>
