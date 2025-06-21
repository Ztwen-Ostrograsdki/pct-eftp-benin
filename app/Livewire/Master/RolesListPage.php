<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\MemberCreationOrUpdatingManagerEvent;
use App\Helpers\Tools\SpatieManager;
use App\Models\Member;
use App\Models\Role;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Les fonctions de l'association")]
class RolesListPage extends Component
{
    use Toast, Confirm;

    public $counter = 0;

    public $is_included = false;

    public $deleting_member;


    public function render()
    {
        $roles = Role::all();

        $user = auth_user();
        
        return view('livewire.master.roles-list-page', 
            [
                'roles' => $roles,
                'user' => $user,
            ]
        );
    }

    public function refreshAllPosts()
    {
        SpatieManager::ensureThatUserCan(['members-manager', 'postes-manager']);
    }

    public function changeTheMemberOfThisRole($role_id)
    {
        SpatieManager::ensureThatUserCan(['members-manager', 'postes-manager']);

        $this->dispatch('OpenModalToChangeTheMemberOfThisRoleEvent', $role_id);
    }

    public function editRole($role_id)
    {
        SpatieManager::ensureThatUserCan(['members-manager', 'postes-manager']);

        $this->dispatch('OpenMemberModalForEditEvent', $role_id);
    }

    public function updateRoleData($role_id)
    {
        SpatieManager::ensureThatUserCan(['members-manager', 'postes-manager']);

        $this->dispatch('OpenRoleModalForEditEvent', $role_id);
    }

    public function resetMemberRoleToNull($member_id)
    {
        SpatieManager::ensureThatUserCan(['members-manager', 'postes-manager']);

        $member = Member::find($member_id);

        if($member){

            $name = $member->user->getFullName();

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Voulez-vous vraiment Réinitialiser le poste de  </p>
                            <p class='text-sky-600 py-0 my-0 font-semibold'> Mr/Mme {$name} </p>
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est réversible! </p>";

            $options = ['event' => 'confirmedMemberRoleReseting', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['member_id' => $member_id]];

            $this->confirm($html, $noback, $options);
            
        }
        else{

            $this->toast( "La suppression ne peut être effectuée: Membre inconnu! Veuillez vérifier les données et réessayer!", 'warning');
        }
    }



    #[On('confirmedMemberRoleReseting')]
    public function onConfirmationMemberRoleReseting($data)
    {
        if($data){

            $member_id = $data['member_id'];

            $member = Member::find($member_id);

            if($member){

                $admin = auth_user();

                $user = $member->user;

                $data = ['role_id' => null];

                $dispatched = MemberCreationOrUpdatingManagerEvent::dispatch($admin, $user, $data, $member);

                if($dispatched){

                    $this->reset();

                    $this->toast("Le proccessus a été lancé!", 'success');
                }

            }
            else{

                $this->toast( "Erreur membre introuvabel!", 'error');
            }

        }

    }

    

    public function removeFromTasks($role_id, $task = null)
    {
        SpatieManager::ensureThatUserCan(['members-manager', 'postes-manager']);

        $task = str_replace("@", "'", $task);

        if($role_id && $task){

            $role = Role::find($role_id);

            if($role){

                $tasks = $role->tasks;

                if(in_array($task, $tasks)){

                    $keys = array_keys($tasks, $task);

                    foreach($keys as $key){

                        unset($tasks[$key]);
                    }

                    $role->update(['tasks' => $tasks]);

                    $this->toast("La tâche a été retirée avec succès!", 'success');

                    $this->dispatch('UpdatedMemberList');

                }
            }
        }
    }


    public function addNewTaskToRole($role_id)
    {
        SpatieManager::ensureThatUserCan(['members-manager', 'postes-manager']);

        $this->dispatch('OpenRoleModalForEditEvent', $role_id, true);
    }

    #[On('UpdatedMemberList')]
    public function reloadData()
    {
        $this->counter = rand(3, 342);
    }

    #[On('LiveUpdateMembersListEvent')]
    public function reloadDataForMembersListUpdated()
    {
        $this->counter = getRand();
    }
    
}
