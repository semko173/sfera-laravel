@extends('layouts.app')

@section('title', 'Оформление заказа — СФЕРА')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/sfera/css/checkout.css') }}">
@endpush

@section('content')
<main class="container checkout-page">
    <h1>Оформление заказа</h1>

    @if (session('error'))
        <div class="alert alert--danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert--danger">
            @foreach ($errors->all() as $err)
                <div>{{ $err }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST" class="checkout-form">
        @csrf

        <div class="checkout-grid">

            <div class="checkout-section">
                <h2>1. Данные покупателя</h2>

                <div class="form-group">
                    <label for="name">ФИО *</label>
                    <input type="text" id="name" name="name" required
                           placeholder="Иванов Иван Иванович"
                           value="{{ old('name', trim($user->first_name.' '.$user->last_name)) }}">
                    @error('name') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Телефон *</label>
                    <input type="tel" id="phone" name="phone" required
                           placeholder="+7 (999) 000-00-00"
                           value="{{ old('phone', $user->phone) }}">
                    @error('phone') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email"
                           placeholder="example@mail.ru"
                           value="{{ old('email', $user->email) }}">
                    @error('email') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                @if ($prescriptions->isNotEmpty())
                    <div class="form-group">
                        <label for="prescription_id">Рецепт на очки</label>
                        <select name="prescription_id" id="prescription_id" class="form-control">
                            <option value="">Без рецепта (обычные очки / оправа)</option>
                            @foreach ($prescriptions as $p)
                                <option value="{{ $p->id }}"
                                    @selected(old('prescription_id') == $p->id)>
                                    {{ $p->title }}@if($p->pd) (PD: {{ $p->pd }} мм)@endif
                                    — от {{ $p->created_at?->format('d.m.Y') }}
                                </option>
                            @endforeach
                        </select>
                        @error('prescription_id') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                @endif

                <div class="form-group">
                    <label for="address">Адрес доставки *</label>
                    <textarea id="address" name="address" rows="3" required
                              placeholder="Город, улица, дом, квартира">{{ old('address') }}</textarea>
                    @error('address') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="comment">Комментарий к заказу</label>
                    <textarea id="comment" name="comment" rows="2">{{ old('comment') }}</textarea>
                    @error('comment') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="checkout-summary">
                <h2>2. Ваш заказ</h2>

                <ul class="checkout-items">
                    @foreach ($items as $item)
                        <li class="checkout-item">
                            <span>{{ $item['product']->name }} ({{ $item['qty'] }} шт.)</span>
                            <strong>{{ number_format($item['sum'], 0, '', ' ') }} ₽</strong>
                        </li>
                    @endforeach
                </ul>

                <div class="checkout-total">
                    <span>Итого к оплате:</span>
                    <strong class="total-price">{{ number_format($grandTotal, 0, '', ' ') }} ₽</strong>
                </div>

                <button type="submit" class="btn btn--primary btn--block">
                    Подтвердить заказ
                </button>
            </div>

        </div>
    </form>
</main>
@endsection