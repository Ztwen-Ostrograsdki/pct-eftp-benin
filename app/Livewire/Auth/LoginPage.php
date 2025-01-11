<?php

namespace App\Livewire\Auth;

use Akhaled\LivewireSweetalert\Toast;
use App\Events\BlockedUserTryingToLoginEvent;
use App\Helpers\Tools\ModelsRobots;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

 
class LoginPage extends Component
{
    use Toast;

    #[Validate('required|email|exists:users|max:255')]
    public $email;

    #[Validate('required|string|min:5')]
    public $password;


    public function mount($email = null)
    {
        if($email) $this->email = $email;
    }
    
    public function render()
    {
        return view('livewire.auth.login-page');
    }

    public function login()
    {
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
        if($user){

            $data = [
                'email' => $this->email, 
                'password' => $this->password
            ];

            if(!$user->email_verified_at){

                $message = "Ce compte n'a pas encore été vérifié";

                $this->toast($message, 'warning', 5000);

                session()->flash('error', $message);

                $user->sendVerificationLinkOrKeyToUser();

                return redirect(route('email.verification', ['email' => $this->email]))->with('success', "Pour vous connecter, confirmer votre compte en renseignant le code qui vous été envoyé!");

            }

            if(!$user->confirmed_by_admin){

                $message = "Votre identification en tant que utilisateur de cette plateforme n'a pas encore été confirmée par les administrateurs!";

                $this->toast($message, 'warning', 5000);

                session()->flash('error', $message);

                ModelsRobots::notificationToConfirmUnconfirmedUser($user);

                return false;

                

            }

            if($user->blocked){

                $message = "Vous ne pouvez pas vous connecter, votre compte a été bloqué, veuillez contacter les administrateurs!";

                $this->toast($message, 'warning', 5000);

                session()->flash('error', $message);

                BlockedUserTryingToLoginEvent::dispatch($user);

                return false;

            }

            $auth = Auth::attempt($data);

            if($auth){

                if(!$user->auth_token){

                    $user->update(['auth_token' => Str::replace("/", $user->identifiant, Hash::make($user->identifiant))]);
                }

                $this->toast("Vous êtes connecté!", 'success');

                request()->session()->regenerate();

                return $this->redirectIntended(route('user.profil', ['identifiant'=> $user->identifiant]));
            }
            else{

                $this->toast("Données incorrectes", 'error');

                $this->addError('email', "Les informations ne correspondent pas");

                $this->addError('password', "Les informations ne correspondent pas");

                $this->reset('password');

                return back()->withErrors(["email" => "Les informations ne correspondent pas!"])->onlyInput('email');
            }

        }

    }
}

