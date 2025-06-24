<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\RoleUsersWasUpdatedEvent;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
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

        if((count($selecteds) > 0 && count($selecteds) < count($users)) || count($selecteds) == 0){

            foreach($users as $user){

                if(!in_array($user->id, $selecteds)){

                    $selecteds[$user->id] = $user->id;
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
        return $this->display_select_cases = !$this->display_select_cases;
    }

    public function removeUserFromRole($role_id)
    {
        SpatieManager::ensureThatUserCan();

        $user = $this->user;

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
