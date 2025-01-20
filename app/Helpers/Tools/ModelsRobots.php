<?php
namespace App\Helpers\Tools;

use App\Models\Epreuve;
use App\Models\SupportFile;
use App\Models\User;
use App\Notifications\NotifyAdminThatBlockedUserTriedToLoginToUnblockThisUserAccount;
use App\Notifications\NotifyAdminThatNewUserSubscribedToConfirmThisUserAccount;
use App\Notifications\SendDynamicMailToUser;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ModelsRobots{

    public $model;

    public function __construct($model = null) {

        $this->model = $model;
    }


    public static function greatingMessage($name = null)
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

    public static function getUserAdmins($pluckindColumn = 'id', $except = null)
    {
        $admins = User::where('ability', 'admin')
                      ->orWhere('ability', 'master')
                      ->orWhere('id', 1)
                      ->pluck($pluckindColumn)
                      ->toArray();

        return count($admins) ? $admins : [1];
    }

    public static function getAllAdmins()
    {
        $admins = User::where('ability', 'admin')
                      ->orWhere('ability', 'master')
                      ->orWhere('id', 1)
                      ->get();

        return $admins;
    }

    public static function notificationToAdminsThatNewEpreuveHasBeenPublished(User $user, Epreuve $epreuve)
    {
        if($user && $user->confirmed_by_admin){

            $admins = self::getAllAdmins();

            $since = $epreuve->__getDateAsString($epreuve->created_at, 3, true);

            $subjet = "Validation d'une épreuve publiée sur la plateforme " . config('app.name') . " par l'utilisateur du compte : " . $user->email .
            " et d'identifiant personnel : ID = " . $user->identifiant;

            $body = "Vous recevez ce mail parce que vous êtes administrateur et qu'avec ce statut, vous pouvez analyser et confirmer l'épreuve publiée par "
            . $user->getUserNamePrefix() . " " . $user->getFullName(true) . 
                
                "L'épreuve a été publiée le " . $since . " ."
            ;

            foreach($admins as $admin){

                $admin->notify(new SendDynamicMailToUser($subjet, $body));

            }

        }
    }

    public static function notificationToAdminsThatSupportFileHasBeenPublished(User $user, SupportFile $support)
    {
        if($user && $user->confirmed_by_admin){

            $admins = self::getAllAdmins();

            $since = $support->__getDateAsString($support->created_at, 3, true);

            $subjet = "Validation d'une fiche de cours publiée sur la plateforme " . config('app.name') . " par l'utilisateur du compte : " . $user->email .
            " et d'identifiant personnel : ID = " . $user->identifiant;

            $body = "Vous recevez ce mail parce que vous êtes administrateur et qu'avec ce statut, vous pouvez analyser et confirmer le support publiée par "
            . $user->getUserNamePrefix() . " " . $user->getFullName(true) . 
                
                ". Le support a été publiée le " . $since . " .";

            foreach($admins as $admin){

                $admin->notify(new SendDynamicMailToUser($subjet, $body));

            }

        }
    }

    public static function deleteFileFromStorageManager($path)
    {

        // Ex: 'users/' . $file_name

        $complete_path = storage_path().'/app/public/' . $path;

        return File::delete($complete_path);
        
    }






    public static function makeUserIdentifySequence()
    {
        return Str::upper(Str::random(18));
    }




    public static function notificationToConfirmUnconfirmedUser(User $user)
    {
        if($user && !$user->confirmed_by_admin){

            $admins = self::getAllAdmins();

            foreach($admins as $admin){

                $admin->notify(new NotifyAdminThatNewUserSubscribedToConfirmThisUserAccount($user));

            }

        }
    }
    
    public static function notificationThatBlockedUserTriedToLogin(User $user, $title, $object, $content)
    {
        if($user && !$user->blocked){

            $admins = self::getAllAdmins();

            foreach($admins as $admin){

                $admin->notify(new NotifyAdminThatBlockedUserTriedToLoginToUnblockThisUserAccount($user, $title, $object, $content));

            }

        }
    }







}