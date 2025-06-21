<?php

namespace App\Models;

use App\Models\Book;
use App\Models\Classe;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = ['name', 'description', 'slug'];


    public function classes()
    {
        return $this->hasMany(Classe::class);
    }

     /**
     * Pour avoir le format numerique des classes
     * @return array [description]
     */
    public function getSimpleNameFormated($name = null)
    {
        if(!$name) $name = $this->name;

        if ($name) {

            $card = [];

            $card['name'] = $name;

            $card['idc'] = "";

            if(preg_match_all('/ /', $name)){

                $card['idc'] = explode(' ', $name)[1];
            }

            if (preg_match_all('/Sixi/', $name)) { 

                $card['sup'] = "ème";

                $card['root'] = "6";
            }
            elseif (preg_match_all('/Cinqui/', $name)) {

                $card['sup'] = "ème";

                $card['root'] = "5";
            }
            elseif (preg_match_all('/Quatriem/', $name)) {
                $card['sup'] = "ème";
                $card['root'] = "4";
            }
            elseif (preg_match_all('/Troisie/', $name)) {
                $card['sup'] = "ère";
                $card['root'] = "3";
            }
            elseif (preg_match_all('/Seconde/', $name)) {
                $card['sup'] = "nde";
                $card['root'] = "2";
            }
            elseif (preg_match_all('/Premi/', $name)) {

                $card['sup'] = "ère";

                $card['root'] = "1";
            }
            elseif (preg_match_all('/Terminale/', $name)) {

                $card['sup'] = "le";

                $card['root'] = "T";
                
            }
            else{

                return ['sup' => "", 'idc' => "", 'root' => $name];
            }

            $parts = explode(' ', $name);

            if(count($parts) > 1){

                $idcs = explode('-', $parts[1]);

                if(count($idcs) > 1){

                    $idc = $idcs[0] . '-' . $idcs[1];

                    $card['idc'] = $idc;
                }
                else{

                    $idc = $parts[1];

                    $card['idc'] = $idc;
                }
            }

            return $card;

        }
        else{

            return ['sup' => "", 'idc' => "", 'root' => $name];
        }

    }
}
