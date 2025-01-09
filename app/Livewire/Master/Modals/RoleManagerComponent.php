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

class RoleManagerComponent extends Component
{
    use Toast;

    #[Validate('required|string')]
    public $name;

    public $description;

    public $is_active;

    public $ability;

    public $user_id;

    public $email;

    public $counter = 2;

    public $role;

    public $task = '';

    public $just_to_add_tasks = false;

    public $modal_name = "#update-role-modal";

    #[Validate('required')]
    public $tasks;

    public function render()
    {
        $users = User::all();

        $abilities = [];

        for ($i=1; $i <= 30; $i++) { 
            
            $has1 = Role::where('ability', $i)->first();

            $has2 = Member::where('ability', $i)->first();

            if(!$has1 && !$has2) $abilities[] = $i;

        }

        return view('livewire.master.modals.role-manager-component',
            [
                'users' => $users,
                'abilities' => $abilities,
            ]
        );
    }

    public function pushIntoTasks()
    {
        if($this->task && $this->task !== ''){

            $tasks = $this->tasks;

            $tasks[] = $this->task;

            $this->tasks = $tasks;
        }

        $this->reset('task');
    }

    public function removeFromTasks($task)
    {
        if($task && $task !== ''){

            $tasks = $this->tasks;

            if(in_array($task, $tasks)){

                $keys = array_keys($tasks, $task);

                foreach($keys as $key){

                    unset($tasks[$key]);
                }

                $this->tasks = $tasks;
            }
        }
    }


    public function resetRoleData()
    {
        $this->reset();
    }

    public function editTask($task)
    {

        if($task) 

            $this->task = $task;

            self::removeFromTasks($task);
    }

    public function saveUpdate()
    {

        $this->validate();

        $name = Str::ucwords($this->name);

        $exists = Role::where('name', $name)->where('name', '<>', $name)->first();

        if(!$exists){

            $tasks = $this->tasks;

            $data = [
                'name' => $name,
                'description' => $this->description,
                'is_active' => $this->is_active,
                'tasks' => $tasks,
                'ability' => $this->ability
            ];

            $role = $this->role->update($data);

            if($role){

                $this->toast("Le proccessus c'est bien déroulé!", 'success');

                session()->forget('editing_role_name');

                $this->dispatch('UpdatedMemberList');

                return self::hideModal();
            }

        }
        else{

            return $this->toast("Cette fonction existe déjà!", 'error');

        }
    }

    #[On('OpenRoleModalForEditEvent')]
    public function openModal($role_id, $just_to_add_tasks = false)
    {
        $this->reset();

        session()->forget('editing_role_name');

        $role = Role::find($role_id);

        if($just_to_add_tasks) $this->just_to_add_tasks = $just_to_add_tasks;

        if($role){

            $this->role = $role;

            if($role->member){
                
                $this->user_id = $role->member->user_id;

                $this->email = $role->member->user->email;
            }

            $this->description = $role->description;

            $this->name = $role->name;

            $this->ability = $role->ability;

            $this->tasks = $role->tasks;

            session()->put('editing_role_name', $this->name);

        }

        $this->dispatch('OpenModalEvent', $this->modal_name);
    }

    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }

    #[On('UpdatedMemberList')]
    public function reloadData()
    {
        $this->counter = rand(3, 342);
    }
}
