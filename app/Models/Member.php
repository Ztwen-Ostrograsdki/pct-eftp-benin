<?php

namespace App\Models;

use App\Models\MemberCard;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'user_id',
        'role_id',
        'description',
        'ability',
        'authorized',
        'tasks',

    ];

    protected $casts = [
        'tasks' => 'array',

    ]; 

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function card()
    {
        return $this->hasOne(MemberCard::class);
    }
}
