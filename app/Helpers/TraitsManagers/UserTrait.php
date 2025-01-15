<?php
namespace App\Helpers\TraitsManagers;

use App\Models\ENotification;
use App\Models\User;
use App\Notifications\NotifyUserThatAccountHasBeenConfirmedByAdmins;
use App\Notifications\SendDynamicMailToUser;
use App\Notifications\SendEmailVerificationKeyToUser;
use App\Notifications\SendPasswordResetKeyToUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



trait UserTrait{

    public function emailVerified()
    {
        return !is_null($this->email_verified_at);
    }

    public function emailNotVerified()
    {
        return is_null($this->email_verified_at);
    }

    public function markAsVerified()
    {
        if($this->emailNotVerified()){
    
            $this->forceFill([
                'email_verify_key' => null,
                'email_verified_at' => now(),
            ])->setRememberToken(Str::random(60));
 
            $this->save();

        }

        return $this->emailVerified();
    }

    public function markAsNotVerified()
    {
        $email_verify_key = Str::random(6);

        if(!$this->emailNotVerified()){
    
            $this->forceFill([
                'email_verify_key' => $email_verify_key,
                'email_verified_at' => null,
                'remember_token' => null,
            ]);
 
            $this->save();

        }

        return $this->emailNotVerified();
    }

    public function sendVerificationLinkOrKeyToUser()
    {
        if($this->emailVerified()){

            return $this;
        }

        $email_verify_key = Str::random(6);

        $this->notify(new SendEmailVerificationKeyToUser($email_verify_key));

        $auth = $this->forceFill([
            'email_verify_key' => Hash::make($email_verify_key)
        ])->save();

        return $this;
    }

    public function sendPasswordResetKeyToUser(string $key = null)
    {
        $password_reset_key = Str::random(6);
        
        if($key) $password_reset_key = $key;

        $this->notify(new SendPasswordResetKeyToUser($password_reset_key));

        $this->forceFill([
            'password_reset_key' => Hash::make($password_reset_key)
        ])->save();
    }

    public function markUserAsVerifiedOrNot(bool $as_verified, bool $as_not_verified)
    {
        return ($as_verified === true || $as_not_verified === false) ? $this->markAsVerified() : $this->markAsNotVerified();
    }


    public function blockUserAccount()
    {

    }

    public function isMaster()
    {
        return $this->id === 1;
    }

    public function formatString($text)
    {
        return $text ? $text : "Non renseigné";
    }

    public function formatDate($date, $substr = 3, $withTime = false)
    {
        return $date ? $this->__getDateAsString($date, $substr, $withTime) : "Non renseigné";
    }


    public function getFullName($reverse = false)
    {
        return $reverse ? $this->lastname . ' ' . $this->firstname : $this->firstname . ' ' . $this->lastname;
    }

    public function confirmedThisUserIdentification()
    {
        $identified = $this->forceFill([
            'confirmed_by_admin' => true
        ])->save();

        if($identified){

            $auth = User::find(auth_user()->id);

            $subjet = "Confirmation de l'identification utilisateur de la plateforme" . config('app.name') . " du compte " . $this->email;

            $body = "Vous recevez ce mail parce que vous êtes administrateur et qu'avec ce statut, vous avez confirmé l'identification de l'utilisateur " 
                . $this->getFullName(true) . 
                " dont l'addresse mail est "
                . $this->email . 
                " et dont l'identifiant unique utilisateur est "
                . $this->identifiant .
                "La confirmation s'est déroulée avec success et l'utilisateur pourra se connecter à son compte."
            ;

            $this->notify(new NotifyUserThatAccountHasBeenConfirmedByAdmins(true));

            $auth->notify(new SendDynamicMailToUser($subjet, $body));

        }
    }
    
    public function userBlockerOrUnblockerRobot($action = true)
    {
        if($action){
            return $this->forceFill([
                'blocked' => true,
                'blocked_at' => Carbon::now()
            ])->save();
        }
        else{
            return $this->forceFill([
                'blocked' => false,
                'blocked_at' => null
            ])->save();

        }
    }

    public function isAdminAs($statuses = null)
    {
        if($this->id == 1) return true;

        if($statuses){

            if(is_array($statuses)) return in_array($this->ability, $statuses);

            if(is_string($statuses)) return $this->ability == $statuses;

        }
        
        return $this->ability == 'admin' || $this->abitlity == 'master';
    }


    public function userHasBeenBlocked()
    {
        return $this->blocked;
    }

    public function getMyIncommingNotifications($senders = null, $search = null, $options = null)
    {
        $data = [];

        if($senders){

            $notifs = ENotification::whereIn('user_id', $senders)->orderBy('created_at', 'desc')->get();
        }
        elseif($search){

            $s = '%' . $search . '%';

            $senders = User::where('firstname', 'like', $s)
                         ->orWhere('lastname', 'like', $s)
                         ->orWhere('email', 'like', $s)
                         ->orWhere('contacts', 'like', $s)
                         ->orWhere('school', 'like', $s)
                         ->orWhere('grade', 'like', $s)
                         ->orWhere('graduate', 'like', $s)
                         ->orWhere('pseudo', 'like', $s)
                         ->orWhere('address', 'like', $s)
                         ->orWhere('job_city', 'like', $s)
                         ->orWhere('status', 'like', $s)
                         ->orWhere('birth_city', 'like', $s)
                         ->orWhere('gender', 'like', $s)
                         ->orWhere('current_function', 'like', $s)
                         ->orWhere('matricule', 'like', $s)
                         ->orWhere('ability', 'like', $s)
                         ->orWhere('graduate', 'like', $s)
                         ->orWhere('graduate_type', 'like', $s)
                         ->orWhere('graduate_deliver', 'like', $s)
                         ->orWhere('marital_status', 'like', $s)
                         ->pluck('id')->toArray();

            
            
            
            
            $notifs1 = ENotification::whereIn('user_id', $senders)->orderBy('created_at', 'desc')->get();

            $notifs2 = ENotification::where('title', 'like', $s)
                                    ->orWhere('object', 'like', $s)
                                    ->orWhere('content', 'like', $s)
                                    ->get();

            $notifs = $notifs1->concat($notifs2);

        }
        else{

            $notifs = ENotification::orderBy('created_at', 'desc')->get();
        }

        foreach($notifs as $notif){

            $receivers = $notif->receivers;

            if($options){

                $initiate_data = [];

                if($receivers == null || $receivers == []){

                    $initiate_data[] = $notif;
    
                }
                elseif(in_array($this->id, $receivers)){
    
                    $initiate_data[] = $notif;
    
                }

                foreach($initiate_data as $f){

                    if($options == 'read'){

                        $seen_by = (array)$f->seen_by;

                        if(in_array($this->id, $seen_by)) $data[] = $f;

                    }

                    elseif($options == 'unread'){

                        $seen_by = (array)$f->seen_by;

                        if(!in_array($this->id, $seen_by)) $data[] = $f;

                    }
                    elseif($options == 'hidden'){

                        $hide_for = (array)$f->hide_for;

                        if(in_array($this->id, $hide_for)) $data[] = $f;

                    }
                    
                }
            }
            else{
                if($receivers == null || $receivers == []){

                    $data[] = $notif;
    
                }
                elseif(in_array($this->id, $receivers)){
    
                    $data[] = $notif;
    
                }
            }

        }

        return $data;
    }


    






    




}