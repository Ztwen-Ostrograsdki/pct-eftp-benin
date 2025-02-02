<?php

namespace App\Models;

use App\Helpers\Dater\DateFormattor;
use App\Models\User;
use App\Observers\ObserveForumChatSubject;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ObserveForumChatSubject::class)]
class ForumChatSubject extends Model
{
    use DateFormattor;
    
    protected $fillable = [
        'user_id',
        'subject',
        'active',
        'closed',
        'likes',
        'closed_at',
        'authorized'
    ];

    protected $casts = [
        'likes' => 'array',

    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
