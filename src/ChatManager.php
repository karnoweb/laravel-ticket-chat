<?php

namespace Karnoweb\TicketChat;

use Karnoweb\TicketChat\Models\Conversation;
use Karnoweb\TicketChat\Models\Message;
use Karnoweb\TicketChat\Contracts\ConversationServiceInterface;
use Karnoweb\TicketChat\Contracts\MessageServiceInterface;
use Karnoweb\TicketChat\Events\TypingIndicator;
use Karnoweb\TicketChat\Enums\ConversationType;

class ChatManager
{
    public function __construct(
        protected ConversationServiceInterface $conversationService,
        protected MessageServiceInterface $messageService
    ) {}

    public function directTo(int $fromUserId, int $toUserId, ?string $message = null, ?int $branchId = null): Conversation
    {
        return $this->conversationService->createDirect($fromUserId, $toUserId, $message, $branchId);
    }

    public function createGroup(string $title, array $memberIds, int $createdBy, ?int $branchId = null): Conversation
    {
        return $this->conversationService->createGroup($title, $memberIds, $createdBy, $branchId);
    }

    public function createChannel(string $title, int $createdBy, ?int $branchId = null): Conversation
    {
        return $this->conversationService->createChannel($title, $createdBy, $branchId);
    }

    public function sendMessage(Conversation $conversation, int $userId, string $body, array $options = []): Message
    {
        return $this->messageService->send($conversation, $userId, $body, $options);
    }

    public function markAsRead(Conversation $conversation, int $userId): void
    {
        $this->messageService->markConversationAsRead($conversation, $userId);
    }

    public function typingIndicator(Conversation $conversation, int $userId, bool $isTyping = true): void
    {
        event(new TypingIndicator($conversation, $userId, $isTyping));
    }

    public function unreadCount(int $userId, ?Conversation $conversation = null, ?int $branchId = null): int
    {
        return $this->messageService->getUnreadCount($userId, $conversation, $branchId);
    }

    public function addParticipant(Conversation $conversation, int $userId, string $role = 'member'): bool
    {
        return $this->conversationService->addParticipant($conversation, $userId, $role);
    }

    public function removeParticipant(Conversation $conversation, int $userId): bool
    {
        return $this->conversationService->removeParticipant($conversation, $userId);
    }

    public function subscribeToChannel(Conversation $conversation, int $userId): bool
    {
        if (! $conversation->isChannel()) {
            return false;
        }

        return $this->addParticipant($conversation, $userId, 'member');
    }

    public function unsubscribeFromChannel(Conversation $conversation, int $userId): bool
    {
        if (! $conversation->isChannel()) {
            return false;
        }

        return $this->removeParticipant($conversation, $userId);
    }

    public function getConversationsForUser(int $userId, ?int $branchId = null)
    {
        return Conversation::forUser($userId)
            ->whereIn('type', [ConversationType::DIRECT, ConversationType::GROUP])
            ->when($branchId !== null, fn ($q) => $q->byBranch($branchId))
            ->latest('last_message_at')
            ->get();
    }

    public function getChannelsForUser(int $userId, ?int $branchId = null)
    {
        return Conversation::forUser($userId)
            ->where('type', ConversationType::CHANNEL)
            ->when($branchId !== null, fn ($q) => $q->byBranch($branchId))
            ->get();
    }
}
