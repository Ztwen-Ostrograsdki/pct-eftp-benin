<?php

namespace App\Models;

use App\Models\Book;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'book_id',
        'quantity',
        'unit_amount',
        'total_amount',

    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}