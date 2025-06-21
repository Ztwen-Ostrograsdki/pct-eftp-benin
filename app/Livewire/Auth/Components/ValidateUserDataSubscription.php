<?php

namespace App\Livewire\Auth\Components;

use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\SubscriptionManager;
use App\Helpers\Tools\ModelsRobots;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use PhpParser\Node\Stmt\TryCatch;
use Throwable;

class ValidateUserDataSubscription extends Component
{

    use Toast;

    public $current_function = "Enseignant";

    public $lastname;

    public $firstname;

    public $birth_date;

    public $birth_city;

    public $marital_status;

    public $address;

    public $department;

    public $department_name;

    public $city;

    public $contacts;

    public $gender;

    public $graduate;
    public $grade;
    public $status;
    public $graduate_year;
    public $graduate_deliver;
    public $graduate_type;

    public $job_city;

    public $school;

    public $from_general_school = false;

    public $general_school;

    public $teaching_since;

    public $years_experiences;

    public $matricule;

    public $job_department;

    public $email;

    public $password;

    public $password_confirmation;

    public $photo_path;

    public $user;

    public $pseudo;

    public $data_subscription = [
        'perso' => false,
        'graduate' => false,
        'professionnal' => false,
        'email' => false,
    ];

    public function mount()
    {
        self::initializator();

    }

    
    public function render()
    {
        return view('livewire.auth.components.validate-user-data-subscription');
    }

    #[On("MakeDataIsCompletedEvent")]
    public function makeDataIsCompleted($section, $value = true)
    {
        $this->data_subscription[$section] = true;

        session()->put('data_subscription', json_encode($this->data_subscription));

        $this->data_subscription = (array)json_decode(session('data_subscription'));
        
    }

    public function editPersoData()
    {
        $this->dispatch("UpdateSectionInsertion", 'perso');
    }
    
    public function editGraduateData()
    {
        $this->dispatch("UpdateSectionInsertion", 'graduate');
    }

    public function initializator()
    {
        $graduate_data = SubscriptionManager::getGraduateData();

        $perso_data = SubscriptionManager::getPersoData();

        $profsnal_data = SubscriptionManager::getProfessionnalData();

        $email_data = SubscriptionManager::getEmailData();

        if($perso_data){

            $this->firstname = isset($perso_data['firstname']) ? $perso_data['firstname'] : null;
            $this->lastname = isset($perso_data['lastname']) ? $perso_data['lastname'] : null;
            $this->department = isset($perso_data['department']) ? $perso_data['department'] : null;
            $this->city = isset($perso_data['city']) ? $perso_data['city'] : null;
            $this->birth_city = isset($perso_data['birth_city']) ? $perso_data['birth_city'] : null;
            $this->birth_date = isset($perso_data['birth_date']) ? $perso_data['birth_date'] : null;
            $this->marital_status = isset($perso_data['marital_status']) ? $perso_data['marital_status'] : null;
            $this->contacts = isset($perso_data['contacts']) ? $perso_data['contacts'] : null;
            $this->gender = isset($perso_data['gender']) ? $perso_data['gender'] : null;
            $this->address = isset($perso_data['address']) ? $perso_data['address'] : null;

        }

        if($graduate_data){

            $this->graduate = isset($graduate_data['graduate']) ? $graduate_data['graduate'] : null;
            $this->graduate_deliver = isset($graduate_data['graduate_deliver']) ? $graduate_data['graduate_deliver'] : null;
            $this->graduate_year = isset($graduate_data['graduate_year']) ? $graduate_data['graduate_year'] : null;
            $this->graduate_type = isset($graduate_data['graduate_type']) ? $graduate_data['graduate_type'] : null;
            $this->grade = isset($graduate_data['grade']) ? $graduate_data['grade'] : null;
            $this->status = isset($graduate_data['status']) ? $graduate_data['status'] : null;

        }

        if($profsnal_data){

            $this->matricule = isset($profsnal_data['matricule']) ? $profsnal_data['matricule'] : null;
            $this->job_city = isset($profsnal_data['job_city']) ? $profsnal_data['job_city'] : null;
            $this->job_department = isset($profsnal_data['job_department']) ? $profsnal_data['job_department'] : null;
            $this->years_experiences = isset($profsnal_data['years_experiences']) ? $profsnal_data['years_experiences'] : null;
            $this->from_general_school = isset($profsnal_data['from_general_school']) ? $profsnal_data['from_general_school'] : null;
            $this->general_school = isset($profsnal_data['general_school']) ? $profsnal_data['general_school'] : null;
            $this->school = isset($profsnal_data['school']) ? $profsnal_data['school'] : null;
            $this->teaching_since = isset($profsnal_data['teaching_since']) ? $profsnal_data['teaching_since'] : null;

        }

        if($email_data){

            $this->email = isset($email_data['email']) ? $email_data['email'] : null;
            $this->password = isset($email_data['password']) ? $email_data['password'] : null;
            $this->password_confirmation = isset($email_data['password_confirmation']) ? $email_data['password_confirmation'] : null;
            $this->photo_path = isset($email_data['photo_path']) ? $email_data['photo_path'] : null;

        }

        
    }

