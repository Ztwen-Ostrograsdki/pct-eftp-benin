<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\MemberCreationOrUpdatingManagerEvent;
use App\Models\Member;
use App\Models\Role;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class NewMemberModalComponent extends Component
{
    use Toast, Confirm;

    #[Validate('required|numeric')]
    public $user_id;

    #[Validate('required|numeric')]
    public $role_id;

    public $email;

    public $description;

    public $role;

    public $member = null;

    public $counter = 1;

    public $default_role = 99999999999999999999;


    public function render()
    {
        $users = User::all();

        $roles = Role::all();
        
        return view('livewire.master.modals.new-member-modal-component', 
            [
                'users' => $users,
                'roles' => $roles,
            ]
        );
    }

    public function updatedUserId($user_id)
    {
        if($user_id){
            $user = User::find($user_id);

            if($user) $this->email = $user->email;
        }
    }

    public function insert()
    {
        $this->validate();

        $admin = auth_user();

        $user = User::find($this->user_id);

        if($this->role_id == $this->default_role) $this->role_id = null;

        $data = ['role_id' => $this->role_id];

        $member = $this->member;

        if(!$this->member) $member = $user->member;

        $dispatched = MemberCreationOrUpdatingManagerEvent::dispatch($admin, $user, $data, $member);
        
        if($dispatched){

            $this->reset();

            $this->toast("Le proccessus a été lancé!", 'success');

            return self::hideModal();
            
        }

        
    }


    #[On('OpenModalToChangeTheMemberOfThisRoleEvent')]
    public function openModalToChangeMember($role_id)
    {
        $this->reset();

        $role = Role::find($role_id);

        if($role){

            $this->role = $role;

            $this->description = $role->description;

            $this->role_id = $role->id;

            if($role->member){

                $member = $role->member;

                if($member){

                    $this->user_id = $member->user_id;
    
                    $this->email = $member->user->email;
    
                }

            }
        }

        $this->dispatch('OpenModalEvent', '#new-member-modal');
    }
    
    #[On('OpenModalToChangeTheRoleOfThisMemberEvent')]
    public function openModalToChangeRole($member_id)
    {
        $this->reset();

        $member = Member::find($member_id);

        if($member){

            $this->member = $member;

            $this->user_id = $member->user_id;

            $this->email = $member->user->email;

        }

        $this->dispatch('OpenModalEvent', '#new-member-modal');
    }

    #[On('OpenModalToJoinMemberToRole')]
    public function openModal()
    {
        $this->reset();

        $this->dispatch('OpenModalEvent', '#new-member-modal');
    }

    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', '#new-member-modal');
    }

    #[On('UpdatedMemberList')]
    public function reloadData()
    {
        $this->counter = rand(3, 342);
    }
}
