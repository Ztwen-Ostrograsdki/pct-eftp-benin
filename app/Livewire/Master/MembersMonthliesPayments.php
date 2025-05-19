<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitPDFGeneratorEvent;
use App\Models\Cotisation;
use App\Models\Member;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Browsershot\Browsershot;

class MembersMonthliesPayments extends Component
{

    use Toast, Confirm, WithPagination;

    public $selected_year;

    public $selected_month;

    public $printingData = [];

    public $counter = 0;

    public $all_year = 3000000000000000;

    public $search = '';


    public function mount()
    {
        if(session()->has('selected_year_for_admin_cotisation')){

            $this->selected_year = session('selected_year_for_admin_cotisation');

        }
        elseif($this->selected_year == null){

            $this->selected_year = date('Y');
        }

        if(session()->has('selected_month_for_admin_cotisation')){

            $this->selected_month = session('selected_month_for_admin_cotisation');

        }
        elseif($this->selected_month == null){

            $this->selected_month = getCurrentMonth();
        }
    }
    
    public function render()
    {
        $months = getMonths();

        $payment_data = [];

        $cotisations = Cotisation::all();

        $members = Member::all();

        if($this->selected_month){

            foreach($members as $member){

                $cotisation = Cotisation::where('member_id', $member->id)->where('month', $this->selected_month);

                if($this->selected_year){

                    if($this->selected_year == $this->all_year){

                        foreach($cotisation->get() as $ct){

                            if($ct){

                                $payment_data[$member->id] = $ct;
                            }
                            else{
                                $payment_data[$member->id] = null;
                            }

                        }
                    }
                    else{

                        $c = $cotisation->where('year', $this->selected_year)->first();

                        if($c){

                            $payment_data[$member->id] = $c;
                        }
                        else{
                            $payment_data[$member->id] = null;
                        }

                    }

                }
                else{

                    foreach($cotisation->get() as $cta){

                        if($cta){

                            $payment_data[$member->id] = $cta;
                        }
                        else{
                            $payment_data[$member->id] = null;
                        }

                    }


                }

            }


        }
        else{

            $init_data = [];

            if($this->selected_year == $this->all_year){

                $payment_data = $cotisations;

            }
            else{

                $payment_data = Cotisation::where('year', $this->selected_year)->get();
            }

            foreach($cotisations as $cta){

                if($cta){

                    $init_data[$cta->member_id] = $cta;
                }
            }

            $payment_data = $init_data;

        }

        $this->printingData = $payment_data;

        

        return view('livewire.master.members-monthlies-payments', compact('months', 'cotisations', 'members', 'payment_data'));
    }

    public function updatedSelectedYear($selected_year)
    {
        $this->selected_year = $selected_year;

        session()->put('selected_year_for_admin_cotisation', $selected_year);
    }

     public function updatedSelectedMonth($selected_month)
    {
        $this->selected_month = $selected_month;

        session()->put('selected_month_for_admin_cotisation', $selected_month);
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
