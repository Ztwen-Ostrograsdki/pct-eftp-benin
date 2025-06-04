<?php

namespace App\Livewire\Master\Modals;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageRolePermissionsModal extends Component
{
    public $modal_name = "#permissions-manager-modal";

    public $counter = 2;

    public $selecteds = [];

    public $role_id;

    public function render()
    {
        $role = Role::find($this->role_id);

        $permissions = Permission::all();

        return view('livewire.master.modals.manage-role-permissions-modal', compact('permissions'));
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

            $selecteds = $role->permissions;

            foreach($selecteds as $perm){

                $table[$perm->id] = $perm->id;

            }

            $this->selecteds = $table;

        }

        $this->dispatch('OpenModalEvent', $this->modal_name);
    }


    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }
}
