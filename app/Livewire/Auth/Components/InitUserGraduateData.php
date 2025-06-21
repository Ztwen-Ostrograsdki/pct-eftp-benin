<?php

namespace App\Livewire\Auth\Components;

use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\SubscriptionManager;
use Illuminate\Support\Str;
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

    public function mount()
    {
        self::initializator();
    }
    
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

    public function cleargraduateData()
    {
        SubscriptionManager::clearDataFromSession('graduateData');

        $this->reset();
    }

    public function initializator()
    {
        $data = SubscriptionManager::getGraduateData();

        if($data){

            $this->graduate = isset($data['graduate']) ? $data['graduate'] : null;
            $this->graduate_deliver = isset($data['graduate_deliver']) ? $data['graduate_deliver'] : null;
            $this->graduate_year = isset($data['graduate_year']) ? $data['graduate_year'] : null;
            $this->graduate_type = isset($data['graduate_type']) ? $data['graduate_type'] : null;
            $this->grade = isset($data['grade']) ? $data['grade'] : null;
            $this->status = isset($data['status']) ? $data['status'] : null;

        }
    }

    public function initGraduateDataInsertion()
    {
        session()->forget('graduate_data_is_ok');

        $this->resetErrorBag();

        $this->validate();

        $data = [
            'grade' => Str::upper($this->grade),
            'status' => Str::upper($this->status),
            'graduate' => Str::upper($this->graduate),
            'graduate_deliver' => ucwords($this->graduate_deliver),
            'graduate_year' => $this->graduate_year,
            'graduate_type' => Str::ucfirst($this->graduate_type),
        ];

        session()->put('graduate_data_is_ok', true);

        $this->dispatch("UpdateSectionInsertion", 'professionnal');

        SubscriptionManager::putGraduateDataIntoSession($data); 
        
    }

    public function goToThePersoForm()
    {
        $this->dispatch("UpdateSectionInsertion", 'perso');
    }
}
