<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'seen',
        'deleted',
        'reply_to_message_id',
        'file',
        'file_extension',
        'file_pages',
        'file_size',
        'file_path',
    ];

}
