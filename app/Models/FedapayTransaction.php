<?php

namespace App\Models;

use App\Helpers\Dater\DateFormattor;
use Illuminate\Database\Eloquent\Model;

class FedapayTransaction extends Model
{
    use DateFormattor;
    
    protected $fillable = [
        'user_id',
        'transaction_key',
        'order_identifiant',
        'order_id',
        'receipt_email',
        'mobile_operator',
        'payment_status',
        'amount',
        'description',
        'tax',
        'transaction_id',
        'token',
        'customer_id',
        'reference',
        'callback_url',
        'operation',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getIsCompletedStatusMessage()
    {

        if($this->completed || $this->status == 'delivered')

            return "Traité et livré";

        elseif($this->completed)

            return "Traité";

        elseif($this->status !== 'canceled')

            return "Traitement en cours";
        else

            return "En cours de traitement";
    }
}

