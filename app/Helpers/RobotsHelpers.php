<?php

use App\Helpers\Tools\SpatieManager;
use App\Models\Classe;
use App\Models\Cotisation;
use App\Models\Epreuve;
use App\Models\Filiar;
use App\Models\ForumChat;
use App\Models\Member;
use App\Models\Promotion;
use App\Models\SupportFile;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Instanceof_;

if(!function_exists('getMonths')){

    function getMonths($index = null)
    {
        $months = [
            1 => 'Janvier',
            2 => 'Février',
            3 => 'Mars',
            4 => 'Avril',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juillet',
            8 => 'Août',
            9 => 'Septembre',
            10 => 'Octobre',
            11 => 'Novembre',
            12 => 'Décembre',
        ];

        return $index ? $months[$index] : $months;
    }

}

if(!function_exists('generateRandomNumber')){

    function generateRandomNumber($length = 10)
    {
        $min = (int)str_pad("1", $length, "0");

        $max = (int)str_pad("", $length, "9");

        return random_int($min, $max);
    }

}
if(!function_exists('getCurrentMonth')){

    function getCurrentMonth()
    {
        $index = date('n');

        return getMonths($index);
    }

}

if(!function_exists('__isConnectedToInternet')){

    function __isConnectedToInternet()
    {
        try {

           return @fsockopen("www.google.com", 80) !== false;

        } catch (\Exception $e) {

            return false;
        }
    }

}

if(!function_exists('__translateRoleName')){

    function __translateRoleName($role_name)
    {
        return SpatieManager::translateRoleName($role_name);
    }

}

if(!function_exists('__translatePermissionName')){

    function __translatePermissionName($permission_name)
    {
        return SpatieManager::translatePermissionName($permission_name);
    }

}

if(!function_exists('getAppFullName')){

    function getAppFullName()
    {
        return env('APP_FULL_NAME');
    }

}

if(!function_exists('__greatingMessager')){

    function __greatingMessager($name)
    {
        $hour = date('G');
        
        if($hour >= 0 && $hour <= 12){

            $greating = "Bonjour ";
        }
        else{

            $greating = "Bonsoir ";
        }

        return $name  ? $greating . ' ' . $name : $greating;
    }

}
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

if(!function_exists('substringer')){

    function substringer($string, $length = 8)
    {

        if(strlen($string) <= $length) return $string;

        else

            return Str::substr($string, 0, $length) . " ...";
    }

}

if(!function_exists('string_cutter')){

    function string_cutter($string, $length = 8)
    {

        if(strlen($string) <= $length) return $string;

        else

            return Str::substr($string, 0, $length) . " ...";
    }

}

