<header class="floating_header header">

    <!-- Верхняя часть -->
    <div class="wrapper_content header-top">

        <!-- Логотип -->
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/sfera/img/logo/logo_new_header.svg') }}" alt="Логотип">
            </a>
        </div>

        <!-- Поиск -->
        <form class="search-form" method="GET" action="/search">
            <button type="submit" class="find_button">
                <img src="{{ asset('assets/sfera/img/icons/Search_icon.svg.png') }}" alt="Поиск">
            </button>
            <input 
                type="text" 
                name="txt" 
                class="search-input" 
                autocomplete="off" 
                placeholder="Поиск 50 000+ моделей">
        </form>

        <!-- Контакты -->
        <div class="contacts">
            <a href="tel:+74951850985" class="phone">
                +7 495 185-09-85
            </a>
            <span class="work-time">
                без выходных 9:00–23:00
            </span>
        </div>

        <!-- Избранное и Корзина -->
        <div class="header-user-actions">
            <!-- Избранное -->
            <a href="{{ route('favorites.index') }}" class="header-action-btn js-fav-link" title="Избранное">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
    </svg>

    @php $favCount = count(session('favorites', [])); @endphp
    <span class="header-badge js-fav-badge" @if(!$favCount) style="display: none;" @endif>
        {{ $favCount }}
    </span>
</a>

            <!-- Корзина -->
            <a href="{{ route('cart.index') }}" title="Корзина">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>

                {{-- Подсчет количества товаров в корзине --}}
                @php
    $cartCount = array_sum(session('cart', []));
@endphp

<span class="header-badge js-cart-badge" @if(empty($cartCount)) style="display: none;" @endif>
    {{ $cartCount }}
</span>
            </a>
        </div>

        <!-- Профиль -->
        <div class="profile">
            @auth
                <a href="{{ route('profile.index') }}" class="profile-button">Профиль</a>
            @else
                <a href="{{ route('login') }}" class="profile-button">Войти</a>
                <a href="{{ route('register') }}" class="profile-button">Регистрация</a>
            @endauth
        </div>

    </div>

    <!-- Навигация -->
    <nav class="main-nav">
        <div class="wrapper_content">
            <ul class="menu">
                <li class="menu-item"><a href="{{ route('product.index') }}">Каталог</a></li>
                <li class="menu-item"><a href="/catalog?category[]=1">Солнцезащитные очки</a></li>
                <li class="menu-item"><a href="/catalog?category[]=2">Оправы</a></li>
                <li class="menu-item"><a href="/about">О компании</a></li>
                <li class="menu-item"><a href="/contacts">Контакты</a></li>
            </ul>
        </div>
    </nav>

</header>