@extends('layouts.app')

@section('title', 'Заказ успешно оформлен — СФЕРА')

@section('content')
<main class="container success-page">
    <div class="success-card">
        <div class="success-icon">✓</div>
        <h1>Спасибо за заказ!</h1>
        <p>Ваш заказ <strong>#{{ $order->id }}</strong> успешно создан.</p>
        <p>Сумма к оплате: <strong>{{ number_format((float) $order->total_price, 0, '', ' ') }} ₽</strong></p>
        <p>Мы свяжемся с вами в ближайшее время для подтверждения деталей.</p>

        <a href="{{ route('home') }}" class="btn btn--primary">Вернуться на главную</a>
        <a href="{{ route('profile.orders') }}" class="btn btn--outline">Мои заказы</a>
    </div>
</main>
@endsection