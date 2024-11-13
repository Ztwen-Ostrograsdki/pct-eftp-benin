<?php

namespace App\Models;

use App\Models\Classe;
use App\Models\EpreuveResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Epreuve extends Model
{
    protected $fillable = [
        'name', 
        'description', 
        'filiars_id', 
        'classe_id', 
        'images', 
        'path', 
        'user_id', 
        'authorized', 
        'hidden', 
        'visibity', 
        'school_year', 
        'notes',
        'downloaded',
        'downloaded_by',
        'contents_titles',
        'seen_by',
        'likes'
    ];

    protected $casts = [
        'images' => 'array',
        'filiars_id' => 'array',
        'downloaded_by' => 'array',
        'likes' => 'array',

    ];

    public function answer()
    {
        return $this->hasOne(EpreuveResponse::class);
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
