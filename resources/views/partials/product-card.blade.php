<div class="product-card">
    <div class="product-card__image-wrap" style="position: relative;">
        <a href="{{ route('product.show', $product) }}" class="product-card__link">
            <div class="product-card__image">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
            </div>
        </a>

        @php
    $isFavorite = isset(session('favorites')[$product->id]);
@endphp

<form method="POST" action="{{ route('favorites.toggle') }}" class="product-card__fav-form">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <button type="submit"
            class="product-card__fav-btn {{ $isFavorite ? 'active' : '' }}"
            title="{{ $isFavorite ? 'Убрать из избранного' : 'В избранное' }}">
        <svg width="18" height="18" viewBox="0 0 24 24"
             fill="{{ $isFavorite ? 'currentColor' : 'none' }}"
             stroke="currentColor" stroke-width="2">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
        </svg>
    </button>
</form>
    </div>

    <div class="product-card__info">
        <span class="product-card__category">СФЕРА</span>
        <a href="{{ route('product.show', $product) }}">
            <h4 class="product-card__title">{{ $product->name }}</h4>
        </a>
        <div class="product-card__footer">
            <div class="product-card__price-block">
                @if($product->old_price)
                    <span class="product-card__price-old">
                        {{ number_format($product->old_price, 0, '', ' ') }} ₽
                    </span>
                @endif
                <div class="product-card__price">
                    {{ number_format($product->price, 0, '', ' ') }} ₽
                </div>
            </div>

            <form method="POST" action="{{ route('cart.add') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="product-card__cart-btn" title="Добавить в корзину">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>