<?php

namespace App\Models;

use App\Models\Member;
use Illuminate\Database\Eloquent\Model;

class MemberCard extends Model
{
    protected $fillable = [
        'member_id',
        'last_print',
        'total_print',
        'status',
        'card_expired',
        'requesting',
        'print_blocked'

    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
