<?php

namespace App\Models;

use App\Helpers\Dater\DateFormattor;
use App\Models\Law;
use App\Models\LawArticle;
use App\Observers\ObserveLawChapter;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ObserveLawChapter::class)]
class LawChapter extends Model
{
    use DateFormattor;
    
    protected $fillable = [
        'chapter',
        'description',
        'law_id'

    ];

    public function law()
    {
        return $this->belongsTo(Law::class);
    }

    public function articles()
    {
        return $this->hasMany(LawArticle::class);
    }
}
