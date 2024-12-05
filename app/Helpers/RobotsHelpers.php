<?php

use App\Models\Classe;
use App\Models\Filiar;

if(!function_exists('numberZeroFormattor')){

    function numberZeroFormattor($number, $string = false)
    {
        if($string && $number == 0) return "Aucune donnée"; 
        
        return $number >= 10 ? $number : '0' . $number;
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