<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Library Management Dashboard</title>



    <link rel="shortcut icon" href="{{ asset('assets/auth/static/images/logo/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon"
        href="{{ asset('assets/auth/static/images/logo/favicon.png') }}"
        type="image/png">

    <link rel="stylesheet" href="{{ asset('assets/auth/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/auth/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/auth/compiled/css/iconly.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/toastify-js/src/toastify.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/sweetalert2/sweetalert2.min.css') }}">

    @yield('styles')
</head>

<body>
    <script src="{{ asset('assets/auth/static/js/initTheme.js') }} "></script>
    <script src="{{ asset('assets/auth/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/auth/static/js/pages/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/auth/jquery-3.6.0.min.js') }}"></script>
    <div id="app">
        @include('partials.sidebar')
        <div id="main">
            <header>
                @include('partials.navbar')
            </header>
            @yield('content')

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2024 &copy; RaZoR</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                            by <a href="https://razorisuru.com">Isuru</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/auth/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/auth/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>


    <script src="{{ asset('assets/auth/compiled/js/app.js') }}"></script>

    <script>
        // If you want to use tooltips in your project, we suggest initializing them globally
        // instead of a "per-page" level.
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        }, false);
    </script>

    @yield('scripts')





</body>

</html>
