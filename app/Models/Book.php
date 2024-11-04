<?php

namespace App\Models;

use App\Models\Classe;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'name',
        'description',
        'images',
        'last_edited_year',
        'user_id',
        'classe_id',
        'filiars_id',
        'price',
        'is_active',
        'authorized',
        'hidden',
        'visibity',
        'in_stock',
        'likes',
        'on_sale',
    ];


    protected $casts = [
        'images' => 'array',
        'likes' => 'array',

    ];


    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

}
