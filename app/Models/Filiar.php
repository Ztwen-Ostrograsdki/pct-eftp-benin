<?php

namespace App\Models;

use App\Models\Book;
use App\Models\Epreuve;
use App\Models\EpreuveResponse;
use Illuminate\Database\Eloquent\Model;

class Filiar extends Model
{
    protected $fillable = ['name', 'description', 'slug'];

    public function epreuves()
    {
        return $this->hasMany(Epreuve::class);
    }

    public function epreuveResponses()
    {
        return $this->hasMany(EpreuveResponse::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
