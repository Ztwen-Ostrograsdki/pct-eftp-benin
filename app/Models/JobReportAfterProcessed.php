<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobReportAfterProcessed extends Model
{
    protected $fillable = [

        'batch_id',
        'job_id',
        'job_class',
        'status',
        'report',
        'payload',
        'status',

    ];

    protected $casts = [
        'payload' => 'array'
    ];



    
}
