<?php

namespace App\Services;

use App\Http\Resources\User\UserResource;
use App\Models\User;

class UserService
{
    public function getAnotherUsers($id): array
    {
        $users = User::where('id', '!=', $id)->get();

        return UserResource::collection($users)->resolve();
    }
}
