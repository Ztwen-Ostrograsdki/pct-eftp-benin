<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitPDFGeneratorEvent;
use App\Helpers\Tools\SpatieManager;
use App\Models\Cotisation;
use App\Models\Member;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
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
        SpatieManager::ensureThatUserCan(['cotisations-manager']);

        $this->dispatch('OpenMemberPaymentsManagerModalEvent', $member_id, $payment_id);
    }

    #[On('LiveMemberPaymentRequestCompletedEvent')]
    public function reloadData()
    {
        $this->counter = getRand();
    }

    public function editMemberPayment($cotisation_id)
    {
        SpatieManager::ensureThatUserCan(['cotisations-manager']);

        if(!__isAdminAs()) return false;

        $cotisation = Cotisation::find($cotisation_id);

        if($cotisation){

            $this->dispatch('OpenMemberPaymentsManagerModalEvent', $cotisation->member_id, $cotisation_id);

        }
    }
    
    public function addMemberPayment($month = null)
    {
        SpatieManager::ensureThatUserCan(['cotisations-manager']);

        $options = [];

        if($month) $options['month'] = $month;

        if($this->selected_year && $this->selected_year != $this->all_year) $options['year'] = $this->selected_year;

        $this->dispatch('OpenMemberPaymentsManagerModalEvent', $this->member->id, null, $options);
    }

    public function deleteMemberPayment($cotisation_id)
    {
        SpatieManager::ensureThatUserCan(['cotisations-manager']);
        
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

    public function printMemberCotisations()
    {

        $year = $this->selected_year;

        $name = $this->member->user->getFullName();

        $total_amount = $this->member->getTotalCotisationOfYear($year);

        $root = storage_path("app/public/cotisations/membres/". $year);

        if(!File::isDirectory($root)){

            $directory_make = File::makeDirectory($root, 0777, true, true);

        }

        if(!File::isDirectory($root) && !$directory_make){

            Notification::sendNow([auth_user()], new RealTimeNotificationGetToUser("Erreure stockage: La destination de sauvegarde est introuvable"));

        }

        $pdfPath = storage_path("app/public/cotisations/membres/". $year . "/Fiches-de-cotisation-membre-de-". $name . '-de-' . $year . '.pdf');

        $document_title = "FICHE DE COTISATION DE $name DE $year";

        $data = [
            'member' => $this->member, 
            'months' => getMonths(),
            'the_year' => $year,
            'total_amount' => $total_amount,
            'name' => $name,
            'document_title' => $document_title,
        ];

        $view_path = "pdftemplates.once-member-cotisation";

        InitPDFGeneratorEvent::dispatch($view_path, $data, $pdfPath, auth_user());

        Notification::sendNow([auth_user()], new RealTimeNotificationGetToUser("La procédure est lancée!"));
    }

}
