<?php

if(!function_exists('numberZeroFormattor')){

    function numberZeroFormattor($number, $string = false)
    {
        if($string && $number == 0) return "Aucune donnée"; 
        
        return $number >= 10 ? $number : '0' . $number;
    }

}