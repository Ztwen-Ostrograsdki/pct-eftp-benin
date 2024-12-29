<?php

namespace App\Models;

use App\Helpers\Dater\DateFormattor;
use App\Models\OrderItem;
use App\Models\User;
use App\Observers\ObserveOrder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(ObserveOrder::class)]
class Order extends Model
{
    use DateFormattor, SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'grand_total',
        'payment_method',
        'payment_status',
        'status',
        'approved', // when the order has been authorized by admin
        'currency',
        'shipping_amount',
        'shipping_method',
        'shipping_date',
        'notes',
        'discount',
        'tax',
        'completed', // when the order has been payed and delivered or shipped
        'shipping_price',
        'FEDAPAY_TRANSACTION_ID', // the Id of the related fedapay Transaction instance
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

        if($this->completed || $this->status == 'delivered' || $this->status == 'shipped')

            return "Traitée, payée et livrée";

        elseif($this->status == 'approved')

            return "Traitée et payée";

        else
            return "En attente";
    }
}
