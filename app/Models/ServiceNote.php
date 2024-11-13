<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceNote extends Model
{
    /**
     * To is the persons or parts that are concerned by the service note
     * from is the root of the note 
     * the instance who dispatched the service note
     */
    protected $fillable = [
        'title',
        'description',
        'will_closed_at',
        'images',
        'targets',
        'to',
        'objet',
        'read_by',
        'from',
        'content'
    ];


    protected $casts = [
        'images' => 'array',
        'targets' => 'array',
        'read_by' => 'array',

    ];
}
