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

class JobDeletSpatieRoles implements ShouldQueue
{
    use Queueable, Batchable;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public ?array $roles_id,
        public ?User $admin_generator
    )
    {
        $this->roles_id = $roles_id;

        $this->admin_generator = $admin_generator;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();

        $roles_id = $this->roles_id;

        try {

            if(count($roles_id) > 0){

                Role::whereIn('id', $roles_id)->delete();

                UserRole::whereIn('role_id', $roles_id)->delete();

            }

            DB::commit();

        } catch (\Throwable $th) {

            DB::rollBack();

            Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser("La suppression des rôles sélectionnées a échouée! Veuillez renseigner"));
            
        }


        
    }
}
