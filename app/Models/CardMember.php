<?php

namespace App\Models;

use App\Models\Member;
use App\Models\User;
use App\Observers\ObserveCardMember;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ObserveCardMember::class)]
class CardMember extends Model
{
    protected $fillable = [
        'member_id',
        'card_number',
        'code_qr',
        'expired',
        'expired_at',
        'generate_by',
        'closed_because_lost',
        'declared_as_lost_at',
        'last_print_date',
        'total_print',
        'status',
        'print_blocked',
        'card_sent_by_mail',
        'card_path',
        'key'

    ];

    const MAX_PRINT = 3;


    protected $casts = [
        'expired_at' => 'datetime',
        'declared_as_lost_at' => 'datetime',
        'last_print_date' => 'date',

    ];


    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function getCreator()
    {
        $creator = User::find($this->generate_by);

        if($creator) return $creator;

        else return null;
    }

    public function isPrintable()
    {
        return !$this->print_blocked && !$this->expired;
    }

    public function max_print_attempt()
    {
        return $this->total_print >= self::MAX_PRINT;
    }

    public function markAsSendToMemberByEmail()
    {
        $this->member->update(['card_sent_by_mail' => true]);
            
        $this->update(['card_sent_by_mail' => true]);

        return true;
    }

}
