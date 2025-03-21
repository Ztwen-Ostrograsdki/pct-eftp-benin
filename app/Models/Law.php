<?php

namespace App\Models;

use App\Helpers\Dater\DateFormattor;
use App\Models\LawArticle;
use App\Models\LawChapter;
use App\Observers\ObserveLaw;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;


#[ObservedBy(ObserveLaw::class)]
class Law extends Model
{
    use DateFormattor;
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'identifiant',

    ];

    public function chapters()
    {
        return $this->hasMany(LawChapter::class);
    }

    public function articles()
    {
        return $this->hasMany(LawArticle::class);
    }
}
