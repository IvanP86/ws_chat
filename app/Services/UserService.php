<?php

namespace App\Services;

use App\Http\Resources\User\UserResource;
use App\Models\User;

class UserService
{
    public function getAnotherUsers(): array
    {
        $users = User::where('id', '!=', auth()->id())->get();
        $users = UserResource::collection($users)->resolve();

        return $users;
    }
}
