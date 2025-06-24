<?php

namespace App\Models;

use App\Observers\ObserveNewsLetterSubscribers;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ObserveNewsLetterSubscribers::class)]
class NewsLetterSubscribers extends Model
{
    protected $fillable = ['email', 'is_active'];
}
