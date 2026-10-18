@extends('layouts.app')
@push('styles')
    <!-- Стили только для главной страницы -->
    <link rel="stylesheet" href="{{ asset('assets/sfera/css/cart.css') }}">
@endpush
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sfera/css/cart.css') }}">
    <style>
        .cart-toast {
            position: fixed; top: 20px; right: 20px;
            padding: 12px 20px; border-radius: 8px;
            background: #333; color: #fff; font-size: 14px;
            opacity: 0; transform: translateY(-10px);
            transition: opacity 0.3s, transform 0.3s;
            z-index: 9999;
        }
        .cart-toast--visible { opacity: 1; transform: translateY(0); }
        .cart-toast--success { background: #16a34a; }
        .cart-toast--error { background: #dc2626; }
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('assets/sfera/js/cart.js') }}"></script>
@endpush
@section('content')
    <div class="wrapper_content page-basket">
        <h1 class="page-title">Корзина</h1>

        @if (!empty($cart))
            <div class="basket-layout">
                <div class="basket-items">
                    <div class="basket-items__header">
    <span>Товар</span>
    <form method="POST" action="{{ route('cart.clear') }}" onsubmit="return confirm('Очистить корзину?');">
        @csrf
        <button type="submit" class="basket-clear-link">Очистить корзину</button>
    </form>
</div>

                    @php
                        $totalCount = array_sum($cart);
                        $totalSum = 0;
                    @endphp

                    @foreach ($cart as $id => $qty)
                        @php
                            $product = $products[$id] ?? null;
                            if (!$product) continue;
                            $sum = $product->price * $qty;
                            $totalSum += $sum;
                        @endphp

                        <div class="basket-item">
                            <a href="{{ route('product.show', $product) }}" class="basket-item__image">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                            </a>

                            <div class="basket-item__info">
                                <a href="{{ route('product.show', $product) }}" class="basket-item__title">
                                    {{ $product->name }}
                                </a>
                                <div class="basket-item__price-unit">
                                    {{ number_format($product->price, 0, '', ' ') }} ₽ / шт.
                                </div>
                            </div>

                            <div class="basket-item__qty">
    <form method="POST" action="{{ route('cart.update') }}" class="qty-form">
        @csrf
        <input type="hidden" name="product_id" value="{{ $id }}">

        <button type="submit" name="quantity" value="{{ $qty - 1 }}"
                class="qty-btn qty-btn--minus"
                @if($qty <= 1) disabled @endif>-</button>

        <span class="qty-value">{{ $qty }}</span>

        <button type="submit" name="quantity" value="{{ $qty + 1 }}"
                class="qty-btn qty-btn--plus">+</button>
    </form>
</div>

                            <div class="basket-item__sum">
                                {{ number_format($sum, 0, '', ' ') }} ₽
                            </div>

                            <div class="basket-item__actions">
                                <form method="POST" action="{{ route('cart.remove') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                    <button type="submit" class="basket-action-btn remove" title="Удалить">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <aside class="basket-summary">
                    <h3 class="basket-summary__title">Детали заказа</h3>

                    <div class="basket-summary__row">
                        <span>Товары ({{ $totalCount }}):</span>
                        <span>{{ number_format($totalSum, 0, '', ' ') }} ₽</span>
                    </div>

                    <div class="basket-summary__row total">
                        <span>Итого к оплате:</span>
                        <strong class="total-price">{{ number_format($totalSum, 0, '', ' ') }} ₽</strong>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-checkout">
    Перейти к оформлению
</a>
                </aside>
            </div>
        @else
            <div class="empty-state">
                <p class="empty-state__text">Ваша корзина пуста</p>
                <a href="{{ route('product.index') }}" class="btn-primary">Перейти в каталог</a>
            </div>
        @endif
    </div>
@endsection