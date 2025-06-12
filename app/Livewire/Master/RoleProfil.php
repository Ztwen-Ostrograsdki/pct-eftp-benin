<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\RolePermissionsWasUpdatedEvent;
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
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleProfil extends Component
{

    use Toast, Confirm, WithPagination, ListenToEchoEventsTrait;

    public $display_select_cases = false;

    public $counter = 0;

    public $search = '';

    public $role_id;

    public $role;

    public function mount($role_id)
    {
        if($role_id){

            $role = Role::find($role_id);

            if($role){

                $this->role_id = $role->id;

                $this->role = $role;

            }
            else{

                return abort(404);

            }
        }
        else{

            return abort(404);
        }
    }

    public function render()
    {
        return view('livewire.master.role-profil');
    }

    public function joinUserToRole()
    {
        SpatieManager::ensureThatUserCan();

        $this->dispatch("JoinUserToRoleEvent", $this->role_id);
    }

    public function manageRolePermissions()
    {
        SpatieManager::ensureThatUserCan();

        $this->dispatch("ManageRolePermissionsEvent", $this->role_id);
    }
    
    public function deletePermission($permission_id)
    {
        SpatieManager::ensureThatUserCan();

        $permission = Permission::find($permission_id);

        $role = Role::find($this->role_id);

        if($permission){

            $name = __translatePermissionName($permission->name);

            $role_name = __translateRoleName($role->name);

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de retirer la permission: 
                                <span class='text-sky-400 letter-spacing-2 font-semibold'> {$name} </span>
                                de la liste des privilèges du rôle {$role_name}
                            </p>
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

            $options = ['event' => 'confirmedPermissionDeletion', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['permission_id' => $permission->id]];

            $this->confirm($html, $noback, $options);
            
        }

    }

    #[On('confirmedPermissionDeletion')]
    public function onConfirmationPermissionDeletion($data)
    {
        if($data){

            $permission_id = $data['permission_id'];

            $permission = Permission::find($permission_id);

            if($permission){

                $retrieved = $this->role->revokePermissionTo($permission);

                if($retrieved){

                    RolePermissionsWasUpdatedEvent::dispatch();

                    $this->toast( "La permission a été retirée des privilèges de ce rôle avec succès!", 'success');

                }
            }
            else{

                $this->toast( "La suppression a échoué! Veuillez réessayer!", 'error');
            }

        }

    }


    public function removeUserFromRole($user_id)
    {
        SpatieManager::ensureThatUserCan();

        $user = User::find($user_id);

        $role = Role::find($this->role_id);

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

            $options = ['event' => 'confirmedUserRetrieving', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['user_id' => $user->id]];

            $this->confirm($html, $noback, $options);
            
        }

    }

    #[On('confirmedUserRetrieving')]
    public function onConfirmationUserRetrieving($data)
    {

        DB::beginTransaction();

        try {
            if($data){

                $user_id = $data['user_id'];

                $user = User::find($user_id);

                if($user){

                    $retrieved = $user->removeRole($this->role);

                    if($retrieved){

                        UserRole::where('user_id', $user->id)->where('role_id', $this->role->id)->delete();

                        $role_name = __translateRoleName($this->role->name);

                        $name = $user->getFullName(true);

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
}
