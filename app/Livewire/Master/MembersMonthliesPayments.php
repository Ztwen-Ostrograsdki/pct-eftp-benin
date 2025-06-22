<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitPDFGeneratorEvent;
use App\Events\InitProcessToGenerateAndSendDocumentToMemberEvent;
use App\Helpers\Tools\SpatieManager;
use App\Jobs\JobGetMembersDataToInitAProcessForBuildingAndSendingDocumentToMembers;
use App\Models\Cotisation;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class MembersMonthliesPayments extends Component
{

    use Toast, Confirm, WithPagination;

    public $display_select_cases = false;

    public $selected_year;

    public $selected_month;

    public $printingData = [];

    public $counter = 0;

    public $all_year = 3000000;

    public $search = '';

    public $selected_members = [];


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

        $members = [];

        $payment_data = [];

        $cotisations = Cotisation::all();

        $users = User::orderBy('firstname', 'asc')->orderBy('lastname', 'asc')->get();

        $yearly_payments = [];

        foreach($users as $user){

            $members[] = $user->member;


        }

        if($this->selected_month){

            foreach($members as $member){

                $cotisation = Cotisation::where('member_id', $member->id)->where('month', $this->selected_month);

                if($this->selected_year){

                    if($this->selected_year == null){

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

            if($this->selected_year){


                foreach($members as $member){

                    $member_id = $member->id;

                    $member_yearly_payments = Cotisation::where('member_id', $member_id)->where('year', $this->selected_year)->pluck('amount')->toArray();

                    if($member_yearly_payments){

                        $yearly_payments[$member_id] = [
                            'total' => array_sum($member_yearly_payments), 
                            'payments_done' => count($member_yearly_payments)
                        ];


                    }
                    else{

                        $yearly_payments[$member_id] = [
                            'total' => 0,
                            'payments_done' => 'Aucun payement effectué'
                        ];
                    }

                }

            }

            $payment_data = $init_data;

        }

        if($this->selected_month && $this->selected_year && $yearly_payments == []){

            $this->printingData = $payment_data;
        }
        elseif(!$this->selected_month && $this->selected_year){

            $this->printingData = $yearly_payments;
        }

        

        return view('livewire.master.members-monthlies-payments', 
            compact('months', 'cotisations', 'members', 'payment_data', 'yearly_payments')
        );
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
        
        $cotisation = Cotisation::find($cotisation_id);

        if($cotisation){

            $this->dispatch('OpenMemberPaymentsManagerModalEvent', $cotisation->member_id, $cotisation_id);

        }
    }

    public function pushOrRetrieveFromSelectedMembers($id)
    {
        $selecteds = $this->selected_members;

        if(!in_array($id, $selecteds)){

            $selecteds[$id] = $id;
        }
        elseif(in_array($id, $selecteds)){

            unset($selecteds[$id]);
        }

        $this->resetErrorBag();

        $this->selected_members = $selecteds;
    }


    public function toggleSelectAll()
    {
        $selecteds = $this->selected_members;

        $members = getMembers();

        if((count($selecteds) > 0 && count($selecteds) < count($members)) || count($selecteds) == 0){

            foreach($members as $member){

                if(!in_array($member->id, $selecteds)){

                    $selecteds[$member->id] = $member->id;
                }

            }

        }
        else{

            $selecteds = [];

        }

        $this->selected_members = $selecteds;
    }

    public function toggleSelectionsCases()
    {
        return $this->display_select_cases = !$this->display_select_cases;
    }

    

    public function updatedSelectedMembers()
    {

    }

    public function generateAndSendDetailsToMember($member_id)
    {
        SpatieManager::ensureThatUserCan(['cotisations-manager']);

        $admin = auth_user();

        $member = findMember($member_id);

        $data = [];

        if($member){

            $user = $member->user;

            $year = $this->selected_year;

            $name = $user->getFullName();

            $total_amount = $member->getTotalCotisationOfYear($year);

            $root = storage_path("app/public/cotisations/membres/". $year);

            if(!File::isDirectory($root)){

                $directory_make = File::makeDirectory($root, 0777, true, true);

            }

            if(!File::isDirectory($root) && !$directory_make){

                Notification::sendNow([auth_user()], new RealTimeNotificationGetToUser("Erreure stockage: La destination de sauvegarde est introuvable"));

            }

            $pdfPath = storage_path("app/public/cotisations/membres/". $year . "/Fiches-de-cotisation-membre-de-". $name . '-de-' . $year . '.pdf');

            $document_title = "FICHE DE COTISATION DE $name DE $year";

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

            $view_path = "pdftemplates.once-member-cotisation";

            InitProcessToGenerateAndSendDocumentToMemberEvent::dispatch($view_path, $data, [$user], true, $admin);


        }
    }




    
    public function addMemberPayment($member_id)
    {
        SpatieManager::ensureThatUserCan(['cotisations-manager']);

        $options = [];

        if($this->selected_month) $options['month'] = $this->selected_month;

        if($this->selected_year && $this->selected_year != $this->all_year) $options['year'] = $this->selected_year;

        $this->dispatch('OpenMemberPaymentsManagerModalEvent', $member_id, null, $options);
    }

    public function buildAndSendToMembersByMail()
    {

        SpatieManager::ensureThatUserCan(['cotisations-manager']);

        $members = $this->selected_members;

        $date = $this->selected_month . ' ' . $this->selected_year;

        if(count($members) == 0){

            $members = getMembers();
        }

        $total = count($members);

        $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                        <p> Vous êtes sur le point de générer et d'envoyer la fiche des détails de cotisations individuelles à {$total} membre(s) </p>
                        
                </h6>";

        $options = ['event' => 'confirmBuildAndSendToMembersByMail', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé'];

        $this->confirm($html, '', $options);

    }

    #[On('confirmBuildAndSendToMembersByMail')]
    public function onConfirmBuildAndSendToMembersByMail($data = [])
    {
        $members = $this->selected_members;

        $admin_generator = auth_user();

        $view_path = "pdftemplates.once-member-cotisation";

        $year = $this->selected_year;

        $root = storage_path("app/public/cotisations/membres/". $year);

        if(!File::isDirectory($root)){

            $directory_make = File::makeDirectory($root, 0777, true, true);

        }

        if(!File::isDirectory($root) && !$directory_make){

            Notification::sendNow([auth_user()], new RealTimeNotificationGetToUser("Erreure stockage: La destination de sauvegarde est introuvable"));

        }

        $default_pdf_path = storage_path("app/public/cotisations/membres/". $year . "/Fiches-de-cotisation-membre-de-NOM-DU-MEMBRE-de-" . $year . ".pdf");

        $default_document_title = "FICHE DE COTISATION DE NOM-DU-MEMBRE DE $year";

        $data = [
            'root' => $root,
            'pdf_path' => $default_pdf_path,
            'document_title' => $default_document_title,
            'year' => $year,
        ];

        if($members){

            JobGetMembersDataToInitAProcessForBuildingAndSendingDocumentToMembers::dispatch($members, $admin_generator, $view_path, $data);

            $this->toast( "Le processus  a été lancé avec succès!", 'success');

        }
        else{

            $this->toast( "Le processus a échoué! Veuillez réessayer!", 'error');
        }

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

    public function printMembersCotisations()
    {
        SpatieManager::ensureThatUserCan(['cotisations-manager']);

        $month = $this->selected_month;

        $year = $this->selected_year;

        $total_amount = 0;

        foreach($this->printingData as $d){

            if($month){
                if($d && isset($d->amount)){

                    $total_amount = $total_amount + $d->amount;
                }
            }
            else{

                if($d && isset($d['total'])){

                    $total_amount = $total_amount + $d['total'];
                }
            }
        }

        if($year && $month){

            $root = storage_path("app/public/cotisations/membres/". $month . '-' . $year);

            if(!File::isDirectory($root)){

                $directory_make = File::makeDirectory($root, 0777, true, true);

            }

            if(!File::isDirectory($root) && !$directory_make){

                Notification::sendNow([auth_user()], new RealTimeNotificationGetToUser("Erreure stockage: La destination de sauvegarde est introuvable"));

            }

            $pdfPath = storage_path("app/public/cotisations/membres/" . $year . "/cotisation-de-membre-de-". $month . '-' . $year . '.pdf');

            $document_title = "FICHE DE COTISATION DE $month $year";

            $data = [
                'payment_data' => $this->printingData, 
                'the_month' => $month,
                'the_year' => $year,
                'total_amount' => $total_amount,
                'document_title' => $document_title,
            ];

        }
        elseif($year && !$month){

            $root = storage_path("app/public/cotisations/membres/annuelles" . $year);

            if(!File::isDirectory($root)){

                $directory_make = File::makeDirectory($root, 0777, true, true);

            }

            if(!File::isDirectory($root) && !$directory_make){

                Notification::sendNow([auth_user()], new RealTimeNotificationGetToUser("Erreure stockage: La destination de sauvegarde est introuvable"));

            }

            $pdfPath = storage_path("app/public/cotisations/membres/" . $year . "/cotisation-annuelle-de-membres-de-" . $year . '.pdf');

            $document_title = "FICHE DE COTISATION ANNUELLES DES MEMBRES DE $year";

            $data = [
                'payment_data' => $this->printingData, 
                'the_month' => $month,
                'the_year' => $year,
                'total_amount' => $total_amount,
                'document_title' => $document_title,
                'yearly_payments' => $this->printingData
            ];
        }

        $view_path = "pdftemplates.members-cotisation";

        InitPDFGeneratorEvent::dispatch($view_path, $data, $pdfPath, null, true, auth_user());

        Notification::sendNow([auth_user()], new RealTimeNotificationGetToUser("La procédure est lancée!"));
    }

    
}
