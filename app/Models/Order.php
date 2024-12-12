<?php

namespace App\Models;

use App\Helpers\Dater\DateFormattor;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use DateFormattor;
    
    protected $fillable = [
        'user_id',
        'grand_total',
        'payment_method',
        'payment_status',
        'status',
        'currency',
        'shipping_amount',
        'shipping_method',
        'notes',
        'identifiant'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
