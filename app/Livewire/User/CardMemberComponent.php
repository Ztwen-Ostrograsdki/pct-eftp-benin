<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;

class CardMemberComponent extends Component
{

    use Toast, Confirm;

    public $identifiant;

    public $member_id;

    public $member;



    public function mount($identifiant)
    {
        if($identifiant){

            $this->identifiant = $identifiant;

        }
        else{

            return abort(404);

        }
    }


    public function render()
    {
        if($this->identifiant){

            $user = User::where('identifiant', $this->identifiant)->first();

            if($user && $user->member){

                $this->member = $user->member; 

                $this->member_id = $user->member->id; 

            }

        }
        return view('livewire.user.card-member-component');
    }

    public function sendCardToMember($member_id)
    {
        
    }

    public function generateCardMember($member_id)
    {
        // Retrieve the order by ID
        $member = Member::find($member_id);

        if($member){

            $user = $member->user;

            $identifiant = $user->identifiant;

            $time = Carbon::now()->timestamp;

            ini_set("max_execution_time", 120);

            // Pass data to the view
            $htmlContent = View::make('livewire.user.card-module', compact('member', 'identifiant'))->render();
    
            // Generate PDF with Browsershot
            $pdfPath =  public_path().'/app/public/users/membre.pdf';

            $pdf = Browsershot::html($htmlContent)
                ->format('A4')
                ->margins(10, 10, 10, 10)
                ->pdf();


            Storage::put('users/membre.pdf', $pdf, ['disk' => "public"]);
    
            //return response()->download($pdfPath);
        }
 
        
    }
}
