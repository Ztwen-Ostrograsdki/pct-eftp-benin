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

class JobToManageUserSpatiesRoles implements ShouldQueue
{
    use Queueable, Batchable;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $user,
        public ?array $selected_roles,
        public User $admin_generator
    )
    {
        $this->user = $user;

        $this->selected_roles = $selected_roles;

        $this->admin_generator = $admin_generator;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();

        $user = $this->user;

        $current_selecteds = [];

        $user_name = $user->getFullName();

        try {

            $olds_roles = $user->roles;

            foreach($olds_roles as $r){

                $current_selecteds[$r->id] = $r->id;

            }

            if(count($this->selected_roles) > 0){

                $roles = Role::whereNotIn('id', $current_selecteds)->whereIn('id', $this->selected_roles)->get();

                $removales = Role::whereIn('id', $current_selecteds)->whereNotIn('id', $this->selected_roles)->get();


                foreach($roles as $role){

                    if(!$user->hasRole($role->name)){

                        $user->assignRole($role->name);

                        $role_name = __translateRoleName($role->name);

                        UserRole::updateOrCreate(['user_id'=> $user->id, 'role_id' => $role->id], ['user_id'=> $user->id, 'role_id' => $role->id]);

                        Notification::sendNow([$this->user], new RealTimeNotificationGetToUser("FELICITATION : Votre liste de rôles administrateurs a été mise à jour : Vous avez à présent le rôle administrateur {$role_name} et ses privilèges."));

                    }

                }

                foreach($removales as $removale_role){

                    $retrieved = $user->removeRole($removale_role);

                    if($retrieved){

                        UserRole::where('user_id', $this->user->id)->where('role_id', $removale_role->id)->delete();

                    }


                }
            }
            else{

                foreach($olds_roles as $current_role){

                    $retrieved = $user->removeRole($current_role);

                    if($retrieved){

                        UserRole::where('user_id', $this->user->id)->where('role_id', $current_role->id)->delete();

                    }


                }


            }

            DB::commit();

        } catch (\Throwable $th) {

            DB::rollBack();

            Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser("ERREURE : La liste des rôles administrateurs de {$user_name} n'a pas pu être mise à jour ! Veuillez renseigner"));
            
        }


        
    }
}
