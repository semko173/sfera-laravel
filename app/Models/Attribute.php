<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    // Связь со значениями характеристик в товарах
    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class, 'attribute_id');
    }
}
