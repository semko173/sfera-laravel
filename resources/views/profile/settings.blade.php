@extends('profile.layout')

@section('profile-content')
<div class="profile-section active">
    <div class="profile-section__header">
        <h2 class="profile-section__title">Настройки профиля</h2>
    </div>

    <div class="profile-section__body">
        <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
            @csrf
            @method('PATCH')

            <div class="form-row">
                <div class="form-group">
                    <label for="first_name" class="form-label">Имя *</label>
                    <input type="text" id="first_name" name="first_name" required
                           value="{{ old('first_name', $user->first_name) }}" class="form-input">
                    @error('first_name') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="last_name" class="form-label">Фамилия *</label>
                    <input type="text" id="last_name" name="last_name" required
                           value="{{ old('last_name', $user->last_name) }}" class="form-input">
                    @error('last_name') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" required
                       value="{{ old('email', $user->email) }}" class="form-input">
                @error('email') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">Телефон</label>
                <input type="tel" id="phone" name="phone"
                       value="{{ old('phone', $user->phone) }}"
                       placeholder="+7 (___) ___-__-__" class="form-input">
                @error('phone') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Сохранить изменения</button>
            </div>
        </form>
    </div>
</div>
@endsection