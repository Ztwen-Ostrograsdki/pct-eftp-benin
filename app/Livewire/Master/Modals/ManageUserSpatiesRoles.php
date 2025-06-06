<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitProcessToManageUserSpatieRolesEvent;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ManageUserSpatiesRoles extends Component
{
    use Toast;

    
    public $modal_name = "#manage-user-spaties-role-modal";

    public $counter = 2;

    public $selecteds = [];

    public $user_id;

    public $user;

    public function render()
    {
        $roles = Role::all();
        
        return view('livewire.master.modals.manage-user-spaties-roles', compact('roles'));
    }


    public function insert()
    {
        if($this->user){

            $admin_generator = auth_user();

            $user_name = $this->user->getFullName();

            InitProcessToManageUserSpatieRolesEvent::dispatch($this->user, $this->selecteds, $admin_generator);

            $this->toast("La mise à jour de la liste des rôles administrateurs de  {$user_name} a été lancée!", 'success');

            $this->hideModal();

        }
    }


    public function pushIntoSelecteds($id)
    {
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

    #[On('ManageUserSpatiesRolesEvent')]
    public function openModal($user_id)
    {
        $this->user_id = $user_id;

        $user = User::find($this->user_id);

        $table = [];

        if($user){

            $this->user = $user;

            $selecteds = $user->roles;

            foreach($selecteds as $role){

                $table[$role->id] = $role->id;

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
