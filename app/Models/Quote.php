<?php

namespace App\Models;

use App\Models\User;
use App\Observers\ObserveQuote;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;


#[ObservedBy(ObserveQuote::class)]
class Quote extends Model
{
    protected $fillable = [
        'user_id',
        'hidden',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
