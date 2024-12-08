<?php

use App\Models\Classe;
use App\Models\Filiar;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

if(!function_exists('numberZeroFormattor')){

    function numberZeroFormattor($number, $string = false)
    {
        if(is_array($number)) $number = count($number);
        
        if($string && $number == 0) return "Aucune donnée"; 
        
        return $number >= 10 ? $number : '0' . $number;
    }

}

if(!function_exists('getPromotions')){

    function getPromotions($associate = false, $column = null)
    {
        $data = [];

        $promotions = Promotion::all();
        
        if($associate){

            foreach($promotions as $promo){

                if($column){

                    $column = str_replace('by ', '', $column);

                    $data[$promo->id] = $promo->{$column};
                }
                else{

                    $data[$promo->id] = $promo;
                }
            }

        }
        else{

            return $data = $promotions;
        }

        return $data;
    }

}

if(!function_exists('getFiliars')){

    function getFiliars($associate = false, $column = null)
    {
        $data = [];

        $filiars = Filiar::all();
        
        if($associate){

            foreach($filiars as $filiar){

                if($column){

                    $column = str_replace('by ', '', $column);

                    $data[$filiar->id] = $filiar->{$column};
                }
                else{

                    $data[$filiar->id] = $filiar;
                }
            }

        }
        else{

            return $data = $filiars;
        }

        return $data;
    }

}

if(!function_exists('getClasses')){

    function getClasses($associate = false, $column = null)
    {
        $data = [];

        $classes = Classe::all();
        
        if($associate){

            foreach($classes as $classe){

                if($column){

                    $column = str_replace('by ', '', $column);

                    $data[$classe->id] = $classe->{$column};
                }
                else{

                    $data[$classe->id] = $classe;
                }
            }

        }
        else{

            return $data = $classes;
        }

        return $data;
    }

}


if(!function_exists('findPromotions')){

    function findPromotions($column = 'id', ...$params)
    {
        $data = [];

        if(count($params) >= 1){

            foreach($params as $param){

                $p = Promotion::where($column, $param)->first();

                $data[] = $p;

            }
        }

        return $data;
        
    }

}

if(!function_exists('findClasses')){

    function findClasses($column = 'id', ...$params)
    {
        $data = [];

        if(count($params) >= 1){

            foreach($params as $param){

                $c = Classe::where($column, $param)->first();

                $data[] = $c;

            }
        }

        return $data;
        
    }

}

if(!function_exists('findFiliars')){

    function findFiliars($column = 'id', ...$params)
    {
        $data = [];

        if(count($params) >= 1){

            foreach($params as $param){

                $f = Filiar::where($column, $param)->first();

                $data[] = $f;

            }
        }

        return $data;
        
    }
}




if(!function_exists('auth_user')){

    function auth_user()
    {
        return Auth::user();
    }

}

if(!function_exists('getClasse')){

    function getClasse($value, $column = "id")
    {
        return Classe::where($column, $value)->first();
    }

}

if(!function_exists('getPromotion')){

    function getPromotion($value, $column = "id")
    {
        return Promotion::where($column, $value)->first();
    }

}


if(!function_exists('getFiliar')){

    function getFiliar($value, $column = "id")
    {
        return Filiar::where($column, $value)->first();
    }

}

if(!function_exists('getUser')){

    function getUser($value, $column = "id")
    {
        return User::where($column, $value)->first();
    }

}



