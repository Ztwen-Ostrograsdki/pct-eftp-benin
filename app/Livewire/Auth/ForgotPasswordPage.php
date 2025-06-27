<?php

namespace App\Livewire\Auth;

use Akhaled\LivewireSweetalert\Toast;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ForgotPasswordPage extends Component
{
    use Toast;

    #[Validate('required|email|max:255')]
    public $email;


    public function render()
    {
        return view('livewire.auth.forgot-password-page');
    }

    public function submitForm()
    {

        $this->resetErrorBag();

        $user = User::where('email', $this->email)->first();

        if(!$this->email){

            $message = "Email invalide";

            session()->flash('error', $message);

            $this->toast($message, 'info', 7000);

            $this->addError('email', "Entrez une adrresse mail");
        }
        elseif($this->email && !$user){

            $message = "Données incorrectes ou inconnues: Veuillez entrer une adresse valide";

            session()->flash('error', $message);

            $this->toast($message, 'info', 7000);

            $this->addError('email', "Aucune correspondance trouvée");
        }

        if($this->validate() && $user){

            if(!$user->blocked || ($user->blocked && $user->blocked_because == 'wrong.password.tried')){
                Password::sendResetLink(['email' => $this->email]);

                $status = Password::RESET_LINK_SENT;

                if($status){

                    $user->sendPasswordResetKeyToUser();

                    $this->resetErrorBag();

                    $message = "Validation lancée avec succès! Un courriel vous a été envoyé, veuillez vérifier votre boite mail.";

                    $this->toast($message, 'info', 7000);

                    session()->flash('success', $message);

                    return redirect(route('password.reset.by.email', ['email' => $this->email]));
                }
                else{

                    $message = "Validation échouée! Une erreure est survenue, Veuillez réessayer";

                    $this->toast($message, 'error', 7000);

                    session()->flash('message', $message);
                }
            }
            elseif($user->blocked){

                $message = "Votre compte a été bloqué. Veuillez contacter les administrateurs de la plateforme afin de reccuperer votre compte!";

                session()->flash('error', $message);

                $this->toast($message, 'info', 10000);

            }
        }
    }
}
