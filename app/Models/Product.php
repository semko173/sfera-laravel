<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // 1. Указываем точное имя таблицы из базы Сферы (например, 'goods' или 'sfera_products')
    protected $table = 'products';

    // 2. Указываем имя первичного ключа (если в легаси БД это не 'id', а например 'product_id' или 'id_product')
    protected $primaryKey = 'id';

    // 3. Отключаем автоматические метки времени created_at / updated_at
    // Это КРИТИЧНО для старых таблиц, иначе Eloquent выдаст ошибку при запросах
    public $timestamps = false;
    public function productAttributes()
{
    return $this->hasMany(ProductAttribute::class);
}
}
