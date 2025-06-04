<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitProcessToManageRolePermissionsEvent;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageRolePermissionsModal extends Component
{
    use Toast;

    
    public $modal_name = "#role-permissions-manager-modal";

    public $counter = 2;

    public $selecteds = [];

    public $role_id;

    public $role;

    public function render()
    {
        $permissions = Permission::all();

        return view('livewire.master.modals.manage-role-permissions-modal', compact('permissions'));
    }


    public function insert()
    {
        if($this->role){

            $admin_generator = auth_user();

            InitProcessToManageRolePermissionsEvent::dispatch($this->role, $this->selecteds, $admin_generator);

            $role = $this->role;

            $role_name = __translateRoleName($role->name);

            $this->toast("La mise à jour des privilèges du rôle {$role_name} a été lancée!", 'success');

            $this->hideModal();

        }
    }


    public function pushIntoSelecteds($id)
    {
        $tables = [];

        $selecteds = $this->selecteds;

        if(!in_array($id, $selecteds)){

            $selecteds[$id] = $id;
        }

        $this->resetErrorBag();

        $this->selecteds = $selecteds;
    }

    public function retrieveFromSelecteds($id)
    {
        $this->resetErrorBag();

        $selecteds = $this->selecteds;

        if(in_array($id, $selecteds)){

            unset($selecteds[$id]);
        }

        $this->selecteds = $selecteds;
    }

    #[On('ManageRolePermissionsEvent')]
    public function openModal($role_id)
    {
        $this->role_id = $role_id;

        $role = Role::find($this->role_id);

        $table = [];

        if($role){

            $this->role = $role;

            $selecteds = $role->permissions;

            foreach($selecteds as $perm){

                $table[$perm->id] = $perm->id;

            }

            $this->selecteds = $table;

            $this->dispatch('OpenModalEvent', $this->modal_name);

        }

        
    }


    public function hideModal($modal_name = null)
    {
        $this->reset();

        $this->dispatch('HideModalEvent', $this->modal_name);
    }
}
