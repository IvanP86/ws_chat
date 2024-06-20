<?php

namespace Tests\Feature\Chat;

use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class ChatTest extends TestCase
{
    use RefreshDatabase;
    public function test_chat_creation()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user2->id
        ]);

        $chat = Chat::create([
            'users' => $user->id . '-' . $user2->id
        ]);

        $this->assertDatabaseHas('chats', [
            'id' => $chat->id
        ]);

        ChatUser::insert([
            [
                'chat_id' => $chat->id,
                'user_id' => $user->id
            ],
            [
                'chat_id' => $chat->id,
                'user_id' => $user2->id
            ]
        ]);
    }

    public function test_message_create()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $chat = Chat::factory()->create([
            'users' => $user->id . '-' . $user2->id
        ]);
        $message = Message::create([
            'chat_id' => $chat->id,
            'user_id' => $user->id,
            'body' => 'Test body'
        ]);

        $this->assertDatabaseHas('messages', [
            'id' => $message->id,
            'body' => $message->body
        ]);
    }

    public function test_show_message()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $chat = Chat::factory()->create([
            'users' => $user->id . '-' . $user2->id
        ]);
        $message = Message::factory()->create([
            'chat_id' => $chat->id,
            'user_id' => $user->id,
        ]);
        $response = $this->actingAs($user2)->get('/chats/' . $chat->id);

        $response->assertInertia(
            fn (Assert $page) => $page
                ->has(
                    'messages',
                    fn (Assert $page) => $page
                        ->where('0.body', $message->body)
                )
        );
    }
}
