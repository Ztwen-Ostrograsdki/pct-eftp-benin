<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\Member;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Liste des membres de l'association")]
class MembersListPage extends Component
{
    use Toast, Confirm;

    public $deleting_member;

    public $counter = 2;

    public function render()
    {
        $members = Member::all();

        $users = User::all();

        return view('livewire.master.members-list-page',
            [
                'members' => $members,
                'users' => $users,
            ]
        );
    }

    public function editRole($member_id)
    {
        $this->dispatch('OpenMemberModalForEditEvent', $member_id);
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

    #[On('UpdatedMemberList')]
    public function reloadData()
    {
        $this->counter = rand(3, 342);
    }
}
