<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\MemberCreationOrUpdatingManagerEvent;
use App\Helpers\Tools\SpatieManager;
use App\Mail\ConfirmationAdhesion;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Liste des membres de l'association")]
class MembersListPage extends Component
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
        $members = [];

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
                         ->orderBy('firstname', 'asc')->orderBy('lastname', 'asc')
                         ->pluck('id')->toArray();

            $members = Member::whereIn('members.user_id', $users_ids)->paginate($p);
        }
        else{
            $users = User::orderBy('firstname', 'asc')->orderBy('lastname', 'asc')->get();

            foreach($users as $user){

                $members[] = $user->member;


            }
        }

        return view('livewire.master.members-list-page',
            [
                'members' => $members,
            ]
        );
    }

    public function changeTheMemberOfThisRole($role_id)
    {
        SpatieManager::ensureThatUserCan(['postes-manager', 'members-manager']);
        
        $this->dispatch('OpenModalToChangeTheMemberOfThisRoleEvent', $role_id);
    }

    
    
    public function changeTheRoleOfThisMember($member_id)
    {
        SpatieManager::ensureThatUserCan(['postes-manager', 'members-manager']);

        $this->dispatch('OpenModalToChangeTheRoleOfThisMemberEvent', $member_id);
    }

    public function resetMemberRoleToNull($member_id)
    {
        SpatieManager::ensureThatUserCan(['postes-manager', 'members-manager']);

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

    #[On('UpdatedMemberList')]
    public function reloadData()
    {
        $this->counter = getRand();
    }
    
    #[On('LiveUpdateMembersListEvent')]
    public function reloadDataForMembersListUpdated()
    {
        $this->counter = getRand();
    }

    public function sendMailConfirmationForAdded($user_id)
    {
        return;

        
        $user = User::find($user_id);

        $html = file_get_contents(base_path('resources/maizzle/build_production/member-confirmation.html'));

        Mail::to($user->email)->send(new ConfirmationAdhesion(
            nom: $user->name,
            poste: 'Secrétaire général',
            association: 'Association des Enseignants Techniques',
            lien: url('/espace-membre'),
            html: $html
        ));
    }
}
