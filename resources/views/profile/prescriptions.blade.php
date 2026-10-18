@extends('profile.layout')

@section('profile-content')
<div class="profile-section active">

    <div class="profile-section__header">
        <h2 class="profile-section__title">Рецепты на очки и линзы</h2>
        <button type="button" class="btn-outline-sm" id="add-prescription-btn">
            + Добавить рецепт
        </button>
    </div>

    <div class="profile-section__body">

        <div id="prescriptions-list">
            @if ($prescriptions->isEmpty())
                <div class="profile-empty" id="prescriptions-empty">
                    <p class="profile-empty__text">У вас пока нет сохранённых рецептов.</p>
                    <button type="button" class="profile-empty__button" id="add-prescription-empty-btn">
                        Добавить рецепт
                    </button>
                </div>
            @else
                @foreach ($prescriptions as $p)
                    <div class="prescription-block">
                        <div class="prescription-meta">
                            <span class="prescription-title">{{ $p->title }}</span>
                            <span class="prescription-date">
                                Дата: {{ $p->created_at?->format('d.m.Y') }}
                            </span>
                        </div>

                        <div class="prescription-table-wrapper">
                            <table class="prescription-table">
                                <thead>
                                    <tr>
                                        <th>Глаз</th>
                                        <th>SPH (Сфера)</th>
                                        <th>CYL (Цилиндр)</th>
                                        <th>AXIS (Ось)</th>
                                        <th>PD (Межзрачковое)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>OD</strong> (Правый)</td>
                                        <td>{{ $p->od_sph ?: '-' }}</td>
                                        <td>{{ $p->od_cyl ?: '-' }}</td>
                                        <td>{{ $p->od_axis ? $p->od_axis . '°' : '-' }}</td>
                                        <td rowspan="2" class="pd-cell">
                                            {{ $p->pd ? $p->pd . ' мм' : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>OS</strong> (Левый)</td>
                                        <td>{{ $p->os_sph ?: '-' }}</td>
                                        <td>{{ $p->os_cyl ?: '-' }}</td>
                                        <td>{{ $p->os_axis ? $p->os_axis . '°' : '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="prescription-actions">
                            <form action="{{ route('profile.prescriptions.destroy', $p) }}"
                                  method="POST" class="prescription-delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger-sm">Удалить</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Форма добавления рецепта --}}
        <div class="prescription-form-wrapper" id="prescription-form" style="display: none;">
            <form action="{{ route('profile.prescriptions.store') }}" method="POST" class="prescription-form">
                @csrf

                <div class="form-group">
                    <label for="prescription-title" class="form-label">Название рецепта</label>
                    <input type="text" id="prescription-title" name="title"
                           class="form-input" placeholder="Например, Очки на каждый день" required>
                </div>

                <div class="prescription-form__group">
                    <h3>Правый глаз (OD)</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">SPH</label>
                            <input type="text" name="od_sph" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">CYL</label>
                            <input type="text" name="od_cyl" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">AXIS</label>
                            <input type="text" name="od_axis" class="form-input">
                        </div>
                    </div>
                </div>

                <div class="prescription-form__group">
                    <h3>Левый глаз (OS)</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">SPH</label>
                            <input type="text" name="os_sph" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">CYL</label>
                            <input type="text" name="os_cyl" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">AXIS</label>
                            <input type="text" name="os_axis" class="form-input">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Межзрачковое расстояние (PD), мм</label>
                    <input type="text" name="pd" class="form-input">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Сохранить рецепт</button>
                    <button type="button" class="btn-outline-sm" id="cancel-prescription-btn">Отмена</button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection