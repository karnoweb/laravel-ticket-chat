<?php

namespace Karnoweb\TicketChat\Observers;

use Karnoweb\TicketChat\Models\Message;

class MessageObserver
{
    public function created(Message $message): void
    {
        if (config('ticket-chat.notifications.enabled', true)) {
            $this->sendNotifications($message);
        }

        if ($message->conversation->isTicket()
            && $message->user_id !== $message->conversation->created_by
            && ! $message->conversation->first_response_at
        ) {
            $message->conversation->update([
                'first_response_at' => now(),
            ]);
        }
    }

    protected function sendNotifications(Message $message): void
    {
        if ($message->isInternalNote() || $message->isSystem()) {
            return;
        }

        $conversation = $message->conversation;

        foreach ($conversation->participants as $participant) {
            if ($participant->id === $message->user_id) {
                continue;
            }
            if ($participant->pivot->is_muted ?? false) {
                continue;
            }
            if (class_exists(\Karnoweb\TicketChat\Notifications\NewMessageNotification::class)) {
                $participant->notify(new \Karnoweb\TicketChat\Notifications\NewMessageNotification($message));
            }
        }

        if (! empty($message->mentions) && class_exists(\Karnoweb\TicketChat\Notifications\MentionNotification::class)) {
            $userModel = config('ticket-chat.general.user_model');
            $mentionedUsers = $userModel::whereIn('id', $message->mentions)->get();
            foreach ($mentionedUsers as $user) {
                $user->notify(new \Karnoweb\TicketChat\Notifications\MentionNotification($message));
            }
        }
    }
}
