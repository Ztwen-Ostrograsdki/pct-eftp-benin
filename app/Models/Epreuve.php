<?php

namespace App\Models;

use App\Helpers\Dater\DateFormattor;
use App\Models\Classe;
use App\Models\EpreuveResponse;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Epreuve extends Model
{
    use DateFormattor;

    protected $fillable = [
        'name', 
        'description', 
        'filiars_id', 
        'file_size',
        'classe_id', 
        'promotion_id', 
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

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function extension()
    {
        return mb_substr($this->path, -3);
    }

    public function getFiliars()
    {
        if($this->filiars_id){

            return Filiar::whereIn('id', $this->filiars_id)->get();
        }
        return [];

    }
    public function getPromotion($name = true)
    {
        if($this->promotion_id){

            return $this->promotion->name;
        }

        return 'non renseignée';

    }

    public function getEpreuveSize()
    {
        $file_epreuve = url('storage', $this->path);

        //return $file_epreuve->getSize() >= 1048580 ? number_format($file_epreuve->getSize() / 1048576, 2) . ' Mo' :  number_format($file_epreuve->getSize() / 1000, 2) . ' Ko';
    }

    public function downloadManager()
    {
        $occurence = (int)$this->downloaded + 1;

        $downloaders = (array)$this->downloaded_by;

        if(!in_array(auth_user()->id, $downloaders)){

            $downloaders[] = auth_user()->id;

        }

        $file_size = $this->file_size;

        if(!$file_size){
            
            $size = Storage::disk('public')->size($this->path);

            if($size >= 1048580){

                $file_size = number_format($size / 1048576, 2) . ' Mo';

            }
            else{

                $file_size = number_format($size / 1000, 2) . ' Ko';

            }
        }

        $this->update(['downloaded' => $occurence, 'downloaded_by' => $downloaders, 'file_size' => $file_size]);
    }
}
