<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Models\Member;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class NewRoleModalComponent extends Component
{
    use Toast;

    #[Validate('required|string|unique:roles')]
    public $name;

    public $description;

    public $is_active;

    public $ability;

    public $user_id;

    public $email;

    public $counter = 2;

    #[Validate('required')]
    public $tasks;

    public function render()
    {
        $users = User::all();

        $roles = Role::all();

        $abilities = [];

        for ($i=1; $i <= 30; $i++) { 
            
            $has1 = Role::where('ability', $i)->first();

            $has2 = Member::where('ability', $i)->first();

            if(!$has1 && !$has2) $abilities[] = $i;

        }

        return view('livewire.master.modals.new-role-modal-component',
            [
                'users' => $users,
                'abilities' => $abilities,
            ]
        );
    }

    public function insert()
    {

        $this->validate();

        $name = Str::ucwords($this->name);

        $exists = Role::where('name', $name)->first();

        if(!$exists){

            $tasks = explode(';', $this->tasks);

            $data = [
                'name' => $name,
                'description' => $this->description,
                'is_active' => $this->is_active,
                'tasks' => $tasks,
                'ability' => $this->ability
            ];

            $role = Role::create($data);

            if($role){

                if($this->user_id){

                    $user = User::find($this->user_id);
    
                    if($user){
    
                        if(!$user->member){
    
                            $role_id = 1;
    
                            $m_data = [
    
                                'user_id' => $user->id,
                                'role_id' => $role_id,
                                'tasks' => $tasks,
                                'ability' => $this->ability
                            ];
    
                            $member = Member::create($m_data);

                            if($member){

                                $this->toast("Le proccessus c'est bien déroulé!", 'success');

                                return self::hideModal();
                                
                            }
    
                        }
    
                    }
    
                }

                return $this->toast("Le proccessus c'est bien déroulé!", 'success');
            }

        }
        else{

            return $this->toast("Cette fonction existe déjà!", 'error');

        }
    }

    public function updatedUserId($user_id)
    {
        if($user_id){
            $user = User::find($user_id);

            if($user) $this->email = $user->email;
        }
    }

    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', '#new-role-modal');
    }

    #[On('UpdatedMemberList')]
    public function reloadData()
    {
        $this->counter = rand(3, 342);
    }
}
