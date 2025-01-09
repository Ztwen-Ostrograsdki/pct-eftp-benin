<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
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

    public $for_update = false;

    public $member = null;

    public $counter = 1;


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

        if(!$this->for_update){

            return self::forCreation();
        }
        else{

            return self::forEdition();

        }


    }


    public function forCreation()
    {
        $this->validate();

        $role = Role::find($this->role_id);

        if($role){

            if($this->user_id){

                $user = User::find($this->user_id);

                if($user){

                    if(!$user->member){

                        $m_data = [

                            'user_id' => $user->id,
                            'role_id' => $role->id,
                            'tasks' => $role->tasks,
                            'ability' => $role->ability
                        ];

                        $member = Member::create($m_data);

                        if($member){

                            $this->toast("Le proccessus c'est bien déroulé!", 'success');

                            return self::hideModal();
                            
                        }

                    }
                    else{

                        return $this->toast("Cet utilisateur joue déjà le role de " . $user->member->role->name, 'warning');
                    }

                }
                else{

                    return $this->toast("L'utilisateur est innexistant!", 'error');
                }

            }

        }
        else{

            return $this->toast("La fonction sélectionnée est innexistante!", 'error');
        }
    }

    public function forEdition()
    {
        $this->validate();

        $role = Role::find($this->role_id);

        if($role){

            if($this->user_id){

                $user = User::find($this->user_id);

                if($user){

                    if(!$user->member){

                        $m_data = [
                            'user_id' => $user->id,
                        ];

                        $member = $this->update($m_data);

                        if($member){

                            $this->reset();

                            $this->toast("Le proccessus c'est bien déroulé!", 'success');

                            $this->dispatch('UpdatedMemberList');

                            return self::hideModal();

                            
                        }

                    }
                    else{

                        return $this->toast("Cet utilisateur joue déjà le role de " . $user->member->role->name, 'warning');
                    }

                }
                else{

                    return $this->toast("L'utilisateur est innexistant!", 'error');
                }

            }

        }
        else{

            return $this->toast("La fonction sélectionnée est innexistante!", 'error');
        }
    }


    #[On('OpenMemberModalForEditEvent')]
    public function openModal($role_id = null)
    {
        $this->for_update = true;

        if($role_id){

            $role = Role::find($role_id);

            if($role){

                $this->role = $role;

                $this->description = $role->description;
    
                $this->role_id = $role->id;

                if($role->member){

                    $member = $role->member;

                    if($member){

                        $this->member = $member;
        
                        $this->user_id = $member->user_id;
        
                        $this->email = $member->user->email;
        
                    }

                }
            }
        }

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
