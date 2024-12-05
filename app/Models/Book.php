<?php

namespace App\Models;

use App\Helpers\Dater\DateFormattor;
use App\Models\Classe;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use DateFormattor;
    
    protected $fillable = [
        'name',
        'title',
        'description',
        'edition',
        'slug',
        'edited_at',
        'edited_home',
        'images',
        'last_edited_year',
        'user_id',
        'classes_id',
        'promotion_id',
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
        'filiars_id' => 'array',
        'classes_id' => 'array',
    ];

    public function hasClasses()
    {
        return !is_null($this->classes_id) && $this->classes_id != [];
    }

    public function hasFiliars()
    {
        return !is_null($this->filiars_id) && $this->filiars_id != [];
    }

    public function classes()
    {
        $classes = [];

        if(self::hasClasses()){

            $classes_id = (array)$this->classes_id;

            $classes = Classe::whereIn('id', $classes_id)->get();
        }

        return $classes;
    }

    public function filiars()
    {
        $filiars = [];

        if(self::hasFiliars()){

            $filiars_id = (array)$this->filiars_id;

            $filiars = Filiar::whereIn('id', $filiars_id)->get();
        }

        return $filiars;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

}
