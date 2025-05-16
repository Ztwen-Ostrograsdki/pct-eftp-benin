<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
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
        
        return view('livewire.master.roles-list-page', 
            [
                'roles' => $roles,
            ]
        );
    }

    public function refreshAllPosts()
    {
        
    }

    public function editRole($role_id)
    {
        $this->dispatch('OpenMemberModalForEditEvent', $role_id);
    }

    public function updateRoleData($role_id)
    {
        $this->dispatch('OpenRoleModalForEditEvent', $role_id);
    }

    public function removeUserFormMembers($member_id)
    {
        if(!__isAdminAs()) return abort(403, "Vous n'êtes pas authorisé!");

        $member = Member::find($member_id);

        if($member){

            $this->deleting_member = $member;

            $options = ['event' => 'confirmedMemberRetrieving'];

            $this->confirm("Confirmation de la suppression ou du retrait de " . $member->user->getFullName(true) . " de la liste des membres!", "Cette action est irréversible", $options);
        }
        else{

            $this->toast( "La suppression ne peut être effectuée: Membre inconnu! Veuillez vérifier les données et réessayer!", 'warning');
        }
    }

    #[On('confirmedMemberRetrieving')]
    public function onConfirmationMemberRetrieving()
    {
        $del = $this->deleting_member->delete();

        if($del){

            $message = "La suppression est terminée.";

            $this->toast($message, 'success');

            $this->dispatch("UpdatedMemberList");

        }
        else{

            $this->toast( "La suppression a échoué! Veuillez réessayer!", 'error');

        }

    }

    public function removeFromTasks($role_id, $task = null)
    {

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
        $this->dispatch('OpenRoleModalForEditEvent', $role_id, true);
    }

    #[On('UpdatedMemberList')]
    public function reloadData()
    {
        $this->counter = rand(3, 342);
    }
    
}
