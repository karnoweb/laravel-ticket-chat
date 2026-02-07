<?php

namespace Karnoweb\TicketChat\Services;

use Karnoweb\TicketChat\Contracts\ConversationServiceInterface;
use Karnoweb\TicketChat\Contracts\MessageServiceInterface;
use Karnoweb\TicketChat\Models\Conversation;
use Karnoweb\TicketChat\Enums\ConversationType;
use Karnoweb\TicketChat\Enums\TicketStatus;
use Karnoweb\TicketChat\Enums\TicketPriority;
use Karnoweb\TicketChat\Enums\ParticipantRole;
use Karnoweb\TicketChat\Events\ConversationCreated;
use Karnoweb\TicketChat\Events\ConversationClosed;
use Karnoweb\TicketChat\Events\ConversationAssigned;
use Karnoweb\TicketChat\Exceptions\InvalidStatusTransitionException;
use Karnoweb\TicketChat\Support\BranchResolver;
use Illuminate\Support\Facades\DB;

class ConversationService implements ConversationServiceInterface
{
    public function createTicket(array $data): Conversation
    {
        return DB::transaction(function () use ($data) {
            $conversation = new Conversation;
            $conversation->type = ConversationType::TICKET;
            $conversation->ticket_number = $conversation->generateTicketNumber();
            $conversation->title = $data['title'] ?? null;
            $conversation->description = $data['description'] ?? null;
            $conversation->status = $data['status'] ?? config('ticket-chat.tickets.default_status');
            $conversation->priority = $data['priority'] ?? config('ticket-chat.tickets.default_priority');
            $conversation->department_id = $data['department_id'] ?? null;
            $branchColumn = config('ticket-chat.general.branch_column', 'branch_id');
            $branchId = array_key_exists('branch_id', $data) ? $data['branch_id'] : BranchResolver::resolve(null);
            if ($branchId !== null) {
                $conversation->setAttribute($branchColumn, $branchId);
            }
            $conversation->created_by = $data['created_by'];
            $conversation->meta = $data['meta'] ?? null;
            $conversation->save();

            $conversation->participants()->attach($data['created_by'], [
                'role' => ParticipantRole::CUSTOMER->value,
                'joined_at' => now(),
            ]);

            if ($conversation->department) {
                $agent = $conversation->department->getNextAvailableAgent();
                if ($agent) {
                    $this->assign($conversation, $agent->id);
                }
            }

            event(new ConversationCreated($conversation));

            return $conversation->fresh();
        });
    }

    public function createDirect(int $fromUserId, int $toUserId, ?string $message = null, ?int $branchId = null): Conversation
    {
        $branchId = BranchResolver::resolve($branchId);

        return DB::transaction(function () use ($fromUserId, $toUserId, $message, $branchId) {
            $branchColumn = config('ticket-chat.general.branch_column', 'branch_id');
            $existing = Conversation::where('type', ConversationType::DIRECT)
                ->whereHas('participants', fn ($q) => $q->where('user_id', $fromUserId))
                ->whereHas('participants', fn ($q) => $q->where('user_id', $toUserId))
                ->when($branchId !== null, fn ($q) => $q->where($branchColumn, $branchId))
                ->first();

            if ($existing) {
                return $existing;
            }

            $payload = [
                'type' => ConversationType::DIRECT,
                'created_by' => $fromUserId,
            ];
            if ($branchId !== null) {
                $payload[$branchColumn] = $branchId;
            }
            $conversation = Conversation::create($payload);

            $conversation->participants()->attach([
                $fromUserId => ['role' => ParticipantRole::MEMBER->value, 'joined_at' => now()],
                $toUserId => ['role' => ParticipantRole::MEMBER->value, 'joined_at' => now()],
            ]);

            if ($message) {
                app(MessageServiceInterface::class)->send($conversation, $fromUserId, $message);
            }

            event(new ConversationCreated($conversation));

            return $conversation->fresh();
        });
    }

