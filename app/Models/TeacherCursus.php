<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TeacherCursus extends Model
{
    protected $fillable = [
        'school_year',
        'classes',
        'schools',
        'user_id',
        'from',
        'to',
        'duration'
    ];

    protected $casts = [
        'classes' => 'array',
        'schools' => 'array'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class);
    }
}
