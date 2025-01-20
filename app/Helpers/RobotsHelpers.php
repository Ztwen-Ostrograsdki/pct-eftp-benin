<?php

use App\Models\Classe;
use App\Models\Filiar;
use App\Models\Member;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

if(!function_exists('__arrayAllTruesValues')){

    function __arrayAllTruesValues($data)
    {
        $is_okay = true;

        foreach ($data as $d) {

            if($d == false){

                $is_okay = false;

            }
        }

        return $is_okay;
    }

}
if(!function_exists('numberZeroFormattor')){

    function numberZeroFormattor($number, $string = false)
    {
        if(is_array($number)) $number = count($number);
        
        if($string && $number == 0) return "Aucune donnée"; 
        
        return $number >= 10 ? $number : '0' . $number;
    }

}

if(!function_exists('to_flash')){

    function to_flash($name, $message)
    {
        return session()->flash($name, $message);
    }

}

if(!function_exists('flash')){

    function flash($name, $message)
    {
        return session()->flash($name, $message);
    }

}

if(!function_exists('__isAdminAs')){

    function __isAdminAs($roles = null)
    {
        if(auth_user()){
            if(Auth::user()->id == 1) return true;

            if($roles){

                if(is_array($roles)) return in_array(Auth::user()->ability, $roles);

                if(is_string($roles)) return Auth::user()->ability == $roles;

            }
            
            return Auth::user()->ability == 'admin' || Auth::user()->abitlity == 'master';
        }

        return false;
    }

}

if(!function_exists('__flash')){

    function __flash($name, $message)
    {
        return session()->flash($name, $message);
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


if(!function_exists('getMembers')){

    function getMembers($associate = false, $column = null)
    {
        $data = [];

        $members = Member::all();
        
        if($associate){

            foreach($members as $member){

                if($column){

                    $column = str_replace('by ', '', $column);

                    $data[$member->id] = $member->{$column};
                }
                else{

                    $data[$member->id] = $member;
                }
            }

        }
        else{

            return $data = $members;
        }

        return $data;
    }

}


if(!function_exists('getTeachers')){

    function getTeachers($associate = false, $column = null, $targets = null, $except = null)
    {
        $data = [];

        $teachers = User::all();
        
        if($associate){

            foreach($teachers as $teacher){

                if($column){

                    $column = str_replace('by ', '', $column);

                    $data[$teacher->id] = $teacher->{$column};
                }
                else{

                    $data[$teacher->id] = $teacher;
                }
            }

        }
        else{

            return $data = $teachers;
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
if(!function_exists('user_profil_photo')){

    function user_profil_photo($user)
    {
        if(!$user) return asset("/images/errors/nf7.png");
        
        if($user->profil_photo) 

            return url('storage', $user->profil_photo);

        else

            return asset("/images/errors/nf7.png");


    }

}

if(!function_exists('auth_user_fullName')){

    function auth_user_fullName($reverse = false, $user = null)
    {
        if($user){

            return $user->getFullName($reverse);

        }
        return User::find(Auth::user()->id)->getFullName($reverse);
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

if(!function_exists('__selfUser')){

    function __selfUser($user)
    {
        return $user->id === auth_user()->id;
    }

}



