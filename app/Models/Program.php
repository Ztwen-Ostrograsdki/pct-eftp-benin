<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start',
        'end',
        'duration',
        'images',
        'place',
        'read_by',
        'objet'
    ];


    protected $casts = [
        'images' => 'array',
        'read_by' => 'array',
    ];
}
