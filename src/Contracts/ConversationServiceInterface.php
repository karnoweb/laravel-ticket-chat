<?php

namespace Karnoweb\TicketChat\Contracts;

use Karnoweb\TicketChat\Models\Conversation;

interface ConversationServiceInterface
{
    public function createTicket(array $data): Conversation;

    public function createDirect(int $fromUserId, int $toUserId, ?string $message = null, ?int $branchId = null): Conversation;

    public function createGroup(string $title, array $userIds, int $createdBy, ?int $branchId = null): Conversation;

    public function createChannel(string $title, int $createdBy, ?int $branchId = null): Conversation;

    public function close(Conversation $conversation, ?int $closedBy = null): bool;

    public function reopen(Conversation $conversation): bool;

    public function archive(Conversation $conversation): bool;

    public function assign(Conversation $conversation, int $agentId): bool;

    public function transfer(Conversation $conversation, int $departmentId): bool;

    public function changeStatus(Conversation $conversation, string $status): bool;

    public function changePriority(Conversation $conversation, string $priority): bool;

    public function addParticipant(Conversation $conversation, int $userId, string $role = 'member'): bool;

    public function removeParticipant(Conversation $conversation, int $userId): bool;

    public function lock(Conversation $conversation): bool;

    public function unlock(Conversation $conversation): bool;
}
