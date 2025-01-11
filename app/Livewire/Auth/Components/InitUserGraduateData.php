<?php

namespace App\Livewire\Auth\Components;

use Akhaled\LivewireSweetalert\Toast;
use Livewire\Component;

class InitUserGraduateData extends Component
{
    use Toast;

    public $graduate;
    public $grade;
    public $status;
    public $graduate_year;
    public $graduate_deliver;
    public $graduate_type;

    protected $rules = [
        'graduate' => 'string|required',
        'graduate_year' => 'string|required',
        'graduate_type' => 'string|required',
        'graduate_deliver' => 'string|required',
        'grade' => 'string|required',
        'status' => 'string|required',
    ];
    
    public function render()
    {
        $years = [];

        $current_year = (int)date('Y');

        for ($i = $current_year; $i >= 1990; $i--) { 
            $years[$i] = $i;
        }

        $teachers_statuses = config('app.teachers_statuses');
        $teachers_graduates = config('app.teachers_graduates');
        $teachers_graduate_types = config('app.teachers_graduate_type');
        

        return view('livewire.auth.components.init-user-graduate-data', 
            [
                'teachers_statuses' => $teachers_statuses,
                'teachers_graduates' => $teachers_graduates,
                'teachers_graduate_types' => $teachers_graduate_types,
                'years' => $years,
            ]
        );
    }

    public function initGraduateDataInsertion()
    {
        $this->dispatch("UpdateSectionInsertion", 'professionnal');
    }

    public function goToThePersoForm()
    {
        $this->dispatch("UpdateSectionInsertion", 'perso');
    }
}
