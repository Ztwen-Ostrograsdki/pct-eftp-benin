<?php

namespace App\Models;

use App\Models\Book;
use App\Models\Epreuve;
use App\Models\EpreuveResponse;
use App\Models\Filiar;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $fillable = ['name', 'description', 'filiar_id', 'slug', 'promotion_id'];

    public function filiar()
    {
        return $this->belongsTo(Filiar::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

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
