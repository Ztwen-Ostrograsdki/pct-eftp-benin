<?php

namespace App\Models;

use App\Helpers\Dater\DateFormattor;
use App\Models\Filiar;
use App\Models\Promotion;
use App\Models\User;
use App\Observers\ObserveSupportFile;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

#[ObservedBy(ObserveSupportFile::class)]
class SupportFile extends Model
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
        'uuid', 
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
        'extension',
        'likes',
        'pages',
    ];

    protected $casts = [
        'images' => 'array',
        'filiars_id' => 'array',
        'downloaded_by' => 'array',
        'likes' => 'array',

    ];

    protected static function booted()
    {
        static::creating(function ($support){

            $support->uuid = Str::uuid();

        });

        static::deleting(function($db_file){

            $path =  storage_path('app/') . $db_file->path;

            if (Storage::disk('local')->exists($path)) {

                Storage::disk('local')->delete($path);
            }
        });
    }

    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
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

    public function readerRoute()
    {
        return URL::temporarySignedRoute('file.reader.viewer',now()->addMinutes(1.5), ['uuid' => $this->uuid, 'type' => 'f']);
    }

    public function baseName($with_extension = false)
    {
        $path = $this->path;

        if(Storage::disk('local')->exists($path)){

            return $with_extension ? basename($path) : pathinfo($path)['filename'];
        }

        return "Fichier inconnu";
    }

    public function getFileSize()
    {
        $file_size = $this->file_size;

        if(!$file_size){

            $path =  $this->path;
            
            $size = Storage::disk('local')->size($path);

            if($size >= 1048580){

                $file_size = number_format($size / 1048576, 2) . ' Mo';

            }
            else{

                $file_size = number_format($size / 1000, 2) . ' Ko';

            }
        }

        return $file_size;
    }

    public function downloadManager()
    {
        $occurence = (int)$this->downloaded + 1;

        $downloaders = (array)$this->downloaded_by;

        if(!in_array(auth_user()->id, $downloaders)){

            $downloaders[] = auth_user()->id;

        }

        $this->update(['downloaded' => $occurence, 'downloaded_by' => $downloaders]);
    }

    public function getTotalPages()
    {
        $path = storage_path('app/' . $this->path);

        $gets = file_get_contents($path);

        $pages = preg_match_all("/\/Page\W/", $gets, $returned);

        return $pages;
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
}
