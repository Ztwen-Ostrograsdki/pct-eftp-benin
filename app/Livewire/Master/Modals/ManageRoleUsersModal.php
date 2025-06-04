<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitProcessToManageRoleUsersEvent;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ManageRoleUsersModal extends Component
{
    use Toast;
    
    public $modal_name = "#role-users-manager-modal";

    public $counter = 2;

    public $selecteds = [];

    public $current_selecteds = [];

    public $role_id;

    public $role;


    public function render()
    {
        $users = User::where('blocked', false)->where('confirmed_by_admin', true)->whereNotNull('email_verified_at')->whereNotIn('id', $this->current_selecteds)->get();
        
        return view('livewire.master.modals.manage-role-users-modal', compact('users'));
    }

    public function insert()
    {
        if($this->role){

            $admin_generator = auth_user();

            InitProcessToManageRoleUsersEvent::dispatch($this->role, $this->selecteds, $admin_generator);

            $role = $this->role;

            $role_name = __translateRoleName($role->name);

            $this->toast("La mise à jour des utilisateurs ayant le rôle {$role_name} a été lancée!", 'success');

            $this->hideModal();

        }
    }

    #[On('JoinUserToRoleEvent')]
    public function openModal($role_id = null)
    {
        $this->role_id = $role_id;

        $role = Role::find($this->role_id);

        $table = [];

        if($role){

            $this->role = $role;

            $selecteds = $role->users;

            foreach($selecteds as $user){

                $table[$user->id] = $user->id;

            }

            $this->current_selecteds = $table;

            $this->dispatch('OpenModalEvent', $this->modal_name);

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


    public function hideModal($modal_name = null)
    {
        $this->reset();

        $this->dispatch('HideModalEvent', $this->modal_name);
    }
}
