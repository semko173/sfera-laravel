@extends('profile.layout')

@section('profile-content')
<div class="profile-section active">
    <h2 class="profile-section__title">Мои заказы</h2>

    @if ($orders->isEmpty())
        <div class="profile-empty">
            <p class="profile-empty__text">У вас пока нет оформленных заказов.</p>
            <a href="{{ route('product.index') }}" class="profile-empty__button">Перейти в каталог</a>
        </div>
    @else
        @foreach ($orders as $order)
            <div class="order-card" style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <strong>Заказ #{{ $order->id }}</strong>
                    <span>Дата: {{ $order->created_at?->format('d.m.Y H:i') }}</span>
                </div>

                <div>Сумма: {{ number_format((float) $order->total_price, 0, '', ' ') }} ₽</div>
                <div>Статус: {{ $order->status }}</div>

                @if ($order->items->isNotEmpty())
                    <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #f0f0f0;">
                        <strong>Состав:</strong>
                        <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                            @foreach ($order->items as $item)
                                <li>
                                    {{ $item->product?->name ?? 'Товар удалён' }}
                                    × {{ $item->quantity }}
                                    — {{ number_format((float) $item->price, 0, '', ' ') }} ₽
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endforeach

        {{ $orders->links() }}
    @endif
</div>
@endsection