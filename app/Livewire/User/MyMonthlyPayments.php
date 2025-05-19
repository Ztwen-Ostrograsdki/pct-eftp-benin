<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitPDFGeneratorEvent;
use App\Models\Cotisation;
use App\Models\Member;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class MyMonthlyPayments extends Component
{

    use Toast, Confirm, WithPagination;

    public $selected_year;

    public $user;

    public $member;

    public $printingData = [];

    public $counter = 0;

    public $all_year = 3000000000000000;

    public $search = '';


    public function mount($identifiant)
    {
        if($identifiant){

            $user = getUser($identifiant, 'identifiant');

            if($user){

                $this->user = $user;

                if($user->member) 

                    $this->member = $user->member;

                else 
                    return abort(403, "Accès non authorisé");
            }

            if(!$user) return abort(404, "La page est introuvable");
        }
        if(session()->has('selected_year_for_user_cotisation')){

            $this->selected_year = session('selected_year_for_user_cotisation');

        }
        elseif($this->selected_year == null){

            $this->selected_year = date('Y');
        }

    }
    
    public function render()
    {
        $months = getMonths();

        return view('livewire.user.my-monthly-payments', compact('months'));
    }

    public function updatedSelectedYear($selected_year)
    {
        $this->selected_year = $selected_year;

        session()->put('selected_year_for_user_cotisation', $selected_year);
    }


    public function memberPaymentsManager($member_id = null, $payment_id = null)
    {
        $this->dispatch('OpenMemberPaymentsManagerModalEvent', $member_id, $payment_id);
    }

    #[On('LiveMemberPaymentRequestCompletedEvent')]
    public function reloadData()
    {
        $this->counter = getRand();
    }

    public function editMemberPayment($cotisation_id)
    {
        
        $cotisation = Cotisation::find($cotisation_id);

        if($cotisation){

            $this->dispatch('OpenMemberPaymentsManagerModalEvent', $cotisation->member_id, $cotisation_id);

        }
    }
    
    public function addMemberPayment($member_id)
    {
        $options = [];

        if($this->selected_month) $options['month'] = $this->selected_month;

        if($this->selected_year && $this->selected_year != $this->all_year) $options['year'] = $this->selected_year;

        $this->dispatch('OpenMemberPaymentsManagerModalEvent', $member_id, null, $options);
    }

    public function deleteMemberPayment($cotisation_id)
    {

        $cotisation = Cotisation::find($cotisation_id);

        if($cotisation){

            $name = $cotisation->member->user->getFullName();

            $date = $cotisation->month . ' ' . $cotisation->year;

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de supprimer la cotisation de {$date} enregistrée sous le nom de : </p>
                            <p class='text-sky-400 letter-spacing-2 p-0 m-0 font-semibold'> $name </p>
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

            $options = ['event' => 'confirmedCotisationDeletion', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['cotisation_id' => $cotisation_id]];

            $this->confirm($html, $noback, $options);
            
        }

    }

    #[On('confirmedCotisationDeletion')]
    public function onConfirmationCotisationDeletion($data)
    {
        if($data){

            $cotisation_id = $data['cotisation_id'];

            $cotisation = Cotisation::find($cotisation_id);

            if($cotisation){

                $cotisation->delete();

                $this->toast( "La cotisation enregistrée  a été supprimée avec succès!", 'success');

            }
            else{

                $this->toast( "La suppression a échoué! Veuillez réessayer!", 'error');
            }

        }

    }

    public function printMembersCotisations()
    {

        $month = $this->selected_month;

        $year = $this->selected_year;

        $print_date = __formatDateTime(Carbon::now());

        $total_amount = 0;

        foreach($this->printingData as $d){

            if($d && isset($d->amount)){

                $total_amount = $total_amount + $d->amount;
            }
        }

        $pdfPath = storage_path("app/public/cotisation-de-membre-de-". $month . '-' . $year . '-' . time() . '.pdf');

        $data = [
            'payment_data' => $this->printingData, 
            'the_month' => $month,
            'the_year' => $year,
            'total_amount' => $total_amount,
            'print_date' => $print_date,
        ];

        $view_path = "pdftemplates.members-cotisation";

        InitPDFGeneratorEvent::dispatch($view_path, $data, $pdfPath, auth_user());

        Notification::sendNow([auth_user()], new RealTimeNotificationGetToUser("La procédure est lancée!"));
    }

}
