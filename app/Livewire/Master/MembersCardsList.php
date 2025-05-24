<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitMemberCardSchemaEvent;
use App\Events\InitProcessToBuildLotCardsMemberEvent;
use App\Models\Member;
use App\Models\User;
use function PHPUnit\Framework\fileExists;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class MembersCardsList extends Component
{
    use Toast, Confirm;

    public $deleting_member;

    public $counter = 2;

    public $search = '';

    public $paginate_page = 10;

    public function updatedSearch($search)
    {
        $this->search = $search;
    }

    public function render()
    {
        $members = Member::all();

        $p = $this->paginate_page;

        if($this->search && strlen($this->search) >= 2){

            $s = '%' . $this->search . '%';

            $users_ids = User::where('firstname', 'like', $s)
                         ->orWhere('lastname', 'like', $s)
                         ->orWhere('email', 'like', $s)
                         ->orWhere('contacts', 'like', $s)
                         ->orWhere('school', 'like', $s)
                         ->orWhere('grade', 'like', $s)
                         ->orWhere('graduate', 'like', $s)
                         ->orWhere('pseudo', 'like', $s)
                         ->orWhere('address', 'like', $s)
                         ->orWhere('job_city', 'like', $s)
                         ->orWhere('status', 'like', $s)
                         ->orWhere('birth_city', 'like', $s)
                         ->orWhere('gender', 'like', $s)
                         ->orWhere('current_function', 'like', $s)
                         ->orWhere('matricule', 'like', $s)
                         ->orWhere('ability', 'like', $s)
                         ->orWhere('graduate', 'like', $s)
                         ->orWhere('graduate_type', 'like', $s)
                         ->orWhere('graduate_deliver', 'like', $s)
                         ->orWhere('marital_status', 'like', $s)
                         ->pluck('id')->toArray();

            $members = Member::whereIn('members.user_id', $users_ids)->paginate($p);
        }

        return view('livewire.master.members-cards-list',
            [
                'members' => $members,
            ]
        );
    }

    public function editRole($member_id)
    {
        $this->dispatch('OpenMemberModalForEditEvent', $member_id);
    }


    public function generateMembersCards()
    {

        $admin_generator = auth_user();
        
        $members = getMembers();

        InitProcessToBuildLotCardsMemberEvent::dispatch($admin_generator, $members);
    }

    public function generateCardMember($member_id)
    {

        $member = Member::find($member_id);

        $key = Str::random(4);

        $admin_generator = auth_user();

        InitMemberCardSchemaEvent::dispatch($member, $key, $admin_generator);
    }
    
    public function showMemberCard($member_id)
    {
        $member = Member::find($member_id);

        if($member){

            return to_route('master.card.member', ['identifiant' => $member->user->identifiant]);
        }
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
    
    #[On('LiveMembersCardCreationCompletedEvent')]
    public function reloadDataForNew()
    {
        $this->counter = rand(3, 342);
    }

    #[On('LiveUpdateMembersListEvent')]
    public function reloadDataForMembersListUpdated()
    {
        $this->counter = getRand();
    }
}

