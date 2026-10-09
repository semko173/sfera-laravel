@extends('layouts.app')

@section('title', 'Главная — Творческий Центр СФЕРА')

@push('styles')
    <!-- Стили только для главной страницы -->
    @vite(['resources/css/home.css'])
@endpush

@section('content')
<main class="main">
    <!-- 1. Современный Первый экран (Hero) -->
    <section class="hero-block">
        <div class="container hero-block__container">
            <div class="hero-block__content">
                <span class="hero-block__badge">Новая коллекция 2026</span>
                <h1 class="hero-block__title">Идеальная посадка и стиль для вашего зрения</h1>
                <p class="hero-block__subtitle">Бесплатная примерка до 4 пар на дому. Подбор линз по рецепту за 24 часа.</p>
                <div class="hero-block__actions">
                    <a href="{{ route('catalog.index') }}" class="btn btn--primary">Перейти в каталог</a>
                    <a href="/catalog/sun/" class="btn btn--outline">Солнцезащитные</a>
                </div>
            </div>
            <div class="hero-block__media">
                <img src="{{ asset('assets/sfera/img/banners/hero-glasses-2.jpg') }}" alt="Стильные очки Сфера" class="hero-block__img">
            </div>
        </div>
    </section>

    <!-- 2. Быстрый выбор по категориям -->
    <section class="categories section">
        <div class="container">
            <h2 class="section-title">Категории очков</h2>
            <div class="categories__grid">
                <a href="/catalog/vision/" class="category-card">
                    <span class="category-card__title">Оправы для зрения</span>
                </a>
                <a href="/catalog/sun/" class="category-card">
                    <span class="category-card__title">Солнцезащитные</span>
                </a>
                <a href="/catalog/computer/" class="category-card">
                    <span class="category-card__title">Для компьютера</span>
                </a>
                <a href="/catalog/accessories/" class="category-card">
                    <span class="category-card__title">Аксессуары</span>
                </a>
            </div>
        </div>
    </section>

    <!-- 3. Хиты продаж (Бэкенд-цикл) -->
    <section class="products section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Хиты продаж</h2>
                <a href="{{ route('catalog.index') }}" class="link-more">Все товары &rarr;</a>
            </div>
            
            <div class="products__grid products__grid--home">
                @forelse ($products as $item)
                    <div class="product-card">
                        <a href="/product/{{ $item->getKey() }}/" class="product-card__link">
                            <div class="product-card__image">
                                <img src="{{ asset($item->image ?? 'assets/sfera/img/no-image.jpg') }}" alt="{{ $item->name ?? $item->title }}">
                            </div>
                            <div class="product-card__info">
                                <h4 class="product-card__title">{{ $item->name ?? $item->title }}</h4>
                                <div class="product-card__price-block">
                                    @if(!empty($item->old_price))
                                        <span class="product-card__price-old">
                                            {{ number_format($item->old_price, 0, '', ' ') }} ₽
                                        </span>
                                    @endif
                                    
                                    <span class="product-card__price">
                                        {{ number_format($item->price, 0, '', ' ') }} ₽
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="no-products">Товары временно отсутствуют.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 4. Преимущества (УТП) -->
    <section class="features section">
        <div class="container">
            <div class="features__grid">
                <div class="feature-item">
                    <div class="feature-item__icon">🚚</div>
                    <h3 class="feature-item__title">Бесплатная доставка</h3>
                    <p class="feature-item__desc">При заказе от 5 000 ₽ по всей России</p>
                </div>
                <div class="feature-item">
                    <div class="feature-item__icon">👓</div>
                    <h3 class="feature-item__title">Примерка перед покупкой</h3>
                    <p class="feature-item__desc">Привезем до 4 моделей на выбор</p>
                </div>
                <div class="feature-item">
                    <div class="feature-item__icon">🛡️</div>
                    <h3 class="feature-item__title">Гарантия 1 год</h3>
                    <p class="feature-item__desc">На все оправы и покрытие линз</p>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection