<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumChat extends Model
{
    protected $fillable = [
        'user_id',
        'message',
        'seen_by',
        'delete_by',
        'reply_to_message_id',
        'file',
        'file_extension',
        'file_pages',
        'file_size',
        'file_path',

    ];

    protected $casts = [
        'seen_by' => 'array',
        'delete_by' => 'array',

    ];
}
