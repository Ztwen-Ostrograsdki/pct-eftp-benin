<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\BlockUserEvent;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class UsersListPage extends Component
{
    use Toast, Confirm;

    protected $listeners = [
        'LiveUserHasBeenBlockedSuccessfullyEvent' => 'userBlockedSuccessfully',
    ];

    public $search = '';

    public $section = null;

    public $paginate_page = 10;

    public function render()
    {
        $p = $this->paginate_page;

        $users = User::paginate($p);

        if($this->search && strlen($this->search) >= 2){

            $s = '%' . $this->search . '%';

            $users = User::where('firstname', 'like', $s)
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
                         ->paginate($p);
        }
        
        return view('livewire.master.users-list-page', compact('users'));
    }

    public function updatedSearch($search)
    {
        $this->search = $search;
    }

    public function confirmedUserIdentification($user_id)
    {

        $user = User::find($user_id);

        if($user){

            if($user->confirmed_by_admin) return $this->toast("Cet utilisateur est déjà identifié", 'success');

            $options = ['event' => 'confirmedTheUserIdentification', 'data' => ['user_id' => $user_id]];

            $this->confirm("Confirmation l'indentification de " . $user->getFullName(true), "Cette action est irréversible", $options);
        }

    }

    #[On('confirmedTheUserIdentification')]
    public function onConfirmationTheUserIdentification($data)
    {

        if($data){

            $user_id = $data['user_id'];

            $user = User::find($user_id);

            $user = $user->confirmedThisUserIdentification();

            if($user){

                $message = "L'identification a été confirmée avec success!";

                $this->toast($message, 'success');

                session()->flash('success', $message);

            }
            else{

                $this->toast( "L'opération a échoué! Veuillez réessayer!", 'error');

            }
        }

    }


    public function confirmedUserBlockOrUnblocked($user_id)
    {

        $user = User::find($user_id);

        if($user){

            if($user->blocked){

                $since = $user->__getDateAsString($user->blocked_at, 3, true);

                $t = "Confirmez le déblocage de " . $user->getFullName();

                $r = "Vous étes sur le point de débloquer cet utilisateur bloqué depuis " . $since;
            }
            else{

                $t = "Confirmez le blocage de " . $user->getFullName();

                $r = "Vous étes sur le point de bloquer cet utilisateur";

            }

            $options = ['event' => 'confirmedTheUserBlockOrUnblocked', 'data' => ['user_id' => $user_id]];

            $this->confirm($t, $r, $options);
        }

    }

    #[On('confirmedTheUserBlockOrUnblocked')]
    public function onConfirmationTheUserBlockOrUnblocked($data)
    {
        $action = true;

        if($data){

            $user_id = $data['user_id'];

            $user = User::find($user_id);


            if($user->blocked) $action = false;

            if($action == false){

                $user = $user->userBlockerOrUnblockerRobot($action);

                if($user){

                    $message = "Le processus de blocage a été lancé avec success!";
    
                    if(!$action) $message = "Le processus de déblocage a été lancé avec success!" ;
    
                    $this->toast($message, 'success');
    
                    session()->flash('success', $message);
    
                }
                else{
    
                    $this->toast( "L'opération a échoué! Veuillez réessayer!", 'error');
    
                }
            }
            else{

                BlockUserEvent::dispatch($user);

                if($user){

                    $message = "Le processus de blocage a été lancé avec success!";
    
                    if(!$action) $message = "Le processus de déblocage a été lancé avec success!" ;
    
                    $this->toast($message, 'success');
    
                    session()->flash('success', $message);
    
                }
                else{
    
                    $this->toast( "L'opération a échoué! Veuillez réessayer!", 'error');
    
                }
            }
            
        }

    }


    public function userBlockedSuccessfully($user)
    {
        
        if($user && $user['blocked']){

            $message = "L'utilisateur a été bloqué avec success!";

            $this->toast($message, 'success');

            session()->flash('success', $message);

        }
        else{

            $this->toast( "L'opération a échoué! Veuillez réessayer!", 'error');

        }
    }

    public function confirmedUserEmailVerification($user_id)
    {

        $user = User::find($user_id);

        if($user){

            $t = "Confirmez l'addresse mail de " . $user->getFullName();

            $r = "Vous étes sur le point de confirmer l'addresse mail de cet utilisateur";


            $options = ['event' => 'confirmedTheUserEmailVerification', 'data' => ['user_id' => $user_id]];

            $this->confirm($t, $r, $options);
        }

    }

    #[On('confirmedTheUserEmailVerification')]
    public function onConfirmationTheUserEmailVerification($data)
    {
        if($data){

            $user_id = $data['user_id'];

            $user = User::find($user_id);

            $verified = $user->markAsVerified();

            if($verified){

                $message = "L'utilisateur a été confirmé avec success!";

                $this->toast($message, 'success');

                session()->flash('success', $message);

            }
            else{

                $this->toast( "La confirmation a échoué! Veuillez réessayer!", 'error');

            }
        }

    }
}
