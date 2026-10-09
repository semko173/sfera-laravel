<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Творческий Центр СФЕРА — Оптика и аксессуары')</title>
    
    <!-- Общие стили через Vite -->
    @vite(['resources/css/styles.css'])

    <!-- Место для стилей конкретных страниц -->
    @stack('styles')
    @stack('scripts')
</head>
<body>

    {{-- Подключаем перенесенную шапку --}}
    @include('partials.header')

    {{-- Сюда будет вставляться контент каждой страницы --}}
    @yield('content')

    {{-- Подключаем футер --}}
    @include('partials.footer')

</body>
</html>