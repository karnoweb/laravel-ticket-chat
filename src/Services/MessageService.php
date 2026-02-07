<?php

namespace Karnoweb\TicketChat\Services;

use Karnoweb\TicketChat\Contracts\MessageServiceInterface;
use Karnoweb\TicketChat\Models\Conversation;
use Karnoweb\TicketChat\Models\Message;
use Karnoweb\TicketChat\Enums\MessageType;
use Karnoweb\TicketChat\Events\MessageSent;
use Karnoweb\TicketChat\Events\MessageRead;
use Karnoweb\TicketChat\Exceptions\ConversationLockedException;
use Karnoweb\TicketChat\Exceptions\MessageEditExpiredException;
use Karnoweb\TicketChat\Exceptions\RateLimitExceededException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;

class MessageService implements MessageServiceInterface
{
    public function send(Conversation $conversation, int $userId, string $body, array $options = []): Message
    {
        $this->validateCanSend($conversation, $userId);

        return DB::transaction(function () use ($conversation, $userId, $body, $options) {
            $type = $options['type'] ?? MessageType::TEXT;
            if (is_string($type)) {
                $type = MessageType::from($type);
            }

            $message = Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => $userId,
                'body' => $body,
                'type' => $type,
                'reply_to_id' => $options['reply_to_id'] ?? null,
                'mentions' => $this->extractMentions($body),
                'meta' => $options['meta'] ?? null,
            ]);

            if (! empty($options['attachments'])) {
                foreach ($options['attachments'] as $attachment) {
                    $message->attachments()->create($attachment);
                }
            }

            $conversation->update(['last_message_at' => now()]);

            $this->markAsRead($message, $userId);

            $conversation->participants()->updateExistingPivot($userId, [
                'last_read_at' => now(),
            ]);

            event(new MessageSent($message));

            return $message->fresh(['attachments', 'user', 'replyTo']);
        });
    }

    public function sendInternalNote(Conversation $conversation, int $userId, string $body): Message
    {
        return $this->send($conversation, $userId, $body, [
            'type' => MessageType::INTERNAL_NOTE,
        ]);
    }

    public function sendSystemMessage(Conversation $conversation, string $body): Message
    {
        return Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => null,
            'body' => $body,
            'type' => MessageType::SYSTEM,
        ]);
    }

    public function reply(Message $message, int $userId, string $body): Message
    {
        return $this->send($message->conversation, $userId, $body, [
            'reply_to_id' => $message->id,
        ]);
    }

    public function edit(Message $message, string $newBody): bool
    {
        if (! $message->canBeEdited()) {
            throw new MessageEditExpiredException('Message edit window has expired');
        }

        return $message->update([
            'body' => $newBody,
            'is_edited' => true,
            'edited_at' => now(),
        ]);
    }

    public function delete(Message $message): bool
    {
        if (! config('ticket-chat.messages.allow_delete', false)) {
            return false;
        }

        return $message->delete();
    }

    public function markAsRead(Message $message, int $userId): void
    {
        if ($message->user_id === $userId) {
            return;
        }

        $message->markAsReadBy($userId);

        event(new MessageRead($message, $userId));
    }

    public function markConversationAsRead(Conversation $conversation, int $userId): void
    {
        $conversation->participants()->updateExistingPivot($userId, [
            'last_read_at' => now(),
        ]);

        $unreadMessages = $conversation->messages()
            ->where('user_id', '!=', $userId)
            ->whereDoesntHave('readBy', fn ($query) => $query->where('user_id', $userId))
            ->get();

        foreach ($unreadMessages as $message) {
            $this->markAsRead($message, $userId);
        }
    }

    public function getUnreadCount(int $userId, ?Conversation $conversation = null, ?int $branchId = null): int
    {
        if ($conversation) {
            return $conversation->unreadCountForUser($userId);
        }

        $prefix = config('ticket-chat.general.table_prefix', 'tc_');
        $branchColumn = config('ticket-chat.general.branch_column', 'branch_id');

        $query = DB::table($prefix.'messages as m')
            ->join($prefix.'conversation_participants as cp', 'm.conversation_id', '=', 'cp.conversation_id')
            ->join($prefix.'conversations as c', 'm.conversation_id', '=', 'c.id')
            ->leftJoin($prefix.'message_reads as mr', function ($join) use ($userId) {
                $join->on('m.id', '=', 'mr.message_id')
                    ->where('mr.user_id', '=', $userId);
            })
            ->where('cp.user_id', $userId)
            ->where('m.user_id', '!=', $userId)
            ->whereNull('mr.id')
            ->whereNull('m.deleted_at');

        if ($branchId !== null) {
            $query->where('c.'.$branchColumn, $branchId);
        }

        return (int) $query->count();
    }

    protected function validateCanSend(Conversation $conversation, int $userId): void
    {
        if ($conversation->isLocked()) {
            throw new ConversationLockedException('This conversation is locked');
        }

        if (config('ticket-chat.rate_limiting.enabled', true)) {
            $key = 'message-send:'.$userId;
            $maxAttempts = config('ticket-chat.rate_limiting.max_messages_per_minute', 30);

            if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
                throw new RateLimitExceededException('Too many messages. Please wait.');
            }

            RateLimiter::hit($key, 60);
        }
    }

    protected function extractMentions(string $body): ?array
    {
        preg_match_all('/@(\w+)/', $body, $matches);

        if (empty($matches[1])) {
            return null;
        }

        $userModel = config('ticket-chat.general.user_model');
        $userIds = $userModel::whereIn('name', $matches[1])
            ->orWhereIn('username', $matches[1])
            ->pluck('id')
            ->toArray();

        return ! empty($userIds) ? $userIds : null;
    }
}
