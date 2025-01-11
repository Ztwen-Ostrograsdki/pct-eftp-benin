<?php

namespace App\Livewire\Auth\Components;

use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Tools\RobotsBeninHelpers;
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

    public $department;

    public $department_key;

    public $department_name;

    public $city;

    protected $rules = [
        'matricule' => 'string',
        'job_city' => 'string|required',
        'years_experiences' => 'string|required',
        'from_general_school' => 'bool|required',
        'school' => 'string|nullable',
        'general_school' => 'string',
        'teaching_since' => 'date|required|',
        'department' => 'required|string',
        'city' => 'required|string',
    ];


    
    public function render()
    {
        $years = [];

        $current_year = (int)date('Y');

        for ($i = $current_year; $i >= 1980; $i--) { 
            $years[$i] = $i;
        }

        $teachers_statuses = config('app.teachers_statuses');
        $teachers_graduates = config('app.teachers_graduates');
        $teachers_graduate_types = config('app.teachers_graduate_type');
        
        $cities = RobotsBeninHelpers::getCities();

        $departments = RobotsBeninHelpers::getDepartments();
        

        return view('livewire.auth.components.init-user-professionnal-data', 
            [
                'teachers_statuses' => $teachers_statuses,
                'teachers_graduates' => $teachers_graduates,
                'teachers_graduate_types' => $teachers_graduate_types,
                'years' => $years,
                'departments' => $departments,
                'cities' => $cities,
            ]
        );
    }

    public function updatedDepartment($department)
    {
        $departments = RobotsBeninHelpers::getDepartments();

        $this->department_name = $departments[$department];

        $this->department_key = $department;
    }

    public function initProfessionnalDataInsertion()
    {
        $this->dispatch("UpdateSectionInsertion", 'password');
    }

    public function goToTheGraduateForm()
    {
        $this->dispatch("UpdateSectionInsertion", 'graduate');
    }
}

