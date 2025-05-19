<?php

namespace App\Models;

use App\Models\Member;
use App\Models\User;
use App\Observers\ObserveCotisation;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ObserveCotisation::class)]
class Cotisation extends Model
{
    protected $fillable = [
        'member_id',
        'user_id',
        'payment_date',
        'month',
        'year',
        'amount',
        'description',
        'status',
        'validated'

    ];

    protected $casts = [
        'payment_date' => 'date'
    ];


    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->user;
    }

    public function getCotisationMonthYear()
    {
        return $this->month . ' ' . $this->year;
    }


}
