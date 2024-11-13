<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $fillable = [
        'title',
        'description',
        'will_closed_at',
        'images',
        'targets',
        'read_by',
        'user_id',
        'objet',
        'content'
    ];


    protected $casts = [
        'images' => 'array',
        'targets' => 'array',
        'read_by' => 'array',
    ];
}
