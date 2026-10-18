<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'old_price', 'short_description', 'full_description', 'image', 'brand_id', 'category_id', 'is_active'];

    protected $casts = [
        'price'     => 'integer',
        'old_price' => 'integer',
        'is_active' => 'boolean',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
