@extends('layouts.app')

@section('title', 'Контакты — СФЕРА')

@section('content')
<div class="container page-static">
    <h1>Контакты</h1>

    <div class="content-block">
        <p class="lead">
            Мы всегда рады помочь с выбором, подбором по рецепту и любыми вопросами
            по заказу. Свяжитесь с нами удобным способом.
        </p>

        <h3>Связаться с нами</h3>
        <ul>
            <li><strong>Телефон:</strong> <a href="tel:+74951850985">+7 (495) 185-09-85</a> — без выходных, 9:00–23:00</li>
            <li><strong>E-mail:</strong> <a href="mailto:info@sfera.ru">info@sfera.ru</a></li>
            <li><strong>WhatsApp / Telegram:</strong> +7 (495) 185-09-85</li>
        </ul>

        <h3>Шоу-рум</h3>
        <p>
            г. Москва, ул. Примерная, д. 10<br>
            Ежедневно с 10:00 до 21:00
        </p>

        <h3>Доставка</h3>
        <p>
            Доставляем заказы по всей России:
        </p>
        <ul>
            <li>Курьером по Москве — <strong>в день заказа</strong> или на следующий день.</li>
            <li>В регионы — <strong>СДЭК</strong>, <strong>Почта России</strong>, <strong>Boxberry</strong> — 2–7 дней.</li>
            <li>Бесплатная доставка при заказе <strong>от 5 000 ₽</strong>.</li>
        </ul>

        <h3>Реквизиты</h3>
        <p>
            ИП Иванов И. И.<br>
            ИНН: 770000000000<br>
            ОГРН: 300000000000000
        </p>

        <p>
            <a href="{{ route('guarantees') }}">Гарантии</a> ·
            <a href="{{ route('about') }}">О компании</a>
        </p>
    </div>
</div>
@endsection