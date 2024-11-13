<?php

namespace App\Models;

use App\Models\Classe;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'name',
        'title',
        'description',
        'edition',
        'edited_at',
        'edited_home',
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
        'seen_by',
        'quantity_bought'
    ];


    protected $casts = [
        'images' => 'array',
        'likes' => 'array',
        'seen_by' => 'array',

    ];


    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

}
