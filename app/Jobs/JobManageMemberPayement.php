<?php

namespace App\Jobs;

use App\Models\Cotisation;
use App\Models\Member;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class JobManageMemberPayement implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $admin,
        public array $data,
        public Member $member,
        public ?Cotisation $cotisation = null,
    )
    {
        $this->admin = $admin;

        $this->data = $data;

        $this->member = $member;

        $this->cotisation = $cotisation;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if(!$this->cotisation){

            // Creation d'une nouvelle cotisation

            Cotisation::create($this->data);
        }
        else{

            $this->cotisation->update($this->data);

            // Mise à jour d'une cotisation déjà enregistrée

        }
    }
}
