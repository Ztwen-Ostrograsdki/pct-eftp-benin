<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lycee extends Model
{
    protected $fillable = [
        'name',
        'provisor',
        'censeur',
        'rank',
        'is_public',
        'department',
        'city',
        'description',
        'images',
        'promotions_id',
        'filiars_id',

    ];

    protected $casts = [
        'images' => 'array',
        'filiars_id' => 'array',
        'promotions_id' => 'array',
    ];


    public function filiars()
    {
        $filiars_id = (array)$this->filiars_id;

        $filiars = Filiar::whereIn('filiars.id', $filiars_id)->get();

        return $filiars;
    }

    public function getFiliars()
    {
        $filiars_id = (array)$this->filiars_id;

        $filiars = Filiar::whereIn('filiars.id', $filiars_id)->get();

        return $filiars;
    }

    public function promotions()
    {
        $promotions_id = (array)$this->promotions_id;

        $promotions = Promotion::whereIn('promotions.id', $promotions_id)->get();

        return $promotions;
    }

    public function getPromotions()
    {
        $promotions_id = (array)$this->promotions_id;

        $promotions = Promotion::whereIn('promotions.id', $promotions_id)->get();

        return $promotions;
    }

    public function hasImages(): bool
    {
        return (array)$this->images !== null;
    }

    public function getImages()
    {
        
    }

}
