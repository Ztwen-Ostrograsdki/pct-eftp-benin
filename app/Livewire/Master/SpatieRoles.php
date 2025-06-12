<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitProcessToDeleteSpatieRolesEvent;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Helpers\Tools\SpatieManager;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class SpatieRoles extends Component
{

    use Toast, Confirm, WithPagination, ListenToEchoEventsTrait;

    public $display_select_cases = false;

    public $counter = 0;

    public $search = '';

    public $selected_roles = [];

    public function render()
    {
        $roles = Role::all();
        
        return view('livewire.master.spatie-roles', compact('roles'));
    }


    public function printRolesDetails()
    {
        SpatieManager::ensureThatUserCan();

        $this->toast("Cette fonctionnalité n'est pas encore disponible sur la plateforme" . env('APP_NAME') , 'info');
    }
    
    public function addNewSpatieRole()
    {
        SpatieManager::ensureThatUserCan();

        $this->toast("Cette fonctionnalité n'est pas encore disponible sur la plateforme" . env('APP_NAME') , 'info');
    }


    public function deleteRole($role_id)
    {
        SpatieManager::ensureThatUserCan();
        
        return self::deleteRoles([$role_id => $role_id]);
    }

    public function deleteRoles($data = [])
    {
        SpatieManager::ensureThatUserCan();

        if($data){

            $selected_roles = $data;
        }
        else{

            $selected_roles = $this->selected_roles;
        }

        if(count($selected_roles) > 0){

            if(count($selected_roles) == 1){

                $role = Role::whereIn('id', $selected_roles)->first();

                $role_name = " le rôle " . __translateRoleName($role->name);
            }
            else{

                $role_name = count($selected_roles) . " rôles";

            }

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de supprimer: 
                                <span class='text-sky-400 letter-spacing-2 font-semibold'> {$role_name} </span>
                            </p>
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Les utilisateurs ayant ces rôles perdront les privilèges corespondants! </p>";

            $options = ['event' => 'confirmRolesDelete', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['selected_roles' => $selected_roles]];

            $this->confirm($html, $noback, $options);
            
        }

    }

    #[On('confirmRolesDelete')]
    public function onConfirmationRolesDelete($data = null)
    {
        $selected_roles = $data['selected_roles'];

        if($selected_roles){

            InitProcessToDeleteSpatieRolesEvent::dispatch($this->selected_roles, auth_user());

            $this->toast("La procédure de suppression a été lancée!", 'sucess');

        }

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