    public function register()
    {

        $identifiant = ModelsRobots::makeUserIdentifySequence();

        $user = false;

        $sendEmailToUser = false;

        $this->pseudo = '@' . Str::substr($this->firstname, 0, 3) . '.' . Str::substr($this->lastname, 0, 3) . '' . rand(20, 99);
        
        $all_data_is_ok = (session()->has('perso_data_is_ok') && session()->has('graduate_data_is_ok') && session()->has('professionnal_data_is_ok') && session()->has('email_data_is_ok'));
        
        DB::beginTransaction();

        try {
            if($all_data_is_ok){

                $data = [
                    'matricule' => $this->matricule,
                    'job_city' => $this->job_city,
                    'job_department' => $this->job_department,
                    'grade' => $this->grade,
                    'school' => $this->school,
                    'status' => $this->status,
                    'teaching_since' => $this->teaching_since,
                    'general_school' => $this->general_school,
                    'from_general_school' => $this->from_general_school,
                    'years_experiences' => $this->years_experiences,
                    'graduate' => $this->graduate,
                    'graduate_deliver' => $this->graduate_deliver,
                    'graduate_type' => $this->graduate_type,
                    'graduate_year' => $this->graduate_year,
                    'contacts' => $this->contacts,
                    'address' => ucwords($this->address),
                    'gender' => ucwords($this->gender),
                    'status' => Str::upper($this->status),
                    'marital_status' => ucwords($this->marital_status),
                    'birth_date' => $this->birth_date,
                    'birth_city' => Str::ucfirst($this->birth_city),
                    'pseudo' => ucwords($this->pseudo),
                    'password' => Hash::make($this->password),
                    'firstname' => Str::upper($this->firstname),
                    'lastname' => ucwords($this->lastname),
                    'identifiant' => $identifiant,
                    'auth_token' => Str::replace("/", $identifiant, Hash::make($identifiant)),
                    'email' => $this->email,
                    'profil_photo' => $this->photo_path,
                ];

                if($data){

                    $user = User::create($data);

                    if($user){

                        $sendEmailToUser = $user->sendVerificationLinkOrKeyToUser();
            
                        $message = "Incription lancée avec succès! Un courriel vous a été envoyé pour confirmation, veuillez vérifier votre boite mail.";
            
                        $this->toast($message, 'success', 5000);
        
                        session()->flash('success', $message);

                        SubscriptionManager::clearEachData();
                        
                    }
                    else{
            
                        $message = "L'incription a échoué! Veuillez réessayer!";
            
                        session()->flash('error', $message);
            
                        $this->toast($message, 'error', 7000);
            
                    }
                }
            }

            DB::commit();

            if($user && $sendEmailToUser){

                return redirect(route('email.verification', ['email' => $this->email]))->with('success', "Confirmer votre compte en renseignant le code qui vous été envoyé!");
            }


        } catch (Throwable $e) {

            DB::rollBack(); // Annule tout

            $this->toast("Une erreure est survenue lors l'insertion de vos données dans la base de données: MESSAGE: " . $e->getMessage(), 'info');

            
        }
        
    }
}
