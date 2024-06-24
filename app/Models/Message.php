<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';
    protected $guarded = [];

    public function getTimeAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    // public function getIsOwnerAttribute()
    // {
    //     return (int) $this->user_id === (int) auth()->id();
    // }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
