<?php

namespace App\Jobs;

use App\Helpers\Services\JobResportsService;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;

class JobToDeleteUserAccount implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $admin_generator,
        public User $user_to_delete,
    )
    {
        $this->user_to_delete = $user_to_delete;

        $this->admin_generator = $admin_generator;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // SUPPRESSION DU COMPTE ICI

        DB::beginTransaction();

        $user = $this->user_to_delete;

        try {

            $member = $user->member;

            if($member) $member->delete();

            $profil_photo = $user->profil_photo;

            $path = storage_path().'/app/public/' . $profil_photo;

            File::delete($path);

            $user->delete();

            DB::commit();

            $message_to_creator = "Le compte de " . $user->getFullName() . " a été supprimé avec succès!";

            Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

        } catch (\Throwable $th) {

            DB::rollback();
            

            $message_to_creator = "Le compte de " . $user->getFullName() . " n'a pas été supprimé. ERREUR: " . $th->getMessage();

            Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser($message_to_creator));

            $this->fail();
        }


        
        // $batchId = null;

        // if($this->batch()) $batchId = $this->batch()->id;

        // $user_name = $this->user_to_delete->getFullName(true) . "(" . $this->user_to_delete->email . ")";

        // $data = [
        //     'batch_id' => $batchId,
        //     'job_id' => $this->job?->uuid(),
        //     'job_class' => static::class,
        //     'status' => 'ok',
        //     'report' => "Le compte de {$user_name} a été supprimé",
        //     'payload' => $this->job?->payload(),
        // ];

        // JobResportsService::generatejobReport($data);
    }
}
