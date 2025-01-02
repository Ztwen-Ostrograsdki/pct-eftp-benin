<?php

namespace App\Livewire\Master\Modals;

use App\Models\Member;
use App\Models\Role;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class NewMemberModalComponent extends Component
{
    #[Validate('required|numeric')]
    public $user_id;

    #[Validate('required|numeric')]
    public $role_id;

    public $email;

    public $description;


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

        $role = Role::find($this->role_id);

        if($role){

            if($this->user_id){

                $user = User::find($this->user_id);

                if($user){

                    if(!$user->member){

                        $role_id = 1;

                        $m_data = [

                            'user_id' => $user->id,
                            'role_id' => $role_id,
                            'tasks' => $role->tasks,
                            'ability' => $role->ability
                        ];

                        $member = Member::create($m_data);

                        if($member){

                            return $this->toast("Le proccessus c'est bien déroulé!", 'success');
                            
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
}
