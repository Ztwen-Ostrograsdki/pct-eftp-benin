<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitNewMemberPaymentEvent;
use App\Models\Cotisation;
use App\Models\Member;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

class MemberPaymentsModalManager extends Component
{
    use Toast;

    public $modal_name = "#members-payments-modal-manager";

    public $member;

    public $member_id;

    public $cotisation_id;

    public $cotisation;

    public $amount;

    public $payment_date;

    public $description;

    public $month;

    public $year;

    public $counter = 2;


    public function render()
    {
        $members = Member::all();

        $months = getMonths();

        $years = getYears();

        
        return view('livewire.master.modals.member-payments-modal-manager', compact('members', 'years', 'months'));
    }

    #[On('OpenMemberPaymentsManagerModalEvent')]
    public function openModal($member_id = null, $cotisation_id = null, $options = [])
    {

        $this->reset();

        if($options){

            if(isset($options['month'])){

                if($options['month']) $this->month = $options['month'];

            }

            if(isset($options['year'])){

                if($options['year']) $this->year = $options['year'];


            }
        }

        if($member_id || $cotisation_id){

            if($cotisation_id){

                $cotisation = Cotisation::find($cotisation_id);

                if($cotisation){

                    $this->member_id = $cotisation->member_id;

                    $this->cotisation_id = $cotisation->member_id;

                    $this->amount = $cotisation->amount;

                    $this->month = $cotisation->month;

                    $this->year = $cotisation->year;

                    $this->description = $cotisation->description;

                    $this->payment_date = Carbon::parse($cotisation->payment_date)->format("Y-m-d");

                    $this->member = $cotisation->member;

                    $this->cotisation = $cotisation;

                    $this->dispatch('OpenModalEvent', $this->modal_name);
                }

            }
            elseif($member_id){

                $member = Member::find($member_id);

                if($member){

                    $this->member = $member;

                    $this->member_id = $member_id;

                    $this->dispatch('OpenModalEvent', $this->modal_name);
                }

            }
        }
        else{

            $this->month = getCurrentMonth();

            $this->year = date('Y');

            $this->payment_date = Carbon::today()->format("Y-m-d");

            $this->dispatch('OpenModalEvent', $this->modal_name);
        }

        
        
    }


    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }


    public function insert()
    {
        $admin = auth_user();

        $validated = $this->validate([
            'member_id' => "required",
            'month' => "required",
            'year' => "required",
            'payment_date' => "required|date",
            'amount' => "required|numeric",
        ]);

        $data = [
            'member_id' => $this->member_id,
            'month' => $this->month,
            'year' => $this->year,
            'payment_date' => $this->payment_date,
            'amount' => $this->amount,
            'description' => $this->description,
            'user_id' => $admin->id,
        ];

        $member = Member::find($this->member_id);

        $name = $member->user->getFullName();

        if(!$this->cotisation){

            InitNewMemberPaymentEvent::dispatch($admin, $data, $member, null);

            self::hideModal();

            Notification::sendNow([$admin], new RealTimeNotificationGetToUser("L'enregistrement du payement de {$name} à été lancé!"));

            $this->reset();

        }
        else{

            InitNewMemberPaymentEvent::dispatch($admin, $data, $member, $this->cotisation);

            self::hideModal();

            Notification::sendNow([$admin], new RealTimeNotificationGetToUser("La de mise à jour du payement de {$name} à été lancée!"));

            $this->reset();

            
        }
    }
}
