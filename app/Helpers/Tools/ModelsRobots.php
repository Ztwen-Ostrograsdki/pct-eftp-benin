<?php
namespace App\Helpers\Tools;

use App\Models\Epreuve;
use App\Models\ForumChatSubject;
use App\Models\SupportFile;
use App\Models\User;
use App\Notifications\NotifyAdminThatBlockedUserTriedToLoginToUnblockThisUserAccount;
use App\Notifications\NotifyAdminThatNewUserSubscribedToConfirmThisUserAccount;
use App\Notifications\RealTimeNotificationGetToUser;
use App\Notifications\SendDynamicMailToUser;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;

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

    public static function getUserAdmins($pluckingColumn = 'id', $except = null)
    {
        $roles = ['master', 'admin-1', 'admin-2', 'admin-3', 'admin-4', 'admin-5'];

        if(!$pluckingColumn)

            return User::whereHas('roles', function($query) use ($roles) {

                $query->whereIn('admins.name', $roles);

            })
            ->orWhere(function($query){

                $query->where('users.id', 1);
            })
            ->distinct()
            ->pluck('id')
            ->toArray();
        else

        return User::whereHas('roles', function($query) use ($roles) {

            $query->whereIn('admins.name', $roles);

        })
        ->orWhere(function($query){

            $query->where('users.id', 1);
        })
        ->distinct()->get();
    }

    public static function getAllAdmins()
    {
        $roles = ['master', 'admin-1', 'admin-2', 'admin-3', 'admin-4', 'admin-5'];

        return User::whereHas('roles', function($query) use ($roles) {

            $query->whereIn('admins.name', $roles);
        })
        ->orWhere(function($query){

            $query->where('users.id', 1);
        })
        ->distinct()->get();

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

    public static function notificationToAdminsThatNewForumChatSubjectPublished(User $user, ForumChatSubject $forumChatSubject)
    {
        if($user && $user->confirmed_by_admin){

            $admins = self::getAllAdmins();

            $since = $forumChatSubject->__getDateAsString($forumChatSubject->created_at, 3, true);

            $subjet = "Validation d'un sujet de discussion publié sur la plateforme " . config('app.name') . " par l'utilisateur du compte : " . $user->email .
            " et d'identifiant personnel : ID = " . $user->identifiant;

            $body = "Vous recevez ce mail parce que vous êtes administrateur et qu'avec ce statut, vous pouvez analyser et confirmer le sujet de discussion publié par "
            . $user->getUserNamePrefix() . " " . $user->getFullName(true) . 
                
                ". Le sujet de discussion a été publié le " . $since . " .";

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
        return "AESP-" . date('Y') . generateRandomNumber(6);
    }



    public static function notificationToConfirmUnconfirmedUser(User $user)
    {
        if($user && !$user->confirmed_by_admin){

            $admins = self::getAllAdmins();

            $since = __formatDateTime($user->email_verified_at);

            foreach($admins as $admin){

                $admin->notify(new NotifyAdminThatNewUserSubscribedToConfirmThisUserAccount($user));

            }

            $message = "L'utilisateur " . $user->getFullName(true) . " vient de confirmer son compte ce: " . $since . " !";

            Notification::sendNow($admins, new RealTimeNotificationGetToUser($message));

        }
    }
    
    public static function notificationThatBlockedUserTriedToLogin(User $user, $title, $object, $content)
    {
        if($user && !$user->blocked){

            $since = __formatDateTime($user->blocked_at);

            $admins = self::getAllAdmins();

            foreach($admins as $admin){

                $admin->notify(new NotifyAdminThatBlockedUserTriedToLoginToUnblockThisUserAccount($user, $title, $object, $content));

            }

            $message = "L'utilisateur " . $user->getFullName(true) . " dont le compte a été bloqué le " . $since . " a essayé de se connecter à son compte!";

            Notification::sendNow($admins, new RealTimeNotificationGetToUser($message));

        }
    }
}