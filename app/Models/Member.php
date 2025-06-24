<?php

namespace App\Models;

use App\Models\CardMember;
use App\Models\Cotisation;
use App\Models\MemberCard;
use App\Models\Role;
use App\Models\User;
use App\Observers\ObserveMember;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[ObservedBy(ObserveMember::class)]
class Member extends Model
{
    protected $fillable = [
        'user_id',
        'role_id',
        'description',
        'ability',
        'authorized',
        'tasks',
        'card_sent_by_mail',

    ];

    protected $casts = [
        'tasks' => 'array',

    ]; 

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cards()
    {
        return $this->hasMany(CardMember::class);
    }

    public function getFullName($reverse = false)
    {
        return $this->user ? $this->user->getFullName($reverse) : "Utilisateur inconnu";
    }
    
    public function card()
    {
        $year = (int)date('Y'); 

        $duration = $year . '-' . $year + 3;

        $path = Str::replace(' ', '-', $this->user->getFullName()) . "-" . $duration . '.pdf';

        $pdfPath = storage_path("app/public/cartes/carte-de-membre-de-". $path);

        $cards = $this->cards()->where('card_path', $pdfPath)->orderBy('created_at', 'desc')->get();

        if(count($cards) > 0) return $cards[0];

        else return null;
    }

    public function getMemberCardPrints()
    {
        $card = $this->card();

        if($card) return numberZeroFormattor($card->total_print);

        else return null;
    }

    public function getMemberCardLastDatePrint()
    {
        $card = $this->card();

        if($card && $card->last_print_date) return __formatDate($card->last_print_date);

        else return null;
    }

    public function getMemberCardExpirationDate()
    {
        $card = $this->card();

        if($card) return __formatDate($card->expired_at);

        else return null;
    }

    public function getMemberCardCreationDate()
    {
        $card = $this->card();

        if($card) return __formatDate($card->created_at);

        else return null;
    }

    public function getTotalCotisationOfYear($year) : float
    {
        $totals = Cotisation::where('member_id', $this->id)->where('year', $year)->pluck('amount')->toArray();

        return count($totals) > 0 ? (float)array_sum($totals) : 0.0 ;
    }

    public function getMemberRoleName()
    {
        if($this->role) return $this->role->name;

        else return "Membre";
    }
}

