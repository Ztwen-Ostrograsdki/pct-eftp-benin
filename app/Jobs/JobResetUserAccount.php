<?php

namespace App\Jobs;

use App\Helpers\Services\EmailTemplateBuilder;
use App\Helpers\Tools\ModelsRobots;
use App\Mail\SendResetPasswordToUserByEmail;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Throwable;

class JobResetUserAccount implements ShouldQueue
{
    use Queueable;

    public $tries = 3;

    public $timeout = 300;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $admin_generator,
        public User $user
    )
    {
        $this->admin_generator = $admin_generator;

        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $password = Str::random(6);

        $data = [
            'email' => $this->user->email, 
            'password' => $password, 
            'password_confirmation' => $password, 
        ];

        self::robotBuilder($data);
    }

    protected function robotBuilder($data)
    {
        DB::beginTransaction();

        $user = $this->user;

        try {

            $status = Password::reset(
                $data,
                function (User $user, string $password) {

                    $user->forceFill([
                        'blocked' => false,
                        'confirmed_by_admin' => true,
                        'blocked_at' => null,
                        'email_verify_key' => null,
                        'email_verified_at' => now(),
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));
    
                    $user->save();
    
                    event(new PasswordReset($user));
                }
            );
    
            if($status === Password::PASSWORD_RESET){

                $password = $data['password'];

                self::sendEmailToUser($password);

                $message_to_creator = "Le compte de {$user->getFullName()} a été réinitialisé avec succès! Le mot de passe lui a été envoyé par courriel";

                Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

            }

            DB::commit(); // Tout s’est bien passé

        } catch (Throwable $e) {

            DB::rollBack(); // Annule tout

            $message_to_creator = "La réinitialisation du compte de {$user->getFullName()} a échoué!";

            Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

            // Lancer l’exception pour marquer la Job comme échouée
            throw $e;
        }
    }

    protected function sendEmailToUser($password)
    {
        $user = $this->user;
        
        $association = env('APP_FULL_NAME');

        $lien = route('login');

        $greating = ModelsRobots::greatingMessage($user->getUserNamePrefix(true, false)) . ", ";

        $html = EmailTemplateBuilder::render('reset-account', [
            'name' => $user->getFullName(true),
            'password' => $password,
            'association' => $association,
            'email' => $user->email,
            'lien' => $lien,
            'greating' => $greating,
        ]);

        Mail::to($user->email)->send(new SendResetPasswordToUserByEmail($user, $password, $html));
    }
}
