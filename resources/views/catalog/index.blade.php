@extends('layouts.app') {{-- Важен точный путь к макету --}}
{{-- Подключаем отдельный CSS-файл каталога --}}
@push('styles')
    <!-- Стили только для главной страницы -->
    @vite(['resources/css/catalog.css'])
@endpush

{{-- 3. ОБЯЗАТЕЛЬНО: Открываем секцию контента --}}
@section('content')
    <main class="main">
        <section class="products">
            <div class="container">

                <h1 class="section-title">Каталог товаров</h1>

                <div class="products__content">

                    <!-- Боковая панель фильтров -->
                    <aside class="products__filters">
    <form action="{{ route('catalog.index') }}" method="GET" id="filter-form">
        <div class="products__filters-top">
            <h3 class="products__filters-title">Фильтры</h3>
            @if(request()->query())
                <a href="{{ route('catalog.index') }}" class="products__filters-reset">Сбросить</a>
            @endif
        </div>

        <!-- 1. Категории -->
        <div class="products__filter">
            <div class="products__filter-header">
                <h4 class="products__filter-title">Категория</h4>
                <svg class="products__filter-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>
            <div class="products__filter-body">
                @foreach($categories as $category)
                    <label>
                        <input type="checkbox" name="category[]" value="{{ $category->id }}"
                            {{ in_array($category->id, (array) request('category')) ? 'checked' : '' }}>
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <!-- 2. Бренды -->
        <div class="products__filter">
            <div class="products__filter-header">
                <h4 class="products__filter-title">Бренд</h4>
                <svg class="products__filter-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>
            <div class="products__filter-body">
                @foreach($brands as $brand)
                    <label>
                        <input type="checkbox" name="brands[]" value="{{ $brand->id }}"
                            {{ in_array($brand->id, (array) request('brands')) ? 'checked' : '' }}>
                        {{ $brand->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <!-- 3. Диапазон цен -->
        <div class="products__filter">
            <div class="products__filter-header">
                <h4 class="products__filter-title">Цена, ₽</h4>
                <svg class="products__filter-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>
            <div class="products__filter-body">
                <div class="products__filter-price-inputs">
                    <input type="number" name="price_min" placeholder="От" value="{{ request('price_min') }}">
                    <input type="number" name="price_max" placeholder="До" value="{{ request('price_max') }}">
                </div>
            </div>
        </div>

        <!-- 4. Динамические атрибуты -->
        @foreach($attributes as $attribute)
            @if($attribute->options->isNotEmpty())
                <div class="products__filter">
                    <div class="products__filter-header">
                        <h4 class="products__filter-title">{{ $attribute->name }}</h4>
                        <svg class="products__filter-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </div>
                    <div class="products__filter-body">
                        @foreach($attribute->options as $option)
                            <label>
                                <input type="checkbox" 
                                       name="attrs[{{ $attribute->id }}][]" 
                                       value="{{ $option }}"
                                       {{ in_array($option, (array) request("attrs.{$attribute->id}")) ? 'checked' : '' }}>
                                {{ $option }}
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        <button type="submit" class="btn-filter">Применить</button>
    </form>
</aside>

                    <!-- Правая часть: карточки товаров -->
<div class="products__main">
    <div class="products__grid">
        @forelse($products as $product)
            @include('partials.product-card', ['product' => $product])
        @empty
            <p class="no-products">Товары по выбранным критериям не найдены.</p>
        @endforelse
    </div>
</div>

        </div>

    </div>
</section>
</main>
@endsection {{-- 4. ОБЯЗАТЕЛЬНО: Закрываем секцию --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterHeaders = document.querySelectorAll('.products__filter-header');

        filterHeaders.forEach(header => {
            header.addEventListener('click', function () {
                const filterBlock = this.closest('.products__filter');
                filterBlock.classList.toggle('is-closed');
            });
        });
    });
</script>
@endpush