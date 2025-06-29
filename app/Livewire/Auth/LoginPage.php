<?php

namespace App\Livewire\Auth;

use Akhaled\LivewireSweetalert\Toast;
use App\Events\BlockedUserTryingToLoginEvent;
use App\Events\BlockUserEvent;
use App\Events\LogoutUserEvent;
use App\Helpers\Tools\ModelsRobots;
use App\Jobs\JobToSendSimpleMailMessageTo;
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

        $max_password_tried = env('APP_MAX_PASSWORD_TRIED');

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

                $message = "Votre identification en tant que utilisateur de cette plateforme n'a pas encore été confirmée par les administrateurs! Cependant, un courriel a été envoyé aux administrateurs afin de prendre en compte le plus vite possible la confirmation de votre compte";

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

                $user->forceFill([
                    'blocked' => false,
                    'blocked_at' => null,
                    'wrong_password_tried' => 0,
                    'blocked_because' => null,
                ])->save();

                if(!$user->auth_token){

                    $user->update(['auth_token' => Str::replace("/", $user->identifiant, Hash::make($user->identifiant))]);
                }

                $this->toast("Connexion réussie!", 'success');

                request()->session()->regenerate();

                return $this->redirectIntended(route('user.profil', ['identifiant'=> $user->identifiant]));
            }
            else{

                $user = User::where('email', $this->email)->first();

                if($user){

                    $increment = $user->wrong_password_tried + 1;

                    $user->update(['wrong_password_tried' => $increment]);

                    

                    if($user->wrong_password_tried >= $max_password_tried){

                        $err_message = "Nous vous avons envoyé ce courriel, pour vous signaler que votre compte " . env('APP_NAME') . " a été bloqué suite des connexions malvaillantes et suspectes que nous avons décélée lié à votre compte dont l'addresse mail est : " . $user->email . ". Vous pouvez reccuperez votre compte soit en le signalant aux administrateurs soit en essayant de vous connecter en précisant mot de passe oublié. La seconde méthode, nous vous le signalons qu'elle ne marche que dans 5% des cas!";

                        JobToSendSimpleMailMessageTo::dispatch($user->email, $user->getFullName(), $err_message, "COMPTE BLOQUES POUR TROP TENTATIVES ERRONEES DE CONNEXION", null, route('login'));

                        $user->userBlockerOrUnblockerRobot(true, "wrong.tried.password");

                        LogoutUserEvent::dispatch($user);

                    }
                    elseif($user->wrong_password_tried == $max_password_tried - 1){

                        $err_message = "Attention trop de tentatives de connexion erronée: une autre tentative erronée entrainera le blocage du compte! Pensez peut-être à mot de passe oublié!";

                        session()->flash('error', $err_message);
                        
                    }
                }

                $this->toast("Données incorrectes", 'error');

                $this->addError('email', "Les informations ne correspondent pas");

                $this->addError('password', "Les informations ne correspondent pas");

                $this->reset('password');

                return back()->withErrors(["email" => "Les informations ne correspondent pas!"])->onlyInput('email');
            }

        }

    }
}

