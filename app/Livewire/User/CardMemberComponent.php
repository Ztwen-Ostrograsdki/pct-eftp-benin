<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitMemberCardSchemaEvent;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Browsershot\Browsershot;

class CardMemberComponent extends Component
{

    use Toast, Confirm;

    public $identifiant;

    public $member_id;

    public $member;

    public $card_number;

    public $expired_at;


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

                $card_number = date('Y') . '' . random_int(10000002, 999999999999);

                $qrcode = QrCode::size(80)->generate('ID:' . $user->identifiant . '@Tel:' . $user->contacts . 'N°:' . $card_number);

                

            }

        }
        return view('livewire.user.card-member-component', compact('user', 'qrcode', 'card_number'));
    }

    public function sendCardToMember($member_id)
    {
        
    }


    public function generateCardMember($id)
    {

        $member = Member::find($id);

        $key = Str::random(4);

        $admin_generator = auth_user();

        InitMemberCardSchemaEvent::dispatch($member, $key, $admin_generator);
    }

    public function __f_generateCardMember($id)
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
            'card_number' => $this->card_number

        ];

        $html = View::make('pdftemplates.card', $data)->render();

        $rand = random_int(13136636, 89999938872);

        $pdfPath = storage_path("app/public/carte-de-membre-{$rand}-{$user->identifiant}.pdf");

        // ini_set("max_execution_time", 45);

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


    

    
}
