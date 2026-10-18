@extends('layouts.app')

@section('title', $product->name . ' — СФЕРА')

@push('styles')
    <!-- Стили только для главной страницы -->
    <link rel="stylesheet" href="{{ asset('assets/sfera/css/product.css') }}">
@endpush

@section('content')
    <div class="product-detail container">
        <div class="breadcrumbs">
            @foreach ($breadcrumbs as $crumb)
                @if (!empty($crumb['url']))
                    <a href="{{ $crumb['url'] }}">{{ $crumb['title'] }}</a>
                @else
                    <span>{{ $crumb['title'] }}</span>
                @endif
                @if (!$loop->last) / @endif
            @endforeach
        </div>

        <div class="product-detail__wrapper">
            <div class="product-detail__gallery">
                <div class="product-detail__main-image">
                    @if ($product->image)
                        <img src="{{ asset($product->image) }}"
                             alt="{{ $product->name }}"
                             id="mainImage">
                    @endif
                </div>
            </div>

            <div class="product-detail__info">
                @if ($product->brand)
                    <p class="product-detail__brand">{{ $product->brand->name }}</p>
                @endif

                <h1 class="product-detail__title">{{ $product->name }}</h1>

                <div class="product-detail__rating">
                    <span class="stars">★★★★★</span>
                    <span class="reviews-count">(12 отзывов)</span>
                </div>

                <div class="product-detail__price">
                    @if ($product->old_price)
                        <span class="price-old">
                            {{ number_format($product->old_price, 0, '.', ' ') }} ₽
                        </span>
                    @endif
                    <span class="price-current">
                        {{ number_format($product->price, 0, '.', ' ') }} ₽
                    </span>
                </div>

                @if ($product->description)
                    <div class="product-detail__short-desc">
                        {{ $product->description }}
                    </div>
                @endif

                @php
    $isFavorite = isset(session('favorites')[$product->id]);
@endphp

<div class="product-detail__actions">
    <form method="POST" action="{{ route('cart.add') }}" style="display: inline;">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="quantity" value="1">
        <button type="submit" class="btn btn--primary add-to-cart" title="В корзину">
            В корзину
        </button>
    </form>

    <form method="POST" action="{{ route('favorites.toggle') }}" style="display: inline;">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <button type="submit"
                class="btn btn--favorite {{ $isFavorite ? 'active' : '' }}"
                title="{{ $isFavorite ? 'Убрать из избранного' : 'В избранное' }}">
            {{ $isFavorite ? 'В избранном' : 'В избранное' }}
        </button>
    </form>
</div>

                @if ($product->productAttributes->count())
                    <div class="product-detail__attributes">
                        <h3>Характеристики</h3>
                        <table class="attributes-table">
                            @foreach ($product->productAttributes as $pa)
                                <tr>
                                    <td>{{ $pa->attribute?->name }}</td>
                                    <td>{{ $pa->value }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endif
            </div>
        </div>

        @if ($product->description)
            <div class="product-detail__description">
                <h2>Описание</h2>
                <div class="description-content">
                    {!! $product->description !!}
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('.thumb').forEach(thumb => {
            thumb.addEventListener('click', function () {
                const newSrc = this.dataset.image;
                document.getElementById('mainImage').src = newSrc;
            });
        });
    </script>
@endsection