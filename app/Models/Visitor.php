<?php

namespace App\Models;

use App\Observers\ObserveVisitor;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ObserveVisitor::class)]
class Visitor extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'country',
        'city',
        'device_type',
        'visited_at',
    ];
}
