<?php

namespace Karnoweb\TicketChat\Contracts;

use Karnoweb\TicketChat\Models\Conversation;
use Karnoweb\TicketChat\Models\Message;

interface MessageServiceInterface
{
    public function send(Conversation $conversation, int $userId, string $body, array $options = []): Message;

    public function sendInternalNote(Conversation $conversation, int $userId, string $body): Message;

    public function reply(Message $message, int $userId, string $body): Message;

    public function edit(Message $message, string $newBody): bool;

    public function delete(Message $message): bool;

    public function markAsRead(Message $message, int $userId): void;

    public function markConversationAsRead(Conversation $conversation, int $userId): void;

    public function getUnreadCount(int $userId, ?Conversation $conversation = null): int;
}
