@extends('layouts.app')

@section('title', 'Личный кабинет — СФЕРА')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sfera/css/profile.css') }}">
@endpush

@section('content')
<main class="profile-page">
    <div class="container">
        <div class="profile-layout">

            <aside class="profile-sidebar">
                <div class="profile-user-header">
                    <h3 class="profile-user-name">
                        {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                    </h3>
                    <div class="profile-user-email">{{ auth()->user()->email }}</div>
                    @if(auth()->user()->phone)
                        <div class="profile-user-phone">{{ auth()->user()->phone }}</div>
                    @endif
                </div>

                <nav class="profile-nav">
                    <a href="{{ route('profile.orders') }}"
                       class="profile-nav__link @if(request()->routeIs('profile.orders') || request()->routeIs('profile.index')) active @endif">
                        Мои заказы
                    </a>
                    <a href="{{ route('profile.prescriptions') }}"
                       class="profile-nav__link @if(request()->routeIs('profile.prescriptions')) active @endif">
                        Мои рецепты
                    </a>
                    <a href="{{ route('profile.settings') }}"
                       class="profile-nav__link @if(request()->routeIs('profile.settings')) active @endif">
                        Настройки
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">Выйти</button>
                    </form>
                </nav>
            </aside>

            <section class="profile-content">
                @if(session('status'))
                    <div class="auth-alert auth-alert--success">
                        {{ session('status') }}
                    </div>
                @endif

                @yield('profile-content')
            </section>

        </div>
    </div>
</main>
@endsection

@push('scripts')
    <script src="{{ asset('assets/sfera/js/profile.js') }}"></script>
@endpush