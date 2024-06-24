<?php

namespace Tests\Feature\Chat;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $user2;
    private User $user3;


    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->user2 = User::factory()->create();
        $this->user3 = User::factory()->create();
    }
    public function test_create_chat()
    {
        $this->actingAs($this->user)->json('POST', route('chats.store'), [
            'title' => 'Test chat',
            'users' => [$this->user2->id, $this->user3->id]
        ]);
        $this->assertDatabaseHas('chats', [
            'title' => 'Test chat',
            'users' => $this->user->id . '-' . $this->user2->id . '-' . $this->user3->id
        ]);
    }

    public function test_add_message_to_chat()
    {
        $chat = Chat::factory()->create([
            'users' => $this->user->id . '-' . $this->user2->id
        ]);
        $this->actingAs($this->user)->json('POST', route('messages.store'), [
            'chat_id' => $chat->id,
            'user_ids' => [$this->user->id, $this->user2->id],
            'body' => 'TestBody'
        ]);

        $this->assertDatabaseHas('messages', [
            'chat_id' => $chat->id,
            'body' => 'TestBody'
        ]);
    }

    public function test_show_message_in_chat()
    {
        $chat = Chat::factory()->create([
            'users' => $this->user->id . '-' . $this->user2->id
        ]);
        $message = Message::factory()->create([
            'chat_id' => $chat->id,
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user2)->json('GET', route('chats.show', $chat->id))->assertInertia(
            fn (Assert $page) => $page
                ->has(
                    'messages',
                    fn (Assert $page) => $page
                        ->where('0.body', $message->body)
                )
        );
    }
}
