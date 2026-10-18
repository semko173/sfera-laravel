<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'title',
        'od_sph',
        'od_cyl',
        'od_axis',
        'os_sph',
        'os_cyl',
        'os_axis',
        'pd',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
