<?php

namespace App\Livewire\Auth\Components;

use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\SubscriptionManager;
use App\Helpers\Tools\RobotsBeninHelpers;
use App\Livewire\Auth\Components\ValidateUserDataSubscription;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Component;

class InitUserPersoData extends Component
{
    use Toast;

    public $is_perso_data_insertion = true;

    public $lastname;

    public $firstname;

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
        'lastname' => 'required|string',
        'firstname' => 'required|string',
        'department' => 'required|string',
        'city' => 'required|string',
        'birth_date' => 'required|date',
        'birth_city' => 'required|string',
        'marital_status' => 'required|string',
        'address' => 'required|string',
        'contacts' => 'required|string|min:10',
        'gender' => 'required|string',
    ];


    public function mount()
    {
        self::initializator();
    }

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
        session()->forget('perso_data_is_ok');

        $this->resetErrorBag();

        self::setUserAddress();

        $this->validate();

        $exists = User::where('firstname', $this->firstname)->where('lastname', $this->lastname)->first();

        if($exists){

            $this->addError('firstname', "Cet utilisateur existe déjà");
            
            $this->addError('lastname', "Cet utilisateur existe déjà");

            return false;
        }

        if($this->validatePhoneNumber() && $this->validateBirthDate($this->birth_date)){

            $data = [
                'firstname' => Str::upper($this->firstname),
                'lastname' => ucwords($this->lastname),
                'birth_date' => $this->birth_date,
                'birth_city' => Str::ucfirst($this->birth_city),
                'address' => $this->address,
                'marital_status' => $this->marital_status,
                'gender' => $this->gender,
                'contacts' => $this->contacts,
                'department' => $this->department,
                'department_name' => $this->department_name,
                'department_key' => $this->department_key,
                'city' => $this->city,

            ];

            SubscriptionManager::putPersoDataIntoSession($data);
            
            session()->put('perso_data_is_ok', true);

            $this->dispatch("UpdateSectionInsertion", 'graduate');
            
        }
        else{
            return $this->toast("FORMULAIRE INAVALIDE", "Le formulaire est invalide!");
        }
    }

    public function getUserAddress()
    {
        return $this->department_name . ' - ' . $this->city;
    }

    public function setUserAddress()
    {
        $this->address = $this->department_name . ' - ' . $this->city;
    }


    public function updatedDepartment($department)
    {
        $departments = RobotsBeninHelpers::getDepartments();

        $this->department_name = $departments[$department];

        $this->department_key = $department;
    }


    public function clearPersoData()
    {
        SubscriptionManager::clearDataFromSession('persoData');

        $this->reset();
    }

    public function initializator()
    {
        $data = SubscriptionManager::getPersoData();

        if($data){

            $this->firstname = isset($data['firstname']) ? $data['firstname'] : null;
            $this->lastname = isset($data['lastname']) ? $data['lastname'] : null;
            $this->department = isset($data['department']) ? $data['department'] : null;
            $this->department_key = isset($data['department_key']) ? $data['department_key'] : null;
            $this->department_name = isset($data['department_name']) ? $data['department_name'] : null;
            $this->city = isset($data['city']) ? $data['city'] : null;
            $this->birth_city = isset($data['birth_city']) ? $data['birth_city'] : null;
            $this->birth_date = isset($data['birth_date']) ? $data['birth_date'] : null;
            $this->marital_status = isset($data['marital_status']) ? $data['marital_status'] : null;
            $this->contacts = isset($data['contacts']) ? $data['contacts'] : null;
            $this->gender = isset($data['gender']) ? $data['gender'] : null;
            $this->address = isset($data['address']) ? $data['address'] : null;

        }
    }

    public function validatePhoneNumber()
    {
        $contacts = $this->contacts;

        $this->resetErrorBag('contacts');

        if(strlen($contacts) >= 10){

            if(strpos($contacts, "-")){

                $validator = true;

                $parts = explode("-", $contacts);

                foreach($parts as $number){

                    $validator = Validator::make(
                        data: [
                            'contacts' => $number
                        ],
                        rules: [
                            'contacts' => ['required', 'numeric', 'starts_with:01', 'digits:10']
                        ],
                    );

                    if($validator->fails()){

                        $this->addError('contacts', "Chaque numéro doit contenir au moins 10 chiffres");
                    }
                }
            }
            else{
                if(strlen($contacts) == 10){

                    $validator = Validator::make(
                        data: [
                            'contacts' => $contacts
                        ],
                        rules: [
                            'contacts' => ['required', 'numeric', 'starts_with:01', 'digits:10']
                        ],
                    );

                    if($validator->fails()){

                        $this->addError('contacts', "Chaque numéro doit contenir au moins 10 chiffres et commencer par 01");
                    }
                    else{
                        return true;
                    }
                }
                else{
                    $this->addError('contacts', "Le formats n'est pas conforme séparer vos numéros pas des tirets");
                }
            }

        }
        else{

            $this->addError('contacts', "Le formats des contacts n'est pas conforme");
        }

        return true;
    }

    public function validateBirthDate($date)
    {
        $this->resetErrorBag('birth_date');

        $now = now();

        if($date){

            $timestamp_date = Carbon::parse($date)->timestamp;

            $timestamp_today = Carbon::parse($now)->timestamp;

            $v = $timestamp_today - $timestamp_date;

            if($v <= 0){

                $this->addError('birth_date', "Date incorrecte: Vous ne pouvez pas être né après aujourd'hui");

            }
            else{

                $bd = Carbon::parse($date);

                $td = Carbon::parse($now);

                $diff_year = $bd->diffInYears($td);

                if($diff_year <= 19){

                    if($diff_year < 1){

                        $diff_month = $bd->diffInMonths($td);

                        if($diff_month < 1){

                            $diff_week = $bd->diffInWeeks($td);

                            if($diff_week < 1){

                                $diff_day = $bd->diffInDays($td);

                                $this->addError('birth_date', "Date douteuse: Votre âge serait donc environ " . floor($diff_day) . " jours");

                            }
                            else{

                                $this->addError('birth_date', "Date douteuse: Votre âge serait donc environ " . floor($diff_week) . " semaines");
        
                            }


                        }
                        else{

                            $this->addError('birth_date', "Date douteuse: Votre âge serait donc environ " . floor($diff_month) . " mois");
    
                        }

                    }
                    else{

                        $this->addError('birth_date', "Date douteuse: Votre âge serait donc environ " . floor($diff_year) . " ans");

                    }

                }
                else{
                    return true;
                }
            }
            
        }
        else{
            $this->addError('birth_date', "Renseigner votre date de naissance");

        }
    }
}
