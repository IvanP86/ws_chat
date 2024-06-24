<?php

namespace App\Actions;

use App\DTO\ChatDTObuilder;
use App\Models\Chat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

final class CreateChatAction
{
    public function handle(ChatDTObuilder $data) : int | RedirectResponse
    {
        $userIds = array_merge($data->users, [auth()->id()]);
        sort($userIds);
        $userIdsString = implode('-', $userIds);

        try {
            DB::beginTransaction();
            $chat = Chat::updateOrCreate([
                'users' => $userIdsString
            ], [
                'title' => $data->title
            ]);

            $chat->chatUsers()->sync($userIds);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            
            return redirect()->back()->withErrors([
                'error' => $exception->getMessage()
            ]);
        }

        return $chat->id;
    }
}