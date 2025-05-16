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
use Illuminate\Support\Str;

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
        return view('livewire.user.card-member-component', compact('user'));
    }

    public function sendCardToMember($member_id)
    {
        
    }

    public function generateCardMember($id)
    {
        $member = Member::find($id);

        $user = $member->user;

        $data = [
            'name' => $user->getFullName(),
            'reverse_name' => $user->getFullName(true),
            'email' =>  $user->email,
            'identifiant' =>  $user->identifiant,
            'address' =>  Str::upper($user->address),
            'role' =>  $member->role->name,
            'photo' =>  user_profil_photo($user),
            'contacts' =>  $user->contacts,

        ];

        $html = View::make('pdftemplates.card', $data)->render();

        $rand = random_int(13136636, 89999938872);

        $pdfPath = storage_path("app/public/carte-de-membre-{$rand}-{$user->identifiant}.pdf");

        

        ini_set("max_execution_time", 45);

        Browsershot::html($html)
            ->setNodeBinary('C:\Program Files\nodejs\node.exe')
            ->setNpmBinary('C:\Program Files\nodejs\npm.cmd')
            ->setIncludePath(public_path('build/assets'))
            ->showBackground()
            ->waitUntilNetworkIdle()
            ->ignoreHttpsErrors()
            ->format('A4')
            ->margins(15, 15, 15, 15)
            ->timeout(120)
            ->save($pdfPath);

        return response()->download($pdfPath);
    }


    public function ttgenerateCardMember($member_id = null)
    {
        $htmlContent = View::make('livewire.user.my-card')->render();
    
        // Generate PDF with Browsershot
        $pdfPath =  public_path().'/app/public/users/membre.pdf';

        // $pdf = Browsershot::html($htmlContent)
        //     ->format('A4')
        //     ->margins(10, 10, 10, 10)
        //     ->save("membre3.pdf");

        Browsershot::html($htmlContent)->ignoreHttpsErrors()->waitUntilNetworkIdle()
                                       ->showBackground()
                                       ->setOption('addStyleTag', json_encode(['path' => asset('css/card.css')]))
                                       ->margins(5, 5, 5, 5)
                                       ->save("ma-carte.pdf");

            


        
    }

    public function generattorCardMember($member_id)
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
