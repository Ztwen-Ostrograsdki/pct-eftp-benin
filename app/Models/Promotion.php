<?php

namespace App\Models;

use App\Models\Book;
use App\Models\Classe;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = ['name', 'description', 'slug'];


    public function classes()
    {
        return $this->hasMany(Classe::class);
    }
}
