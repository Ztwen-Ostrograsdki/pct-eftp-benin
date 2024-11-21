<?php
namespace App\Helpers\TraitsManagers;


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

        //$this->notify(new SendEmailVerificationKeyToUser($email_verify_key));

        $auth = $this->forceFill([
            'email_verify_key' => Hash::make($email_verify_key)
        ])->save();

        return $this;
    }

    public function sendPasswordResetKeyToUser(string $key = null)
    {
        $password_reset_key = Str::random(6);
        
        if($key) $password_reset_key = $key;

        //$this->notify(new SendPasswordResetKeyToUser($password_reset_key));

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
        return $this->forceFill([
            'confirmed_by_admin' => true
        ])->save();
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






    




}