<?php

namespace Karnoweb\TicketChat\Events;

use Karnoweb\TicketChat\Models\Conversation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConversationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Conversation $conversation
    ) {}

    public function broadcastOn(): array
    {
        if (! config('ticket-chat.broadcasting.enabled', true)) {
            return [];
        }

        $channels = [];

        if ($this->conversation->isTicket() && $this->conversation->department_id) {
            $channels[] = new PrivateChannel('department.'.$this->conversation->department_id);
        }

        foreach ($this->conversation->participants as $participant) {
            $channels[] = new PrivateChannel('user.'.$participant->id);
        }

        return $channels;
    }

    public function broadcastAs(): string
    {
        return 'conversation.created';
    }

    public function broadcastWith(): array
    {
        return [
            'conversation' => [
                'id' => $this->conversation->id,
                'type' => $this->conversation->type->value,
                'ticket_number' => $this->conversation->ticket_number,
                'title' => $this->conversation->title,
                'status' => $this->conversation->status->value,
                'priority' => $this->conversation->priority->value,
                'created_at' => $this->conversation->created_at->toISOString(),
            ],
        ];
    }
}
