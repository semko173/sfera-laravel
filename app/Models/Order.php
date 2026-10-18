<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'address',
        'prescription_id',
        'status',
        'total_price',
        'shipping_address',
        'contact_phone',
        'comment',
    ];

    protected $casts = [
        'total_price' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
