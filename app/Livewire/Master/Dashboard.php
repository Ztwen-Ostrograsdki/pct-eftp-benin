<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\BlockUserEvent;
use App\Events\RoleUsersWasUpdatedEvent;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Helpers\Tools\ModelsRobots;
use App\Helpers\Tools\SpatieManager;
use App\Models\User;
use App\Models\UserRole;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Dashboard extends Component
{
    public $counter = 1, $selected_users = [], $display_select_cases = false;


    use ListenToEchoEventsTrait, Toast, Confirm;

    public function render()
    {
        $users = User::with('roles')->get();
        
        return view('livewire.master.dashboard', compact('users'));
    }

    public function assignAdminRoles($user_id)
    {
        SpatieManager::ensureThatUserCan();
        
        $this->dispatch("ManageUserSpatiesRolesEvent", $user_id);
    }

    public function blockAllUsersAccount()
    {
        SpatieManager::ensureThatUserCan();

        $targets = "all_users";

        if(!empty($targets_ids)){

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de bloquer les comptes de tous les utilisateurs
                            </p>
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

            $options = ['event' => 'confirmedBlockSelectedsUsersAccount', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['targets' => $targets]];

            $this->confirm($html, $noback, $options);
        }
    } 
    
    public function blockSelectedsUsersAccount()
    {
        SpatieManager::ensureThatUserCan();

        $targets_ids = [];

        if(!empty($this->selected_users)){

            $targets_ids = $this->selected_users;
        }
        else{

            $targets_ids = [];

        }

        if(!empty($targets_ids)){

            $total = numberZeroFormattor(count($targets_ids));

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de bloquer les comptes de tous les  
                                <span class='text-sky-400 letter-spacing-2 font-semibold'> {$total} </span>
                                utilisateurs sélectionnés
                            </p>
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

            $options = ['event' => 'confirmedBlockSelectedsUsersAccount', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['targets' => $targets_ids]];

            $this->confirm($html, $noback, $options);
        }
    } 


    #[On('confirmedBlockSelectedsUsersAccount')]
    public function onconfirmedBlockSelectedsUsersAccount($data)
    {
        if($data){

            $targets = $data['targets'];

            if(is_array($targets) && !empty($targets)){

                BlockUserEvent::dispatch(null, auth_user(), $targets);

                $this->toast( "L'opération de blocage des comptes a été lancée!", 'success');

            }
            elseif(!is_array($targets)){

                if($targets == 'all_users'){

                    BlockUserEvent::dispatch(null, auth_user(), $targets, true);

                    $this->toast( "L'opération de blocage des comptes a été lancée!", 'success');

                }

            }

        }
    }
    
    public function removeAllAssignments()
    {
        SpatieManager::ensureThatUserCan();

        $targets_ids = [];

        if(!empty($this->selected_users)){

            $targets_ids = $this->selected_users;
        }
        else{

            $targets_ids = [];

        }

        if(!empty($targets_ids)){

            $total = numberZeroFormattor(count($targets_ids));

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de supprimer tous les rôles attribués aux  
                                <span class='text-sky-400 letter-spacing-2 font-semibold'> {$total} </span>
                                utilisateurs sélectionnés
                            </p>
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

            $options = ['event' => 'confirmedUsersRolesRetrieving', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['targets' => $targets_ids]];

            $this->confirm($html, $noback, $options);
        }
    } 


    #[On('confirmedUsersRolesRetrieving')]
    public function onconfirmedUsersRolesRetrieving($data)
    {
        if($data){

            $targets_ids = $data['targets'];

            if(!empty($targets_ids)){

                foreach($targets_ids as $user_id){

                    $user = findUser($user_id);

                    if($user && !$user->isMaster()){

                        if(!empty($user->roles)){

                            $retrieved = $user->syncRoles([]);

                            $retrieved = $user->syncPermissions([]);

                            if($retrieved){

                                UserRole::where('user_id', $user->id)->delete();

                                $name = $user->getFullName(true);

                                RoleUsersWasUpdatedEvent::dispatch();

                                Notification::sendNow([auth_user()], new RealTimeNotificationGetToUser("Les rôles attribués à l'utilisateur {$name} ont tous été retirés avec success!"));

                            }


                        }
                    }
                }

            }

        }
    }

    
    public function mailMessageToAdmins()
    {
        
    }

    public function pushOrRetrieveFromSelectedUsers($user_id)
    {
        $selecteds = $this->selected_users;

        if(!in_array($user_id, $selecteds)){

            $selecteds[$user_id] = $user_id;
        }
        elseif(in_array($user_id, $selecteds)){

            unset($selecteds[$user_id]);
        }

        $this->resetErrorBag();

        $this->selected_users = $selecteds;
    }


    public function toggleSelectAll()
    {
        $selecteds = $this->selected_users;

        $users = getUsers();

        $masters = ModelsRobots::getMasters();

        if((count($selecteds) > 0 && count($selecteds) < count($users) - count($masters)) || count($selecteds) == 0){

            foreach($users as $user){

                if(!$user->isMaster()){

                    if(!in_array($user->id, $selecteds)){

                        $selecteds[$user->id] = $user->id;
                    }

                }

            }

        }
        else{

            $selecteds = [];

        }

        $this->selected_users = $selecteds;
    }

    public function toggleSelectionsCases()
    {
        $this->display_select_cases = !$this->display_select_cases;

        if(!$this->display_select_cases) $this->reset('selected_users');
    }

    public function revokeThisRoleFromUserRoles($role_id, $user_id)
    {

        SpatieManager::ensureThatUserCan();

        $user = findUser($user_id);

        if(auth_user()->id !== $user->id && $user->isMaster()){

            return $this->toast( "Vous ne pouvez pas effectuer une telle opération sur cet utilisateur!", 'error');
    
        }

        $role = Role::find($role_id);

        if($role && $user->hasRole($role->name)){

            $name = $user->getFullName();

            $role_name = __translateRoleName($role->name);

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de retirer le role: 
                                <span class='text-sky-400 letter-spacing-2 font-semibold'> {$role_name} </span>
                                à l'utilisateur {$name}
                            </p>
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

            $options = ['event' => 'confirmedUserRetrieving', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['role_id' => $role->id]];

            $this->confirm($html, $noback, $options);
            
        }

    }

    #[On('confirmedUserRetrieving')]
    public function onConfirmationUserRetrieving($data)
    {

        DB::beginTransaction();

        try {
            if($data){

                $role_id = $data['role_id'];

                $role = Role::find($role_id);

                if($role){

                    $retrieved = $this->user->removeRole($role);

                    if($retrieved){

                        UserRole::where('user_id', $this->user->id)->where('role_id', $role->id)->delete();

                        $role_name = __translateRoleName($role->name);

                        $name = $this->user->getFullName(true);

                        RoleUsersWasUpdatedEvent::dispatch();

                        Notification::sendNow([auth_user()], new RealTimeNotificationGetToUser("Le rôle {$role_name} a été rétiré à l'utilisateur {$name} avec success!"));

                    }
                }
                else{

                    $this->toast( "La suppression a échoué! Veuillez réessayer!", 'error');
                }

            }

            DB::commit();

        } catch (\Throwable $th) {

            $this->toast( "Une erreure s'est produite: La suppression a échoué! Veuillez réessayer!", 'error');
            
            DB::rollBack();
        }
    }

    #[On("LiveNewVisitorHasBeenRegistredEvent")]
    public function newVisitor()
    {
        $this->counter = getRand();
    }
}
