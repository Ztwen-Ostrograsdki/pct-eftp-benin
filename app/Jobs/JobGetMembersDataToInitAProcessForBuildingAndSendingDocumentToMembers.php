<?php

namespace App\Jobs;

use App\Events\InitProcessToGenerateAndSendDocumentToMemberEvent;
use App\Models\Member;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

class JobGetMembersDataToInitAProcessForBuildingAndSendingDocumentToMembers implements ShouldQueue
{
    use Queueable;

    public array $data = [];

    public array $receivers = []; //array of users

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $members,
        public ?User $admin_generator,
        public $view_path,
        public ?array $complements = []
    )
    {
        $this->members = $members;

        $this->admin_generator = $admin_generator;

        $this->complements = $complements;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        self::getMembersData();

        if($this->data && $this->receivers && $this->view_path){

            InitProcessToGenerateAndSendDocumentToMemberEvent::dispatch($this->view_path, $this->data, $this->receivers, true, $this->admin_generator);

        }
        else{

            Notification::sendNow([$this->admin_generator], new RealTimeNotificationGetToUser("Une erreure s'est produite!"));
        }
    }


    protected function getMembersData()
    {
        $data = [];

        $users = [];

        $members_ids = $this->members;

        $members = Member::whereIn('id', $members_ids)->get();

        $year = $this->complements['year'];

        $default_pdf_path = $this->complements['pdf_path'];

        $default_document_title = $this->complements['document_title'];

        foreach($members as $member){

            if($member){

                $user = $member->user;

                $name = $user->getFullName();

                $total_amount = $member->getTotalCotisationOfYear($year);


                $pdfPath = str_replace('NOM-DU-MEMBRE', str_replace(' ', '-', $name), $default_pdf_path);

                $document_title = str_replace('NOM-DU-MEMBRE', str_replace(' ', '-', $name), $default_document_title);

                $data[$user->id] = [
                    'data' => [
                        'member' => $member, 
                        'months' => getMonths(),
                        'the_year' => $year,
                        'total_amount' => $total_amount,
                        'name' => $name,
                        'document_title' => $document_title,
                    ],
                    'document_path' => $pdfPath,
                ];

                $users[] = $member->user;
            }
            
        }

        $this->receivers = $users;

        $this->data = $data;
    }
}
