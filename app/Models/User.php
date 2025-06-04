<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\Dater\DateFormattor;
use App\Helpers\TraitsManagers\UserTrait;
use App\Models\Communique;
use App\Models\ENotification;
use App\Models\Member;
use App\Models\Quote;
use App\Observers\ObserveUser;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy(ObserveUser::class)]
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, UserTrait, DateFormattor, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pseudo',
        'email',
        'password',
        'profil_photo',
        'lastname',
        'firstname',
        'gender',
        'job_department',
        'job_city',
        'school',
        'address',
        'teaching_since',
        'marital_status',
        'graduate',
        'graduate_type',
        'graduate_year',
        'graduate_deliver',
        'grade',
        'years_experiences',
        'contacts',
        'birth_city',
        'birth_date',
        'matricule',
        'identifiant',
        'is_ame',
        'status',
        'ability',
        'current_function',
        'email_verified_at',
        'FEDAPAY_ID',
        'general_school',
        'from_general_school',
        'auth_token',
        'wrong_password_tried',

    ];

    protected $admins_attr = [
        'confirmed_by_admin',
        'blocked',
        'blocked_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'password_reset_key',
        'email_verify_key'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birth_date' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function communiques()
    {
        return $this->hasMany(Communique::class);
    }


    public function classes()
    {

    }


    public function epreuves()
    {
        
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function getSingleQuote()
    {
        $quote = $this->quotes()->inRandomOrder()->first();

        if($quote) return $quote->content;

        else return " Aucune citation publiée pour l'instant!";
    }

    


    public function getGender($gender = null)
    {
        if(!$gender) $gender = $this->gender;

        $genders = [
            'female' => "Féminin",
            'Féminin' => "Féminin",
            'Female' => "Féminin",
            'male' => "Masculin",
            'Masculin' => "Masculin",
            'Male' => "Masculin",
            'other' => "Autre",
            'Autre' => "Autre",
            null => "Non renseigné",
        ];

        return $genders[$gender];
    }

    public function getFilamentName(){}


    public function getUserNamePrefix($withFullName = false, $reverseName = false)
    {
        $prefix = 'Mr/Mme';

        if(in_array($this->gender, ['male', 'Male', 'M', 'm', 'masculin', 'Masculin'])) $prefix = 'Mr';

        if(in_array($this->gender, ['female', 'Female', 'F', 'f', 'feminin', 'Féminin', 'Feminin'])) $prefix = 'Mme';

        if($withFullName) return $prefix . ' ' . $this->getFullName($reverseName);

        return $prefix;
    }


    public function getNotifications()
    {
        return $this->notifications;
    }

    public function getUnreadNotifications()
    {
        return $this->unreadNotifications;
    }

    public function getReadNotifications()
    {
        return $this->readNotifications;
    }

    public function member()
    {
        return $this->hasOne(Member::class);
    }
    
    public function my_member()
    {
        return $this->hasOne(Member::class);
    }

    public function getMemberRoleName()
    {
        if($this->member->role) return $this->member->role->name;

        else return "Membre";
    }


}
