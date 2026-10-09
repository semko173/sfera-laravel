<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Отключаем автоматические таймстемпы Laravel
    public $timestamps = false;

    protected $fillable = [
        'name',
        'parent_id',
    ];

    // Связь с товарами
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
