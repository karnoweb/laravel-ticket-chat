<?php

namespace Karnoweb\TicketChat\Observers;

use Karnoweb\TicketChat\Models\Conversation;
use Karnoweb\TicketChat\Enums\TicketStatus;

class ConversationObserver
{
    public function created(Conversation $conversation): void
    {
        if (! config('ticket-chat.features.activity_log', true)) {
            return;
        }

        if ($conversation->isTicket()) {
            $conversation->activities()->create([
                'user_id' => $conversation->created_by,
                'action' => 'created',
                'meta' => [
                    'ticket_number' => $conversation->ticket_number,
                    'priority' => $conversation->priority->value,
                    'department_id' => $conversation->department_id,
                ],
            ]);
        }
    }

    public function updated(Conversation $conversation): void
    {
        if (! config('ticket-chat.features.activity_log', true)) {
            return;
        }

        if ($conversation->isDirty('status')) {
            $conversation->activities()->create([
                'user_id' => auth()->id(),
                'action' => 'status_changed',
                'meta' => [
                    'old_status' => $conversation->getOriginal('status'),
                    'new_status' => $conversation->status->value,
                ],
            ]);
        }

        if ($conversation->isDirty('priority')) {
            $conversation->activities()->create([
                'user_id' => auth()->id(),
                'action' => 'priority_changed',
                'meta' => [
                    'old_priority' => $conversation->getOriginal('priority'),
                    'new_priority' => $conversation->priority->value,
                ],
            ]);
        }

        if ($conversation->isDirty('assigned_to')) {
            $userModel = config('ticket-chat.general.user_model');
            $agent = $conversation->assigned_to ? $userModel::find($conversation->assigned_to) : null;

            $conversation->activities()->create([
                'user_id' => auth()->id(),
                'action' => 'assigned',
                'meta' => [
                    'old_agent_id' => $conversation->getOriginal('assigned_to'),
                    'new_agent_id' => $conversation->assigned_to,
                    'agent_name' => $agent?->name ?? null,
                ],
            ]);
        }

        if ($conversation->isDirty('department_id')) {
            $conversation->activities()->create([
                'user_id' => auth()->id(),
                'action' => 'transferred',
                'meta' => [
                    'old_department_id' => $conversation->getOriginal('department_id'),
                    'new_department_id' => $conversation->department_id,
                ],
            ]);
        }
    }
}
