<?php

namespace App\DTO;

use Spatie\LaravelData\Data;

class MessageDTOBuilder extends Data
{
    public int $chat_id;
    public string $body;
    public array $user_ids;
}
