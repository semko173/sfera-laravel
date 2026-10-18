@extends('layouts.app')

@section('title', $query ? "Поиск: {$query} — СФЕРА" : 'Поиск — СФЕРА')
<link rel="stylesheet" href="{{ asset('assets/sfera/css/catalog.css') }}">
@section('content')
<main class="search-page">
    <div class="container">

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

        <h1 class="page-title">
            @if ($query)
                Результаты поиска: «{{ $query }}»
            @else
                Поиск
            @endif
        </h1>

        @if ($query === '')
            <p class="search-hint">Введите запрос в поисковой строке.</p>
        @elseif (mb_strlen($query) < 2)
            <p class="search-hint">Запрос слишком короткий — введите хотя бы 2 символа.</p>
        @elseif ($products->isEmpty())
            <div class="search-empty">
                <p>По запросу «{{ $query }}» ничего не найдено.</p>
                <a href="{{ route('product.index') }}" class="btn btn--primary">Перейти в каталог</a>
            </div>
        @else
            <p class="search-count">Найдено: {{ $products->total() }}</p>

            <div class="products__grid">
                @foreach ($products as $product)
                    <div class="product-card">
                        <a href="{{ route('product.show', $product) }}" class="product-card__link">
                            <div class="product-card__image">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                            </div>
                            <div class="product-card__info">
                                <h4 class="product-card__title">{{ $product->name }}</h4>
                                <div class="product-card__price-block">
                                    @if($product->old_price)
                                        <span class="product-card__price-old">
                                            {{ number_format($product->old_price, 0, '', ' ') }} ₽
                                        </span>
                                    @endif
                                    <span class="product-card__price">
                                        {{ number_format($product->price, 0, '', ' ') }} ₽
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            {{ $products->links() }}
        @endif

    </div>
</main>
@endsection