<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageStatus\UpdateRequest;
use App\Models\MessageStatus;

class MessageStatusController extends Controller
{
    public function update(UpdateRequest $request): void
    {
        $data = $request->validated();
        MessageStatus::where('user_id', $data['user_id'])->where('message_id', $data['message_id'])
        ->update([
            'is_read' => true
        ]);
    }
}
