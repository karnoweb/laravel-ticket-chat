<?php

namespace Karnoweb\TicketChat\Events;

use Karnoweb\TicketChat\Models\Conversation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ParticipantJoined implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Conversation $conversation,
        public int $userId,
        public string $role
    ) {}

    public function broadcastOn(): array
    {
        if (! config('ticket-chat.broadcasting.enabled', true)) {
            return [];
        }

        return [
            new PrivateChannel('conversation.'.$this->conversation->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'participant.joined';
    }

    public function broadcastWith(): array
    {
        $userModel = config('ticket-chat.general.user_model');
        $user = $userModel::find($this->userId);

        return [
            'conversation_id' => $this->conversation->id,
            'user' => [
                'id' => $user->id ?? $this->userId,
                'name' => $user->name ?? 'Unknown',
            ],
            'role' => $this->role,
            'joined_at' => now()->toISOString(),
        ];
    }
}
