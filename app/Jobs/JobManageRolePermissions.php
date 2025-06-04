<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class JobManageRolePermissions implements ShouldQueue
{
    use Queueable, Batchable;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Role $role,
        public ?array $permissions_id,
        public ?User $admin_generator
    )
    {
        $this->role = $role;

        $this->permissions_id = $permissions_id;

        $this->admin_generator = $admin_generator;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();

        $role = $this->role;

        $role_name = __translateRoleName($role->name);

        try {

            $role->syncPermissions([]);

            if(count($this->permissions_id) > 0){

                $permissions = Permission::whereIn('id', $this->permissions_id)->get();

                foreach($permissions as $permission){

                    if(!$role->hasPermissionTo($permission)){

                        $role->givePermissionTo($permission);

                    }

                }

            }

            DB::commit();

        } catch (\Throwable $th) {

            Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser("La mise à jour des privilèges du rôle {$role_name} a échoué! Veuillez renseigner"));


            DB::rollBack();
        }


        
    }
}
