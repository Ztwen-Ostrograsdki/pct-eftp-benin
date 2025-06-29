<?php

namespace App\Models;

use App\Models\Classe;
use App\Models\Epreuve;
use App\Models\User;
use App\Observers\ObserveEpreuveResponse;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

#[ObservedBy(ObserveEpreuveResponse::class)]
class EpreuveResponse extends Model
{
    protected $fillable = [
        'name', 
        'epreuve_id', 
        'images', 
        'path', 
        'uuid', 
        'user_id', 
        'authorized', 
        'hidden', 
        'visibity', 
        'likes',
        'downloaded',
        'downloaded_by',
        'seen_by'
    ];

    protected $casts = [
        'images' => 'array',
        'seen_by' => 'array',
        'likes' => 'array',
        'downloaded_by' => 'array',

    ];

    protected static function booted()
    {
        static::creating(function ($epreuve){

            $epreuve->uuid = Str::uuid();

        });
    }

    public function baseName($with_extension = false)
    {
        $path = storage_path().'/app/public/' . $this->path;

        if(File::exists($path)){

            return $with_extension ? basename($path) : pathinfo($path)['filename'];
        }

        return "Fichier inconnu";
    }

    public function epreuve()
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