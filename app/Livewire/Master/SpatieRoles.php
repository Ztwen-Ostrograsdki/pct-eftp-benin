<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class SpatieRoles extends Component
{

    use Toast, Confirm, WithPagination;

    public $display_select_cases = false;

    public $counter = 0;

    public $search = '';

    public $selected_roles = [];

    public function render()
    {
        $roles = Role::all();
        
        return view('livewire.master.spatie-roles', compact('roles'));
    }


    public function manageRolePermissions($role_id)
    {
        // $this->dispatch('OpenMemberPaymentsManagerModalEvent', $member_id, $payment_id);
    }


    public function pushOrRetrieveFromSelectedRoles($id)
    {
        $selecteds = $this->selected_roles;

        if(!in_array($id, $selecteds)){

            $selecteds[$id] = $id;
        }
        elseif(in_array($id, $selecteds)){

            unset($selecteds[$id]);
        }

        $this->resetErrorBag();

        $this->selected_roles = $selecteds;
    }


    public function toggleSelectAll()
    {
        $selecteds = $this->selected_roles;

        $roles = Role::all();

        if((count($selecteds) > 0 && count($selecteds) < count($roles)) || count($selecteds) == 0){

            foreach($roles as $role){

                if(!in_array($role->id, $selecteds)){

                    $selecteds[$role->id] = $role->id;
                }

            }

        }
        else{

            $selecteds = [];

        }

        $this->selected_roles = $selecteds;
    }

    public function toggleSelectionsCases()
    {
        return $this->display_select_cases = !$this->display_select_cases;
    }
}
