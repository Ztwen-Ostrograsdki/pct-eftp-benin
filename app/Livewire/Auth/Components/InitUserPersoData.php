<?php

namespace App\Livewire\Auth\Components;

use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Tools\RobotsBeninHelpers;
use Livewire\Component;

class InitUserPersoData extends Component
{
    

    use Toast;

    public $is_perso_data_insertion = true;

    public $email;

    public $lastname;

    public $firstname;

    public $pseudo;

    public $birth_date;

    public $birth_city;

    public $marital_status;

    public $address;

    public $department;

    public $department_key;

    public $department_name;

    public $city;

    public $contacts;

    public $gender;

    protected $rules = [
        'email' => 'required|email|unique:users|min:3|max:255',
        'lastname' => 'required|string',
        'firstname' => 'required|string',
        'department' => 'required|string',
        'city' => 'required|string',
        'birth_date' => 'required|date',
        'birth_city' => 'required|string',
        'marital_status' => 'required|string',
        'address' => 'required|string',
        'contacts' => 'required|string|starts_with:01',
        'gender' => 'required|string',
    ];

    public function render()
    {
        $cities = RobotsBeninHelpers::getCities();

        $departments = RobotsBeninHelpers::getDepartments();

        $genders = config('app.genders');

        $marital_statuses = config('app.marital_statuses');

        return view('livewire.auth.components.init-user-perso-data', [
            'departments' => $departments,
            'cities' => $cities,
            'genders' => $genders,
            'marital_statuses' => $marital_statuses
        ]);
    }

    public function initPersonnalDataInsertion()
    {
        $this->dispatch("UpdateSectionInsertion", 'graduate');
    }

    public function updatedDepartment($department)
    {
        $departments = RobotsBeninHelpers::getDepartments();

        $this->department_name = $departments[$department];

        $this->department_key = $department;
    }


    public function updatedContacts($contacts)
    {
        $this->validateOnly('contacts');
    }

   






    public function clearPersoData()
    {
        $this->reset(
            'pseudo',
            'password',
            'firstname',
            'lastname' ,
        );
    }


}
