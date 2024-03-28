<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageStatus\UpdateRequest;
use App\Models\MessageStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MessageStatusController extends Controller
{
    public function update(UpdateRequest $request)
    {
        $data = $request->validated();
        $messageStatus = MessageStatus::where('user_id', $data['user_id'])->where('message_id', $data['message_id'])
        ->update([
            'is_read' => true
        ]);
        Log::info($messageStatus);
    }
}
