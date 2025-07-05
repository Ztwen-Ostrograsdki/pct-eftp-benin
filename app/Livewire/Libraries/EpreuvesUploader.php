<?php

namespace App\Livewire\Libraries;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitEpreuveCreationEvent;
use App\Helpers\Tools\RobotsBeninHelpers;
use App\Models\Lycee;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title("Publier une épreuve")]
class EpreuvesUploader extends Component
{
    use WithFileUploads, Toast, Confirm;
    
    public $uploaded_completed = false;
    
    public $counter = 0;

    public $name;

    public $selecteds = [];

    public $description;

    public $author;

    public $file_epreuve;

    public $path;

    public $year;

    public $images;

    public $contents_titles;

    public $filiars_ids = [];

    public $promotion_id;

    public $lycee_id;

    public $user_id;

    public $epreuve_type;

    public $exam_type = null;

    public $is_exam = false;

    public $exam_department = null; 

    public $exam_session = 'normal';

    public function mount($type)
    {
        if($type) $this->epreuve_type = $type;

        if($type !== 'simple' && ($type !== 'examen')){

            return abort(404);
        }

        if(auth_user()) $this->author = auth_user_fullName();

    }

    public function render()
    {
        $filiars = getFiliars();

        $classes = getClasses();

        $promotions = getPromotions();

        $types = config('app.examen_types');

        $departments = RobotsBeninHelpers::getDepartments();

        $lycees = Lycee::all();

        if(!$this->year) $this->year = date('Y');

        return view('livewire.libraries.epreuves-uploader', [
            'classes' => $classes,
            'filiars' => $filiars,
            'promotions' => $promotions,
            'types' => $types,
            'departments' => $departments,
            'lycees' => $lycees,
        ]);
    }

    public function updatedDescription($description)
    {
        $this->resetErrorBag();
    }

    public function updatedContentsTitles($contents_titles)
    {
        $this->resetErrorBag();
    }

    public function updatedFileEpreuve($file)
    {
        $this->resetErrorBag();
    }
    
    public function updatedLyceeId($id)
    {
        $this->resetErrorBag();
    }

    public function updatedExamSession($exam_session)
    {
        $this->resetErrorBag();
    }

    public function updatedExamType($type)
    {
        $this->resetErrorBag();
    }

    public function pushIntoSelecteds($id)
    {
        $tables = [];

        $selecteds = $this->selecteds;

        if(!in_array($id, $selecteds)){

            $selecteds[$id] = $id;
        }

        $this->resetErrorBag();

        $this->selecteds = $selecteds;
    }

    public function retrieveFromSelecteds($id)
    {
        $tables = [];

        $this->resetErrorBag();

        $selecteds = $this->selecteds;

        if(in_array($id, $selecteds)){

            unset($selecteds[$id]);
        }

        $this->selecteds = $selecteds;
    }

    public function uploadEpreuve()
    {
        
        $this->resetErrorBag();

        $this->filiars_ids = $this->selecteds;

        $filiars = [];

        if($this->epreuve_type !== 'examen' && !$this->name) $this->name = 'epreuve-' . Str::lower(Str::random(8));

        if($this->epreuve_type == 'examen' && !$this->name) $this->name = 'Examen-';
        
        if($this->epreuve_type == 'simple'){

            $this->validate([
                'contents_titles' => 'required|string',
                'file_epreuve' => 'required|file|mimes:docx,pdf|max:8000',
                'filiars_ids' => 'required',
                'promotion_id' => 'required',
                'name' => 'string|max:60',
            ]);
        }
        elseif($this->epreuve_type == 'examen'){

            $this->is_exam = true;

            if($this->exam_session == 'normal')

                $this->validate([
                    'file_epreuve' => 'required|file|mimes:docx,pdf|max:8000',
                    'exam_session' => 'required',
                    'exam_type' => 'required',
                    'name' => 'string|max:60',
                ]);
            else{
                $this->validate([
                    'file_epreuve' => 'required|file|mimes:docx,pdf|max:8000',
                    'exam_department' => 'required',
                    'exam_session' => 'required',
                    'exam_type' => 'required',
                    'name' => 'string|max:60',
                ]);

            }



        }

        $path = null;

        $selecteds = $this->selecteds;

        if($this->file_epreuve){

            $extension = $this->file_epreuve->extension();

           if($this->epreuve_type == 'simple'){

                $file_name = 'epreuve-' . getdate()['year'] . '-' . Str::uuid();

                $this->is_exam = false;

                $this->exam_type = null;
           }
           elseif($this->epreuve_type == 'examen'){

                $this->name = str_replace(' ', '-', 'examen-' . $this->exam_type . '-' . $this->year);

                $file_name = $this->name . '-' . generateRandomNumber(4);

                $this->is_exam = true;

                $this->name = Str::upper($this->name);
                
           }

            $path = 'epreuves/' . $file_name . '.' . $extension;

            foreach($selecteds as $fid){

                $filiars[] = $fid;

            }

        }

        $file_size = '0 Ko';

        if($this->file_epreuve->getSize() >= 1048580){

            $file_size = number_format($this->file_epreuve->getSize() / 1048576, 2) . ' Mo';

        }
        else{

            $file_size = number_format($this->file_epreuve->getSize() / 1000, 2) . ' Ko';

        }

        if(!$this->year) $this->year = date('Y');

        $is_normal_exam = null;

        if($this->exam_session == 'normal') $is_normal_exam = true;

        elseif($this->exam_session == 'blanc') $is_normal_exam = false;

        $user = User::find(auth_user_id());

        $authorized = $user->isAdminsOrMaster() || $user->hasRole(['epreuves-manager']);

        $data = [
            'name' => $this->name,
            'exam_type' => $this->exam_type,
            'is_exam' => $this->is_exam,
            'exam_department' => $this->exam_department,
            'is_normal_exam' => $is_normal_exam,
            'school_year' => $this->year,
            'user_id' => auth_user()->id,
            'contents_titles' => $this->contents_titles,
            'description' => $this->description,
            'filiars_id' => $filiars,
            'promotion_id' => $this->promotion_id,
            'extension' => "." . $extension,
            'file_size' => $file_size,
            'path' => $path,
            'lycee_id' => $this->lycee_id,
            'authorized' => $authorized,
        ];

        if (!Storage::disk('local')->exists('epreuves')) {

           Storage::disk('local')->makeDirectory('epreuves');
        }

        if(!Storage::disk('local')->exists('epreuves')){

            $this->toast("Erreure stockage: La destination de sauvegarde est introuvable", 'error');

           return  Notification::sendNow([auth_user()], new RealTimeNotificationGetToUser("Erreure stockage: La destination de sauvegarde est introuvable"));

        }

        $file_epreuve_saved_path = $this->file_epreuve->storeAs("epreuves", $file_name . '.' . $extension);

        if($file_epreuve_saved_path){

            InitEpreuveCreationEvent::dispatch($data, $file_epreuve_saved_path);

            $this->reset('exam_department', 'lycee_id', 'name', 'selecteds', 'description', 'file_epreuve', 'path', 'year', 'contents_titles', 'filiars_ids', 'promotion_id');

            $this->uploaded_completed = true;
        }
        else{

            $this->toast("Une erreure est survenue", 'error');
        }

    }


    #[On('LiveEpreuveWasCreatedSuccessfullyEvent')]
    public function newEpreuveCreated()
    {
        $message = "Votre épreuve a été publiée avec succès. Elle sera analysée et validée par les administrateurs avant d'être visible par tous!";

        $this->toast($message, 'success');

        to_flash('epreuve-success', $message);

        $this->counter = rand(12, 300);
    }

    
}
