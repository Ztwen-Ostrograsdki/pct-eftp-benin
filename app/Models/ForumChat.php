<?php

namespace App\Models;

use App\Helpers\Dater\DateFormattor;
use App\Models\User;
use App\Observers\ObserveChatForumMessage;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ObserveChatForumMessage::class)]
class ForumChat extends Model
{
    use DateFormattor;

    protected $fillable = [
        'user_id',
        'message',
        'seen_by',
        'likes',
        'delete_by',
        'reply_to_message_id',
        'file',
        'file_extension',
        'file_pages',
        'file_size',
        'file_path',
        'authorized',
        'reported',

    ];

    protected $casts = [
        'seen_by' => 'array',
        'delete_by' => 'array',
        'likes' => 'array',

    ];

    public function notHiddenFor($user_id = null)
    {
        if(!$user_id) $user_id = auth_user()->id;

        $delete_by = (array)$this->delete_by;

        return !in_array($user_id, $delete_by);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function hasFile()
    {
        return !$this->file == null;
    }



}
