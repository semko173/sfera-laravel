<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    // Связь с товарами
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
