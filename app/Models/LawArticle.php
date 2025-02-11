<?php

namespace App\Models;

use App\Helpers\Dater\DateFormattor;
use App\Models\Law;
use App\Models\LawChapter;
use App\Observers\ObserveLawArticle;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ObserveLawArticle::class)]
class LawArticle extends Model
{
    use DateFormattor;
    
    protected $fillable = [
        'name',
        'content',
        'law_id',
        'law_chapter_id',

    ];

    public function law()
    {
        return $this->belongsTo(Law::class);
    }

    public function chapter()
    {
        return $this->belongsTo(LawChapter::class);
    }
}
