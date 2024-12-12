<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'order_id',
        'first_name',
        'last_name',
        'phone',
        'images',
        'street_address',
        'city',
        'state',
        'zip_code',
        

    ];

    protected $casts = [
        'images' => 'array',

    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getFullName()
    {
        return self::getFullNameAttribute();
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
