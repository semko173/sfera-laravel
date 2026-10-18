@extends('layouts.app')

@section('title', 'Избранное — СФЕРА')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sfera/css/catalog.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/sfera/css/favorites.css') }}">
@endpush
@section('content')
<main class="favorites-page">
    <div class="container">
        <h1 class="page-title">Избранное</h1>

        @if ($products->isEmpty())
            <div class="empty-state">
                <p class="empty-state__text">В избранном пока пусто</p>
                <a href="{{ route('product.index') }}" class="btn btn--primary">Перейти в каталог</a>
            </div>
        @else
            <div class="favorites-header">
                <span>Товаров: {{ $products->count() }}</span>
                <form method="POST" action="{{ route('favorites.clear') }}"
                      onsubmit="return confirm('Очистить избранное?');">
                    @csrf
                    <button type="submit" class="btn-clear-link">Очистить избранное</button>
                </form>
            </div>

            <div class="products__grid">
                @foreach ($products as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        @endif
    </div>
</main>
@endsection