<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\BlockUserEvent;
use App\Helpers\Tools\SpatieManager;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Profil Utilisateur')]
class UserProfil extends Component
{
    use Toast, Confirm;

    public $counter = 0;

    public $user;

    public $public_section = 'personnel';

    public $public_title = "Détails civilités";

    public $details = [
        'personnel' => "Détails civilités",
        'diplome' => "Détails Diplome",
        'professionnel' => "Détails professionnel",
    ];

    public function makePublicSection($section)
    {
        session()->put('public_section', $section);

        $this->public_section = $section;
    }

    public function mount($identifiant)
    {
        if($identifiant){

            $user = getUser($identifiant, 'identifiant');

            if($user){

                $this->user = $user;
            }

            if(!$user) return abort(404, "La page est introuvable");
        }
    }

    public function render()
    {
        if(session()->has('public_section')){

            $this->public_section = session('public_section');
        }
        return view('livewire.user.user-profil');
    }

    public function confirmedUserIdentification()
    {
        SpatieManager::ensureThatUserCan(['users-manager', 'destroyer', 'user-account-reseter', 'account-manager']);

        $user = $this->user;

        $user_id = $this->user->id;

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


    public function confirmedUserBlockOrUnblocked()
    {

        SpatieManager::ensureThatUserCan(['users-manager', 'destroyer', 'user-account-reseter', 'account-manager']);

        $user = $this->user;

        if($user->isMaster()){

            return $this->toast( "Vous ne pouvez pas effectuer une telle opération sur cet utilisateur!", 'error');
    
        }

        $user_id = $this->user->id;

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

    public function confirmedUserEmailVerification()
    {
        
        SpatieManager::ensureThatUserCan(['users-manager', 'destroyer', 'user-account-reseter', 'account-manager']);

        $user = $this->user;

        $user_id = $this->user->id;

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

    #[On('UserProfilUpdated')]
    public function reloadData()
    {
        $this->counter = getRand();
    }

    #[On('LiveUpdateMembersListEvent')]
    public function reloadDataForMembersListUpdated()
    {
        $this->counter = getRand();
    }
    
    #[On('LiveUserMemberProfilHasBeenCreatedEvent')]
    public function reloadDataForMember()
    {
        $this->counter = getRand();
    }

    #[On('LiveUpdatedUserProfilEvent')]
    public function reloadDataForUser()
    {
        $this->counter = getRand();
    }
}
