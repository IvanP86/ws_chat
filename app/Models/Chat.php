<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';
    protected $guarded = [];

    public function getUsers()
    {
        return $this->chatUsers()->get();
    }
    public function getMessagesWithPagination($page): LengthAwarePaginator
    {
        return $this->messages()->with('user')->orderByDesc('created_at')->paginate(5, '*', 'page', $page);
    }
    public function chatUsers()
    {
        return $this->belongsToMany(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_id', 'id');
    }

    public function messageStatuses()
    {
        return $this->hasMany(MessageStatus::class, 'chat_id', 'id');
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'chat_id', 'id')->latestOfMany()->with('user');
    }
}
