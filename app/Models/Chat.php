<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Pagination\LengthAwarePaginator;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';
    protected $guarded = [];

    public function getUsers(): Collection
    {
        return $this->chatUsers()->get();
    }
    public function getMessagesWithPagination($page): LengthAwarePaginator
    {
        return $this->messages()->with('user')->orderByDesc('created_at')->paginate(5, '*', 'page', $page);
    }
    public function chatUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'chat_id', 'id');
    }

    public function messageStatuses(): HasMany
    {
        return $this->hasMany(MessageStatus::class, 'chat_id', 'id');
    }

    public function lastMessage(): HasOne
    {
        return $this->hasOne(Message::class, 'chat_id', 'id')->latestOfMany()->with('user');
    }
}
