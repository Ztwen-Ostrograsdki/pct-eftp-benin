<?php

namespace App\Livewire\Auth;

use Akhaled\LivewireSweetalert\Toast;
use App\Jobs\JobToSendSimpleMailMessageTo;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ResetPasswordPage extends Component
{
    use Toast;

    #[Validate('required|string|confirmed|min:5')]
    public $password;
    
    public $token;

    public $password_reset_key;

    public $email;

    public $password_confirmation;

    public $not_request_sent = false;

    public $key_expired = false;

    
    
    
    public function mount($token = null, $email = null, $key = null)
    {
        if($token) $this->token = $token;

        if($email) $this->$email = $email;

        if($key) $this->password_reset_key = $key;
    }

    
    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }

    public function savePassword()
    {
        $status = false;

        if($this->token){

            $this->validate([
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed',
            ]);

            $data = [
                'email' => $this->email, 
                'password' => $this->password, 
                'password_confirmation' => $this->password_confirmation, 
                'token' => $this->token
            ];
    
            $status = Password::reset(
                $data,
                function (User $user, string $password) {

                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));
    
                    $user->save();
    
                    event(new PasswordReset($user));
                }
            );
    
            if($status === Password::PASSWORD_RESET){

                $user = User::where('email', $this->email)->first();

                $user->forceFill([
                    'blocked' => false,
                    'blocked_at' => null,
                    'wrong_password_tried' => 0,
                    'blocked_because' => null,
                ])->save();

                $sucss_message = "Nous vous avons envoyé ce courriel, pour vous informer que le mot de passe de votre compte " . env('APP_NAME') . " a été réinitialisé avec succès!";

                JobToSendSimpleMailMessageTo::dispatch($user->email, $user->getFullName(), $sucss_message, "MOT DE PASSE REINITIALISE AVEC SUCCES", null, route('login'));

                return redirect(route('login'))->with('success', "Mot de passe réinitialisé avec succès!");
            }
            else{

                $message = "Une erreure s'est produite";

                session()->flash('error', $message);

                $this->toast($message, 'info', 7000);

                $this->addError('password_reset_key', $message);
            }
        }
        else{

            $this->validate([
                'password_reset_key' => 'required|string',
                'email' => 'required|email|max:255|exists:users,email',
            ]);

            $user = User::where('email', $this->email)->whereNotNull('password_reset_key')->first();

            if($user){

                $hash_key = $user->password_reset_key;

                if(Hash::check($this->password_reset_key, $hash_key)){

                    $tok = DB::table('password_reset_tokens')->where('email', $this->email)->first();

                    if($tok && $tok->email === $this->email){

                        $this->key_expired = $tok->created_at >= 3600 * 24;

                        if($this->key_expired){

                            $message = "La clé a déjà expiré";
        
                            session()->flash('error', $message);

                            $this->toast($message, 'info', 7000);

                            $this->addError('password_reset_key', $message);
                        }

                        $user->forceFill([
                            'password' => Hash::make($this->password),
                            'password_reset_key' => null
                        ])->setRememberToken(Str::random(60));
             
                        $status = $user->save();

                        event(new PasswordReset($user));

                    }

                    if($status){

                        return redirect(route('login'))->with('success', "Mot de passe réinitialisé avec succès!");
                    }
                    else{

                        $message = "Une erreure s'est produite";

                        session()->flash('error', $message);

                        $this->toast($message, 'info', 7000);

                        $this->addError('password_reset_key', $message);

                    }
                }
                else{

                    $message = "La clé ne correspond pas";

                    session()->flash('error', $message);

                    $this->toast($message, 'info', 7000);

                    $this->addError('password_reset_key', $message);
    
                }

            }
            else{

                $this->not_request_sent = true;

                $message = "Aucune réinitialisation n'a été demandée pour ce compte";

                session()->flash('error', $message);

                $this->toast($message, 'info', 7000);

                $this->addError('email', $message);

            }
        }
    }

    public function updated($password_confirmation)
    {
        $this->validateOnly('password');
    }

    public function resendPasswordRequest()
    {

        if($this->email){

            $user = User::where('email', $this->email)->first();

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
        else{

            return redirect(route('password.forgot'))->with('error', "Veuillez reneigner votre adresse mail");
        }

        $this->key_expired = false;

        $this->resetErrorBag();
    }
}

