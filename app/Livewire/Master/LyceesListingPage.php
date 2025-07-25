<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\NewLyceeCreatedSuccessfullyEvent;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Helpers\Tools\RobotsBeninHelpers;
use App\Helpers\Tools\SpatieManager;
use App\Jobs\JobToGenerateDefaultUserMember;
use App\Models\Lycee;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\On;
use Livewire\Component;

class LyceesListingPage extends Component
{
    use Toast, Confirm, ListenToEchoEventsTrait;

    public $counter = 6;

    public $selected_lycee_id = null;

    public $selected_lycee = null;

    public $selected_department = null;

    public function render()
    {

        $departments = RobotsBeninHelpers::getDepartments();

        $selected_lycee = null;

        $filiars = [];

        $promotions = [];

        $has_lycee = Lycee::all()->count() > 0;

        if($has_lycee){

            if(session()->has('selected_lycee_profil')){

                $this->selected_lycee_id = session('selected_lycee_profil');

                $selected_lycee = Lycee::find($this->selected_lycee_id);

                if(!$selected_lycee){

                    $this->reset('selected_lycee', 'selected_lycee_id');

                }
                
            }

            if($this->selected_lycee_id){

                $selected_lycee = Lycee::find($this->selected_lycee_id);

                $filiars = $selected_lycee->getFiliars();

                $promotions = $selected_lycee->getPromotions();

                $this->selected_lycee = $selected_lycee;
            }

            $lycees = [];

            if(session()->has('selected_department_lycee_profil')){

                $this->selected_department = session('selected_department_lycee_profil');

            }

            if($this->selected_department){

                $lycees = Lycee::where('lycees.department', $this->selected_department)->get();

            }
            else{

                $lycees = Lycee::all();

            }
        }
        else{

            $lycees = Lycee::all();

        }
        
        return view('livewire.master.lycees-listing-page', [
            'lycees' => $lycees,
            'departments' => $departments,
            'filiars' => $filiars,
            'promotions' => $promotions,
            
        ]);
    }

    public function removeImageFromImagesOf($image_path, $lycee_id = null)
    {
        SpatieManager::ensureThatUserCan(['lycees-manager']);

        if($image_path){

            $lycee = $this->selected_lycee;

            $images = (array)$lycee->images;

            if(in_array($image_path, $images)){

                $image_key = array_keys($images, $image_path)[0];

                $path = storage_path().'/app/public/' . $image_path;

                $deleted = File::delete($path);

                if($deleted){

                    unset($images[$image_key]);

                    $images = array_values($images); 

                    $updated = $lycee->update(['images' => $images]);

                    if($updated) $this->toast( "L'image a été retirée avec succès!", 'success');

                    $this->counter = getRand();
                }

            }
        }
    }

    public function manageLyceeFiliars()
    {

        SpatieManager::ensureThatUserCan(['lycees-manager']);

        $lycee_id = $this->selected_lycee_id;

        $this->dispatch('ManageLyceeFiliars', $lycee_id);
    }

    public function manageLyceeData()
    {
        SpatieManager::ensureThatUserCan(['lycees-manager']);

        $lycee_id = $this->selected_lycee_id;

        $this->dispatch('ManageLyceeData', $lycee_id);
    }


    public function addNewLycee()
    {

        SpatieManager::ensureThatUserCan(['lycees-manager']);

        $this->dispatch('AddNewLyceeEvent');
    }

    public function manageLyceePromotions()
    {

        SpatieManager::ensureThatUserCan(['lycees-manager']);

        $lycee_id = $this->selected_lycee_id;

        $this->dispatch('ManageLyceePromotions', $lycee_id);
    }


    public function deleteLycee()
    {

        SpatieManager::ensureThatUserCan(['lycees-manager']);

        $lycee = $this->selected_lycee;

        if($lycee){

            $name = $lycee->name;

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de supprimer le lycée: 
                                <span class='text-sky-400 letter-spacing-2 font-semibold'> {$name} </span>
                                de la liste des lycées enregistrés dans la base de données!
                            </p>
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

            $options = ['event' => 'confirmedLyceeDeletion', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['lycee_id' => $lycee->id]];

            $this->confirm($html, $noback, $options);
            
        }

    }

    #[On('confirmedLyceeDeletion')]
    public function onConfirmedLyceeDeletion($data)
    {
        if($data){

            $lycee_id = $data['lycee_id'];

            $lycee = Lycee::find($lycee_id);

            if($lycee){

                $deleted = $lycee->delete();

                if($deleted){

                    NewLyceeCreatedSuccessfullyEvent::dispatch();

                    $this->toast( "Le lycée a été supprimé avec succès!", 'success');

                }
            }
            else{

                $this->toast( "La suppression a échoué! Veuillez réessayer!", 'error');
            }

        }

    }


    public function updatedSelectedDepartment($department)
    {

        session()->put('selected_department_lycee_profil', $department);

        if($this->selected_lycee){

            if($this->selected_lycee->department !== $department){

                session()->forget('selected_lycee_profil');

                $this->reset('selected_lycee', 'selected_lycee_id');

            }

        }
        else{

            $this->reset('selected_lycee', 'selected_lycee_id');

            session()->forget('selected_lycee_profil');
        }

    }

    public function manageLyceeImages()
    {
        SpatieManager::ensureThatUserCan(['lycees-manager']);
        
        if($this->selected_lycee_id){

            $this->dispatch("ManageLyceeImagesEvent", $this->selected_lycee_id);

        }
    }


    public function updatedSelectedLyceeId($selected_lycee_id)
    {
        if($selected_lycee_id){

            session()->put('selected_lycee_profil', $selected_lycee_id);
        }
        else{

            session()->forget('selected_lycee_profil');
        }
    }


    #[On('LiveNewLyceeCreatedSuccessfullyEvent')]
    public function reloadData($data = null)
    {
        $this->counter = getRand();
    }
    
    #[On('LyceeDataUpdatedLiveEvent')]
    public function reloadLyceeData($data = null)
    {
        $this->counter = getRand();
    }
}