if(!function_exists('cutter')){

    function cutter($string, $length = 8)
    {

        if(strlen($string) <= $length) return $string;

        else

            return Str::substr($string, 0, $length) . " ...";
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

            $data = $members;
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

if(!function_exists('getYears')){

    function getYears($big_to_small = true, $start = null, $end = null)
    {
        $data = [];

        $first = 1990;

        $last = date('Y');

        if($start) $first = $start;

        if($end && $end > $start) $last = $end;

        for ($i = $first; $i <= $last; $i++) { 
            
            $data[$i] = $i;
        } 

        return $big_to_small ? array_reverse($data) : $data;
    }

}

if(!function_exists('getYearEpreuves')){

    function getYearEpreuves($year, $is_exam = false)
    {
        return Epreuve::where('authorized', true)->where('school_year', $year)->where('is_exam', $is_exam)->get();
    }

}

if(!function_exists('getEpreuves')){

    function getEpreuves($year = null, $is_exam = false)
    {
        if($year){

            if($is_exam !== 'twice'){

                return Epreuve::where('authorized', true)->where('school_year', $year)->where('is_exam', $is_exam)->get();
            }
            else{

                return Epreuve::where('authorized', true)->where('school_year', $year)->get();
            }
        }
        else{

            if($is_exam !== 'twice'){

                return Epreuve::where('authorized', true)->where('is_exam', $is_exam)->get();
            }
            else{

                return Epreuve::where('authorized', true)->get();
            }
        }
    }

}

if(!function_exists('getSupportFiles')){

    function getSupportFiles()
    {
        return SupportFile::where('authorized', true)->get();
    }

}

if(!function_exists('getMessageById')){

    function getMessageById($message_id)
    {
        return ForumChat::find($message_id);
    }

}

if(!function_exists('getLyceeEpreuves')){

    function getLyceeEpreuves($lycee_id, $is_exam = false)
    {
        return Epreuve::where('authorized', true)->where('lycee_id', $lycee_id)->where('is_exam', $is_exam)->get();
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

if(!function_exists('getRand')){

    function getRand($min = 2, $max = 234)
    {
        return rand($min, $max);
    }

}

if(!function_exists('getRandom')){

    function getRandom($min = 2, $max = 234)
    {
        return rand($min, $max);
    }

}

if(!function_exists('randomNumber')){

    function randomNumber($min = 2, $max = 234)
    {
        return rand($min, $max);
    }

}

if(!function_exists('randNumber')){

    function randNumber($min = 2, $max = 234)
    {
        return rand($min, $max);
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

if(!function_exists('getMemberCotisationOfMonthYear')){

    function getMemberCotisationOfMonthYear($member_id, $month, $year)
    {
        return Cotisation::where('member_id', $member_id)->where('month', $month)->where('year', $year)->first();
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

if(!function_exists('findUser')){

    function findUser($id)
    {
        return User::find($id);
    }

}

if(!function_exists('getUsers')){

    function getUsers()
    {
        return User::all();
    }

}

if(!function_exists('getMember')){

    function getMember($value, $column = "id")
    {
        return Member::where($column, $value)->first();
    }

}

if(!function_exists('getActivesMembers')){

    function getActivesMembers()
    {
        $members = [];

        $all = Member::all();

        foreach($all as $member){

            if($member->role){

                $members[] = $member;

            }

        }

        return $members;
    }

}

if(!function_exists('findMember')){

    function findMember($id)
    {
        return Member::find($id);
    }

}

if(!function_exists('__selfUser')){

    function __selfUser($user)
    {
        return $user->id === auth_user()->id;
    }

}
if(!function_exists('__formatDate')){

    function __formatDate($date)
    {
        Carbon::setLocale('fr');

        $formatted = ucfirst(Carbon::parse($date)->translatedFormat('d F Y'));
        
        return $formatted;
    }

}

if(!function_exists('__formatDateTime')){

    function __formatDateTime($datetime)
    {
        Carbon::setLocale('fr');

        if(!$datetime) $datetime = Carbon::now();

        $formatted = ucwords(Carbon::parse($datetime)->translatedFormat('l j F Y \à H\h i\m s\s'));

        return $formatted;
    }

}

if(!function_exists('__moneyFormat')){

    function __moneyFormat($amount)
    {
        return number_format($amount, 0, ',', ' ');
    }

}

if(!function_exists('deleteFileIfExists')){

    function deleteFileIfExists($path)
    {
        if(File::exists($path)){

            File::delete($path);
        }
    }

}

if(!function_exists('getExamPromotions')){

    function getExamPromotions($exam_type, $only_ids = false)
    {
        if($exam_type == 'cap'){

            if($only_ids){

                $promotion = Promotion::where('name', 'like', '%trois%')
                                   ->orWhere('name', 'like', '%premi%')->first();

                if($promotion) return $promotion->id;
            }
            else{

                return Promotion::where('name', 'like', '%trois%')
                                   ->orWhere('name', 'like', '%premi%')
                                   ->first();
            }

        }
        else{

            if($only_ids){

                $promotion = Promotion::where('name', 'like', '%termi%')->first();

                if($promotion) return $promotion->id;

            }
            else{

                return Promotion::where('name', 'like', '%termi%')->first();
            }

        }

        return null;

    }

}



