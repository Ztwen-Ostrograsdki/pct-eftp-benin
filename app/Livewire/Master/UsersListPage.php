<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\BlockUserEvent;
use App\Events\InitUserAccountDeletionEvent;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Helpers\Tools\SpatieManager;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class UsersListPage extends Component
{
    use Toast, Confirm, ListenToEchoEventsTrait;

    public $search = '';

    public $section = null;

    public $counter = null;

    public $paginate_page = 10;

    public function render()
    {
        $p = $this->paginate_page;

        $users = User::orderBy('firstname', 'asc')->orderBy('lastname', 'asc')->paginate($p);

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
                         ->orderBy('firstname', 'asc')->orderBy('lastname', 'asc')
                         ->paginate($p);
        }
        
        return view('livewire.master.users-list-page', compact('users'));
    }

    public function updatedSearch($search)
    {
        $this->search = $search;
    }


    public function marksUserAsIdentifiedOrNot($user_id)
    {

        SpatieManager::ensureThatUserCan(['users-manager', 'destroyer', 'user-account-reseter', 'account-manager']);

        $user = User::find($user_id);

        if($user){

            $name = $user->getFullName();

            $email = $user->email;

            if(!$user->confirmed_by_admin){

                $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                                <p>Voulez-vous vraiment confirmer l'indentification de l'utilisateur</p>
                                <p class='text-sky-600 py-0 my-0 font-semibold'> Mr/Mme {$name} </p>
                                <p class='text-yellow-300 py-0 my-0 font-semibold'> Mr/Mme {$email} </p>
                        </h6>";

                $noback = "Après cette action {$user->getFullName()} pourra avoir accès à son compte et deviendra officiellement un membre actif ed la plateforme!";

                $options = ['event' => 'confirmedTheUserIdentification', 'confirmButtonText' => 'Identification confirmée', 'cancelButtonText' => 'Annulé', 'data' => ['user_id' => $user_id]];
            }
            else{

                $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                                <p>Voulez-vous vraiment annuler l'indentification de l'utilisateur</p>
                                <p class='text-sky-600 py-0 my-0 font-semibold'> Mr/Mme {$name} </p>
                                <p class='text-yellow-300 py-0 my-0 font-semibold'> Email:  {$email} </p>
                        </h6>";

                $noback = "Si vous confirmez cette action {$user->getFullName()} ne pourra ni avoir accès à son compte ni se connecter!";

                $options = ['event' => 'confirmedTheUserIdentification', 'confirmButtonText' => 'Identification non confirmée', 'cancelButtonText' => 'Annulé', 'data' => ['user_id' => $user_id]];

            }

            $this->confirm($html, $noback, $options);
        }

    }

    #[On('confirmedTheUserIdentification')]
    public function onConfirmationTheUserIdentification($data)
    {
        $admin = auth_user();

        if($data){

            $user_id = $data['user_id'];

            $user = User::find($user_id);

            User::find($admin->id)->confirmedThisUserIdentification($user);
           
        }

    }


    public function confirmedUserBlockOrUnblocked($user_id)
    {

        SpatieManager::ensureThatUserCan(['users-manager', 'destroyer', 'user-account-reseter', 'account-manager']);

        $user = User::find($user_id);

        if($user->isMaster()){

            return $this->toast( "Vous ne pouvez pas effectuer une telle opération sur cet utilisateur!", 'error');
    
        }

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

                $dispatched = BlockUserEvent::dispatch($user, auth_user());

                $this->toast( "L'opération a été lancée!", 'success');
            }
            
        }

    }


    #[On("LiveUserHasBeenBlockedSuccessfullyEvent")]
    public function userBlockedSuccessfully($user = null)
    {
        
        
    }

    public function confirmedUserEmailVerification($user_id)
    {
        SpatieManager::ensureThatUserCan(['users-manager', 'destroyer', 'user-account-reseter', 'account-manager']);

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


    public function deleteUserAccount($user_id)
    {

        SpatieManager::ensureThatUserCan(['users-manager', 'destroyer', 'user-account-reseter', 'account-manager']);

        $user = User::find($user_id);

        if($user->isMaster()){

            return $this->toast( "Vous ne pouvez pas effectuer une telle opération sur cet utilisateur!", 'error');
    
        }

        if($user){

            $name = $user->getFullName();

            $email = $user->email;


            $html = "<h6 class='font-semibold flex flex-col gap-y-0 text-base text-orange-400 py-0 my-0'>
                            <span>Voulez-vous vraiment confirmer la suppression du compte de l'utilisateur</span>
                            <span class='text-sky-600 py-0 my-0 font-semibold'> Mr/Mme {$name} </span>
                            <span class='text-yellow-300 py-0 my-0 font-semibold'> Email: {$email} </span>
                            <span class='text-red-600 py-0 my-0 font-semibold'> Cette action est irréversible: le compte sera définitivement supprimé! </span>
                    </h6>";

            $noback = "";

            $options = ['event' => 'confirmedAccountDeletion', 'confirmButtonText' => 'Supprimer compte', 'cancelButtonText' => 'Annulé', 'data' => ['user_id' => $user_id]];

            $this->confirm($html, $noback, $options);
        }

    }

    #[On('confirmedAccountDeletion')]
    public function onConfirmedAccountDeletion($data)
    {
        $admin = auth_user();

        if($data){

            $user_id = $data['user_id'];
        
            if($user_id){

                $user = findUser($user_id);

                if($user){

                    $dispatched = InitUserAccountDeletionEvent::dispatch($admin, [$user_id]);

                    if($dispatched){

                    }
                }


            }
           
        }

    }

    #[On("LiveUpdateUsersListToComponentsEvent")]
    public function reloadDataNewUser()
    {
        $this->counter = getRand();
    }
}
