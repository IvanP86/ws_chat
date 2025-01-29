<?php

namespace App\DTO;

use Spatie\LaravelData\Data;

class ChatDTOBuilder extends Data
{
    public ?string $title;
    public array $users;
}
