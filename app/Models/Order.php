<?php

namespace App\Models;

use App\Helpers\Dater\DateFormattor;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'discount',
        'tax',
        'completed',
        'shipping_price',
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

    public function getTotalAmountWithTaxAndShipping($with_discount = false)
    {
        $total = ($this->grand_total + $this->shipping_price);
        
        if($with_discount)

            return ($total - ($this->discount * $total) / 100) + $this->tax;
        else 

            return $total + $this->tax;
    }

    public function getIsCompletedStatusMessage()
    {
        if($this->completed && $this->status == 'shipped')

            return "Traité et livré";

        elseif($this->completed)

            return "Traité";

        elseif($this->status !== 'canceled')

            return "Traitement en cours";
        else

            return "En cours de traitement";
    }
}
