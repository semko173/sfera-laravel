@extends('layouts.app')

@section('title', 'Вход — СФЕРА')
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

            @if (session('status'))
                <div class="auth-alert auth-alert--success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="auth-tabs">
                <a href="{{ route('login') }}" class="auth-tab auth-tab--active">Вход</a>
                <a href="{{ route('register') }}" class="auth-tab">Регистрация</a>
            </div>

            <form action="{{ route('login') }}" method="POST" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="auth-email">Email</label>
                    <input type="email" id="auth-email" name="email" required
                           placeholder="name@example.com"
                           value="{{ old('email') }}">
                    @error('email') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="auth-password">Пароль</label>
                    <input type="password" id="auth-password" name="password" required
                           minlength="8" placeholder="Минимум 8 символов">
                    @error('password') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group form-group--checkbox">
                    <label>
                        <input type="checkbox" name="remember" value="1">
                        Запомнить меня
                    </label>
                </div>

                <button type="submit" class="btn btn--primary btn--full">Войти</button>

                <a href="{{ route('password.request') }}" class="auth-link">Забыли пароль?</a>
            </form>

        </div>
    </div>
</main>
@endsection
