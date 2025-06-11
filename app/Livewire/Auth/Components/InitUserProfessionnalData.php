<?php

namespace App\Livewire\Auth\Components;

use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\SubscriptionManager;
use App\Helpers\Tools\RobotsBeninHelpers;
use App\Models\Lycee;
use Livewire\Component;

class InitUserProfessionnalData extends Component
{

    use Toast;

    public $job_city;

    public $school;

    public $from_general_school = false;

    public $general_school;

    public $teaching_since;

    public $years_experiences;

    public $matricule;

    public $school_by_select = [];

    public $job_department;

    public $department_key;

    protected $rules = [
        'matricule' => 'required|string',
        'job_city' => 'string|required',
        'years_experiences' => 'numeric|required',
        'from_general_school' => 'bool|required',
        'school' => 'string|nullable',
        'general_school' => 'string|nullable',
        'teaching_since' => 'numeric|required|',
        'job_department' => 'required|string',
    ];

    public function mount()
    {
        self::initializator();
    }


    
    public function render()
    {
        self::initializator();

        $years = [];

        $current_year = (int)date('Y');

        for ($i = $current_year; $i >= 1980; $i--) { 
            $years[$i] = $i;
        }

        $cities = RobotsBeninHelpers::getCities();

        $departments = RobotsBeninHelpers::getDepartments();

        $lycees = Lycee::all();
        

        return view('livewire.auth.components.init-user-professionnal-data', 
            [
                'years' => $years,
                'departments' => $departments,
                'cities' => $cities,
                'lycees' => $lycees,
            ]
        );
    }


    public function clearprofessionnalData()
    {
        SubscriptionManager::clearDataFromSession('professionnalData');

        $this->reset();
    }

    public function initializator()
    {
        $data = SubscriptionManager::getProfessionnalData();

        if($data){

            $this->matricule = isset($data['matricule']) ? $data['matricule'] : null;
            $this->job_city = isset($data['job_city']) ? $data['job_city'] : null;
            $this->job_department = isset($data['job_department']) ? $data['job_department'] : null;
            $this->years_experiences = isset($data['years_experiences']) ? $data['years_experiences'] : null;
            $this->from_general_school = isset($data['from_general_school']) ? $data['from_general_school'] : null;
            $this->general_school = isset($data['general_school']) ? $data['general_school'] : null;
            $this->school = isset($data['school']) ? $data['school'] : null;
            $this->teaching_since = isset($data['teaching_since']) ? $data['teaching_since'] : null;
            $this->department_key = isset($data['department_key']) ? $data['department_key'] : null;

        }
    }

    public function updatedSchoolBySelect($school)
    {
        $init = "";

        $add = "";

        if($this->school){

            $init = $this->school;
        }

        if($school){

            $add = implode('-', $this->school_by_select);

        }

        if($init){

            $this->school = $init . '-' . $add;
        }
        else{

            $this->school = $add;
        }

        
    }

    public function refreshSelected()
    {
        $this->reset('school', 'school_by_select');
    }

    public function updatedTeachingSince($teaching_since)
    {
        $this->years_experiences = null;

        $year = (int)$this->teaching_since;

        $now = (int)date('Y');

        if($year && $year > 0){

            $this->years_experiences = abs($now - $year) > 1 ?  abs($now - $year) : 1;

        }

    }

    public function updatedJobDepartment($job_department)
    {

        if($job_department){

            $departments = RobotsBeninHelpers::getDepartments();

            $department_key = array_keys($departments, $job_department)[0];

           if($departments[$department_key] == $job_department){

                $this->department_key = $department_key;

           }
        }
    }

    public function initProfessionnalDataInsertion()
    {
        session()->forget('professionnal_data_is_ok');

        $this->resetErrorBag();

        $this->validate();

        $data = [
            'teaching_since' => $this->teaching_since,
            'years_experiences' => $this->years_experiences,
            'matricule' => $this->matricule,
            'from_general_school' => $this->from_general_school,
            'general_school' => $this->general_school,
            'job_department' => $this->job_department,
            'job_city' => $this->job_city,
            'department_key' => $this->department_key,
            'school' => $this->school,

        ];

        SubscriptionManager::putProfessionnalDataIntoSession($data);
        
        session()->put('professionnal_data_is_ok', true);

        $this->dispatch("UpdateSectionInsertion", 'password');

        
    }

    public function goToTheGraduateForm()
    {
        $this->dispatch("UpdateSectionInsertion", 'graduate');
    }
}

