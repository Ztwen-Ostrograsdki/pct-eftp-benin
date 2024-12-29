<?php

namespace App\Livewire\Auth;

use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Tools\ModelsRobots;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class EmailVerificationPage extends Component
{
    use Toast;

    public $email;

    public $email_verify_key;

    public $user;

    public $confirmed = false;

    public $key_expired = false;

    
    public function mount($email = null, $key = null)
    {
        if($email) $this->$email = $email;

        if($this->email){

            $user = User::where('email', $this->email)->whereNotNull('email_verify_key')->first();

            if($user){

                if($user->email_verified_at){

                    $this->confirmed = true;
                }
                else{

                    $this->user = $user;

                }

            }
            else{
                return abort(404, "La page est introuvable");
            }

        }

        if($key) $this->email_verify_key = $key;
    }

    
    public function render()
    {
        return view('livewire.auth.email-verification-page');
    }

    public function confirmEmail()
    {
        $status = false;

        $this->validate([
            'email' => 'required|email|max:255|exists:users,email',
        ]);

        if(!$this->user){

            $user = User::where('email', $this->email)->whereNull('email_verify_key')->first();

            if($user){

                if($user->email_verified_at){

                    $this->confirmed = true;
                }
                else{

                    $this->user = $user;

                }

            }
            else{
                return abort(404, "La page est introuvable");
            }

        }

        if($this->user && $this->email){

            $this->validate([
                'email_verify_key' => 'required|string',
            ]);

            $user = $this->user;

            if(!$user->email_verified_at){

                $hash_key = $user->email_verify_key;

                $check = Hash::check($this->email_verify_key, $hash_key);

                if($check){

                    $this->key_expired = Carbon::parse($user->updated_at)->diffInMinutes() >= 60 * 24;

                    if(!$this->key_expired){

                        if(!$user->email_verified_at){
    
                            $user->forceFill([
                                'email_verify_key' => null,
                                'email_verified_at' => now(),
                            ])->setRememberToken(Str::random(60));
                 
                            $status = $user->save();
    
                        }
    
                        if($status){

                            $texto = "Votre compte ..." . $this->email . " ... a été confirmé avec succès!";

                            ModelsRobots::notificationToConfirmUnconfirmedUser($user);
    
                            return redirect(route('login'))->with('success', $texto);
                        }
                        else{
    
                            $message = "Une erreure s'est produite";
    
                            session()->flash('error', $message);
    
                            $this->toast($message, 'info', 7000);
    
                            $this->addError('email_verify_key', $message);
    
                        }
                    }
                    else{
                        $message = "La clé a déjà expiré";
    
                        session()->flash('error', $message);

                        $this->toast($message, 'info', 7000);

                        $this->addError('email_verify_key', $message);
                        
        
                    }
                }
                else{

                    $message = "La clé ne correspond pas";
    
                    session()->flash('error', $message);

                    $this->toast($message, 'info', 7000);

                    $this->addError('email_verify_key', $message);

                }

            }
            else{

                $this->confirmed = true;

                $message = "Ce compte a déja été confirmé!";

                session()->flash('info', $message);

                $this->toast($message, 'info', 7000);

                return redirect(route('login'))->with('success', $message);
            }
        }

        
    }

    public function requestNewConfirmationKey()
    {
        $email = $this->email;

        if($email){

            $user = User::where('email', $email)->whereNull('email_verified_at')->first();

            if($user){

                $user->sendVerificationLinkOrKeyToUser();

                $message = "Demande lancée avec succès! Un courriel vous a été envoyé pour confirmation, veuillez vérifier votre boite mail.";

                $this->toast($message, 'info', 5000);

                session()->flash('success', $message);

                return redirect(route('email.verification', ['email' => $this->email]))->with('success', "Confirmer votre compte en renseignant le code qui vous été envoyé!");
            }
            else{
                $message = "Adresse mail non reconnu";

                session()->flash('info', $message);

                $this->toast($message, 'info', 7000);
            }
        }
        else{

            $message = "Veuillez renseigner l'adresse mail";

            session()->flash('info', $message);

            $this->toast($message, 'info', 7000);

        }

    }


}

