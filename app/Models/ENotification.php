<?php

namespace App\Models;

use App\Helpers\Dater\DateFormattor;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ENotification extends Model
{
    use DateFormattor;

    protected $fillable = [
        'content', 
        'images', 
        'user_id', 
        'seen_by', 
        'receivers', 
        'hide_for', 
        'hide', 
        'title', 
        'object'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    } 

    protected $casts = [
        'images' => 'array',
        'receivers' => 'array',
        'hide_for' => 'array',
        'seen_by' => 'array',
    ];

    public function getReceivers()
    {
        
        $receivers = $this->receivers;
        
    }
}
