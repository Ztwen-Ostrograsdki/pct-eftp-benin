<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\RoleUsersWasUpdatedEvent;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Models\UserRole;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class MyAdminRoles extends Component
{

    use Toast, Confirm, ListenToEchoEventsTrait;
    
    public $user;

    public $member;

    public $user_id;

    public $counter = 0;

    public function mount($identifiant)
    {
        if($identifiant){

            $user = getUser($identifiant, 'identifiant');

            if($user){

                $this->user = $user;

                $this->user_id = $user->id;

                if($user->member) 

                    $this->member = $user->member;

                else 
                    return abort(403, "Accès non authorisé");
            }

            if(!$user) return abort(404, "La page est introuvable");
        }
    }

    public function render()
    {
        $admin_roles = $this->user->roles;

        return view('livewire.user.my-admin-roles', compact('admin_roles'));
    }


    public function joinUserToRole()
    {
        $this->dispatch("ManageUserSpatiesRolesEvent", $this->user_id);
    }

    public function removeUserFromRole($role_id)
    {

        $user = $this->user;

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

    
    
}
