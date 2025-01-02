<?php

namespace App\Models;

use App\Models\Member;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'description',
        'ability', //position or rank from 1 to 100 => for president to last member
        'is_active',
        'tasks'

    ];

    protected $casts = [
        'tasks' => 'array',

    ];

    public function member()
    {
        return $this->hasOne(Member::class);
    }
}
