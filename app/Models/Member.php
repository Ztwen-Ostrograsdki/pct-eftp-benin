<?php

namespace App\Models;

use App\Models\CardMember;
use App\Models\MemberCard;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

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

    public function card()
    {
        $cards = $this->cards()->orderBy('created_at', 'desc')->get();

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
}