    public function createGroup(string $title, array $userIds, int $createdBy, ?int $branchId = null): Conversation
    {
        $branchId = BranchResolver::resolve($branchId);

        return DB::transaction(function () use ($title, $userIds, $createdBy, $branchId) {
            $payload = [
                'type' => ConversationType::GROUP,
                'title' => $title,
                'created_by' => $createdBy,
            ];
            if ($branchId !== null) {
                $payload[config('ticket-chat.general.branch_column', 'branch_id')] = $branchId;
            }
            $conversation = Conversation::create($payload);

            $conversation->participants()->attach($createdBy, [
                'role' => ParticipantRole::OWNER->value,
                'joined_at' => now(),
            ]);

            foreach ($userIds as $userId) {
                if ($userId !== $createdBy) {
                    $conversation->participants()->attach($userId, [
                        'role' => ParticipantRole::MEMBER->value,
                        'joined_at' => now(),
                    ]);
                }
            }

            event(new ConversationCreated($conversation));

            return $conversation->fresh();
        });
    }

    public function createChannel(string $title, int $createdBy, ?int $branchId = null): Conversation
    {
        $branchId = BranchResolver::resolve($branchId);

        $payload = [
            'type' => ConversationType::CHANNEL,
            'title' => $title,
            'created_by' => $createdBy,
        ];
        if ($branchId !== null) {
            $payload[config('ticket-chat.general.branch_column', 'branch_id')] = $branchId;
        }
        $conversation = Conversation::create($payload);

        $conversation->participants()->attach($createdBy, [
            'role' => ParticipantRole::ADMIN->value,
            'joined_at' => now(),
        ]);

        event(new ConversationCreated($conversation));

        return $conversation->fresh();
    }

    public function close(Conversation $conversation, ?int $closedBy = null): bool
    {
        if ($conversation->isClosed()) {
            return false;
        }

        $conversation->update([
            'status' => TicketStatus::CLOSED,
            'closed_at' => now(),
            'closed_by' => $closedBy,
        ]);

        event(new ConversationClosed($conversation));

        return true;
    }

    public function reopen(Conversation $conversation): bool
    {
        if (! $conversation->isClosed()) {
            return false;
        }

        $conversation->update([
            'status' => TicketStatus::OPEN,
            'closed_at' => null,
            'closed_by' => null,
        ]);

        return true;
    }

    public function archive(Conversation $conversation): bool
    {
        if (! $conversation->isClosed()) {
            return false;
        }

        $conversation->update(['status' => TicketStatus::ARCHIVED]);

        return true;
    }

    public function assign(Conversation $conversation, int $agentId): bool
    {
        $conversation->update(['assigned_to' => $agentId]);

        if (! $conversation->participants()->where('user_id', $agentId)->exists()) {
            $conversation->participants()->attach($agentId, [
                'role' => ParticipantRole::AGENT->value,
                'joined_at' => now(),
            ]);
        }

        event(new ConversationAssigned($conversation, $agentId));

        return true;
    }

    public function transfer(Conversation $conversation, int $departmentId): bool
    {
        $oldDepartmentId = $conversation->department_id;

        $conversation->update(['department_id' => $departmentId]);

        if (config('ticket-chat.features.activity_log')) {
            $conversation->activities()->create([
                'action' => 'transferred',
                'meta' => [
                    'from_department_id' => $oldDepartmentId,
                    'to_department_id' => $departmentId,
                ],
            ]);
        }

        return true;
    }

    public function changeStatus(Conversation $conversation, string $status): bool
    {
        $currentStatus = TicketStatus::from($conversation->status->value);
        $newStatus = TicketStatus::from($status);

        if (! $currentStatus->canTransitionTo($newStatus)) {
            throw new InvalidStatusTransitionException(
                "Cannot transition from {$currentStatus->value} to {$status}"
            );
        }

        $conversation->update(['status' => $newStatus]);

        return true;
    }

    public function changePriority(Conversation $conversation, string $priority): bool
    {
        $conversation->update(['priority' => TicketPriority::from($priority)]);

        return true;
    }

    public function addParticipant(Conversation $conversation, int $userId, string $role = 'member'): bool
    {
        if ($conversation->participants()->where('user_id', $userId)->exists()) {
            return false;
        }

        $conversation->participants()->attach($userId, [
            'role' => $role,
            'joined_at' => now(),
        ]);

        return true;
    }

    public function removeParticipant(Conversation $conversation, int $userId): bool
    {
        $conversation->participants()->updateExistingPivot($userId, [
            'left_at' => now(),
        ]);

        return true;
    }

    public function lock(Conversation $conversation): bool
    {
        return $conversation->update(['is_locked' => true]);
    }

    public function unlock(Conversation $conversation): bool
    {
        return $conversation->update(['is_locked' => false]);
    }
}
