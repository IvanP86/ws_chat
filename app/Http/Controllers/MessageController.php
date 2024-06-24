<?php

namespace App\Http\Controllers;

use App\Actions\StoreMessageAction;
use App\DTO\MessageDTObuilder;
use App\Events\StoreMessageEvent;
use App\Http\Requests\Message\StoreRequest;
use App\Http\Resources\Message\MessageResource;
use App\Jobs\StoreMessageStatusJob;

class MessageController extends Controller
{
    public function store(StoreRequest $request, MessageDTObuilder $builder, StoreMessageAction $storeMessageAction): array
    {
        $data = $builder->from($request);
        $message = $storeMessageAction->handle($data);
        StoreMessageStatusJob::dispatch($data, $message)->onQueue('store_messages');
        broadcast(new StoreMessageEvent($message))->toOthers();

        return MessageResource::make($message)->resolve();
    }
}
