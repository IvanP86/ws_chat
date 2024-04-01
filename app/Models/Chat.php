<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_user', 'chat_id', 'user_id');
    }

    public function chatWith()
    {
        return $this->hasOneThrough(User::class, ChatUser::class, 'chat_id', 'id', 'id', 'user_id')->where('user_id', '!=', auth()->id());
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_id', 'id');
    }

    public function unreadableMessageStatuses()
    {
        return $this->hasMany(MessageStatus::class, 'chat_id', 'id')->where('user_id', auth()->id())->where('is_read', false);
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'chat_id', 'id')->latestOfMany()->with('user');
    }
}
