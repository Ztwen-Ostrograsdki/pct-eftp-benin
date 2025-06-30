<?php

namespace App\Models;

use App\Models\Classe;
use App\Models\Epreuve;
use App\Models\User;
use App\Observers\ObserveEpreuveResponse;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
        static::creating(function ($epreuve_response){

            $epreuve_response->uuid = Str::uuid();

        });

        static::deleting(function($db_file){

            $path = storage_path().'/app/public/' . $db_file->path;

            if(File::exists($path)){

                File::delete($path);

            }

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

    public function getExtensionIcon()
    {
        $excel = "fas fa-file-excel text-green-400";

        $world = "fas fa-file-word text-blue-400";

        $pdf = "fas fa-file-pdf text-red-500";

        $uncown = "fas fa-file";

        if($this->extension == ".pdf")

            return $pdf;

        elseif(in_array($this->extension, [".dot", '.docx', '.dotx', '.doc', '.docm', ]))

            return $world;

        elseif(in_array($this->extension, [".xltx", '.xlt', '.xlsx', '.xls']))

            return $excel;

        else

            return $uncown;

    }


    public function getTotalPages()
    {
        $path = storage_path().'/app/public/' . $this->path;

        $gets = file_get_contents($path);

        $pages = preg_match_all("/\/Page\W/", $gets, $returned);

        return $pages;
    }

    public function getFileSize()
    {
        $file_size = $this->file_size;

        $path = storage_path().'/app/public/' . $this->path;

        if(File::exists($path)){

            if(!$file_size){
                
                $size = Storage::disk('public')->size($this->path);

                if($size >= 1048580){

                    $file_size = number_format($size / 1048576, 2) . ' Mo';

                }
                else{

                    $file_size = number_format($size / 1000, 2) . ' Ko';

                }
            }

            return $file_size;
        }
        return "Inconnue";
    }
}