<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'СФЕРА')</title>

    <link rel="stylesheet" href="{{ asset('assets/sfera/styles.css') }}">
    @stack('styles')
    <script src="{{ asset('assets/sfera/js/cart.js') }}"></script>
    <script src="{{ asset('assets/sfera/js/favorites.js') }}"></script>
    @stack('scripts')
</head>
<body>
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>