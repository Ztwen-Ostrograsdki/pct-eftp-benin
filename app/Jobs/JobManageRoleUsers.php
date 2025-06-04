<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserRole;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;

class JobManageRoleUsers implements ShouldQueue
{
   use Queueable, Batchable;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Role $role,
        public ?array $users_id,
        public ?User $admin_generator
    )
    {
        $this->role = $role;

        $this->users_id = $users_id;

        $this->admin_generator = $admin_generator;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();

        $role = $this->role;

        $current_selecteds = [];

        $role_name = __translateRoleName($role->name);

        try {


            if(count($this->users_id) > 0){

                $us = $role->users;

                foreach($us as $u){

                    $current_selecteds[$u->id] = $u->id;

                }

                $users = User::where('blocked', false)->where('confirmed_by_admin', true)->whereNotNull('email_verified_at')->whereNotIn('id', $current_selecteds)->whereIn('id', $this->users_id)->get();

                foreach($users as $user){

                    if(!$user->hasRole($role->name)){

                        $user->assignRole($role->name);

                        UserRole::updateOrCreate(['user_id'=> $user->id, 'role_id' => $role->id], ['user_id'=> $user->id, 'role_id' => $role->id]);

                    }

                }

            }

            DB::commit();

        } catch (\Throwable $th) {

            DB::rollBack();

            Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser("Le rôle {$role_name} n'a pas pu être assigné aux utilisateurs que vous avez sélectionnés ! Veuillez renseigner"));
            
        }


        
    }
}