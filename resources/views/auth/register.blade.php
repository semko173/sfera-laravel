@extends('layouts.app')

@section('title', 'Регистрация — СФЕРА')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sfera/css/auth.css') }}">
@endpush
@section('content')
<main class="auth-page">
    <div class="container">
        <div class="auth-card">

            @if (session('error'))
                <div class="auth-alert auth-alert--error">
                    {{ session('error') }}
                </div>
            @endif

            <div class="auth-tabs">
                <a href="{{ route('login') }}" class="auth-tab">Вход</a>
                <a href="{{ route('register') }}" class="auth-tab auth-tab--active">Регистрация</a>
            </div>

            <form action="{{ route('register') }}" method="POST" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="reg-name">Ваше имя</label>
                    <input type="text" id="reg-name" name="first_name" required placeholder="Иван"
                           value="{{ old('name') }}">
                    @error('name') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="auth-email">Email</label>
                    <input type="email" id="auth-email" name="email" required placeholder="name@example.com"
                           value="{{ old('email') }}">
                    @error('email') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="auth-password">Пароль</label>
                    <input type="password" id="auth-password" name="password" required minlength="8"
                           placeholder="Минимум 8 символов">
                    @error('password') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="auth-password-confirm">Повторите пароль</label>
                    <input type="password" id="auth-password-confirm" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn--primary btn--full">Зарегистрироваться</button>
            </form>

        </div>
    </div>
</main>
@endsection
