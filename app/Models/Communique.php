<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Communique extends Model
{
    protected $fillable = [
        'title',
        'user_id',
        'description',
        'objet',
        'from',
        'content',
        'hidden',
        'send_by_mail',
        'pdf_path',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function getCommuniqueFormattedName()
    {
        $table = [
            0 => "0",
            1 => "00",
            2 => "000",
            3 => "0000",
            4 => "00000",

        ];


        $id = $this->id;

        $total = 4;

        $nombre_de_zero = $total - strlen($id);
        
        return  "N° " . $table[$nombre_de_zero] . '' . $this->id . " du " . __formatDate($this->created_at);

    }

}
