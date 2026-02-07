<?php

namespace Karnoweb\TicketChat;

use Karnoweb\TicketChat\Models\Conversation;
use Karnoweb\TicketChat\Models\Message;
use Karnoweb\TicketChat\Contracts\ConversationServiceInterface;
use Karnoweb\TicketChat\Contracts\MessageServiceInterface;
use Karnoweb\TicketChat\Enums\ConversationType;

class TicketManager
{
    public function __construct(
        protected ConversationServiceInterface $conversationService,
        protected MessageServiceInterface $messageService
    ) {}

    public function create(array $data): Conversation
    {
        return $this->conversationService->createTicket($data);
    }

    public function reply(Conversation $conversation, int $userId, string $body, array $options = []): Message
    {
        return $this->messageService->send($conversation, $userId, $body, $options);
    }

    public function addNote(Conversation $conversation, int $userId, string $body): Message
    {
        return $this->messageService->sendInternalNote($conversation, $userId, $body);
    }

    public function close(Conversation $conversation, ?int $closedBy = null): bool
    {
        return $this->conversationService->close($conversation, $closedBy);
    }

    public function reopen(Conversation $conversation): bool
    {
        return $this->conversationService->reopen($conversation);
    }

    public function assign(Conversation $conversation, int $agentId): bool
    {
        return $this->conversationService->assign($conversation, $agentId);
    }

    public function transfer(Conversation $conversation, int $departmentId): bool
    {
        return $this->conversationService->transfer($conversation, $departmentId);
    }

    public function changeStatus(Conversation $conversation, string $status): bool
    {
        return $this->conversationService->changeStatus($conversation, $status);
    }

    public function changePriority(Conversation $conversation, string $priority): bool
    {
        return $this->conversationService->changePriority($conversation, $priority);
    }

    public function lock(Conversation $conversation): bool
    {
        return $this->conversationService->lock($conversation);
    }

    public function unlock(Conversation $conversation): bool
    {
        return $this->conversationService->unlock($conversation);
    }

    public function unreadCount(int $userId, ?Conversation $conversation = null, ?int $branchId = null): int
    {
        return $this->messageService->getUnreadCount($userId, $conversation, $branchId);
    }

    public function forUser(int $userId, ?int $branchId = null)
    {
        return Conversation::tickets()
            ->forUser($userId)
            ->when($branchId !== null, fn ($q) => $q->byBranch($branchId))
            ->latest('last_message_at')
            ->get();
    }

    public function forAgent(int $agentId, ?int $branchId = null)
    {
        return Conversation::tickets()
            ->where('assigned_to', $agentId)
            ->open()
            ->when($branchId !== null, fn ($q) => $q->byBranch($branchId))
            ->latest('last_message_at')
            ->get();
    }

    public function forDepartment(int $departmentId, ?int $branchId = null)
    {
        return Conversation::tickets()
            ->byDepartment($departmentId)
            ->open()
            ->when($branchId !== null, fn ($q) => $q->byBranch($branchId))
            ->latest('last_message_at')
            ->get();
    }

    public function find(int $id): ?Conversation
    {
        return Conversation::find($id);
    }

    public function findByTicketNumber(string $ticketNumber, ?int $branchId = null): ?Conversation
    {
        $query = Conversation::where('ticket_number', $ticketNumber);
        if ($branchId !== null) {
            $column = config('ticket-chat.general.branch_column', 'branch_id');
            $query->where($column, $branchId);
        }

        return $query->first();
    }
}
