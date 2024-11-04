<?php

namespace App\Models;

use App\Models\Classe;
use App\Models\Epreuve;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class EpreuveResponse extends Model
{
    protected $fillable = [
        'name', 
        'description', 
        'classe_id', 
        'epreuve_id', 
        'images', 
        'path', 
        'user_id', 
        'authorized', 
        'hidden', 
        'visibity', 
        'school_year', 
        'notes'
    ];

    protected $casts = [
        'images' => 'array',

    ];

    public function answer()
    {
        return $this->belongsTo(Epreuve::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function filiars()
    {
        
    }
}