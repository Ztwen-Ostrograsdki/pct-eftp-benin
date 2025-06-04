<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleProfil extends Component
{

    use Toast, Confirm, WithPagination;

    public $display_select_cases = false;

    public $counter = 0;

    public $search = '';

    public $role_id;

    public function mount($role_id)
    {
        if($role_id){

            $role = Role::find($role_id);

            if(!$role) return abort(404); else $this->role_id = $role->id;
        }
        else{

            return abort(404);
        }
    }

    public function render()
    {
        $role = Role::find($this->role_id);

        return view('livewire.master.role-profil', compact('role'));
    }

    public function joinUserToRole()
    {

    }

    public function manageRolePermissions()
    {
        $this->dispatch("ManageRolePermissionsEvent", $this->role_id);
    }
    
    public function deletePermission($permission_id)
    {

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

                $this->toast( "La permission a été retirée des privilèges de ce rôle avec succès!", 'success');

            }
            else{

                $this->toast( "La suppression a échoué! Veuillez réessayer!", 'error');
            }

        }

    }
}
