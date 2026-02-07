<?php

namespace Karnoweb\TicketChat\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Karnoweb\TicketChat\Models\Conversation create(array $data)
 * @method static \Karnoweb\TicketChat\Models\Message reply(\Karnoweb\TicketChat\Models\Conversation $conversation, int $userId, string $body, array $options = [])
 * @method static \Karnoweb\TicketChat\Models\Message addNote(\Karnoweb\TicketChat\Models\Conversation $conversation, int $userId, string $body)
 * @method static bool close(\Karnoweb\TicketChat\Models\Conversation $conversation, ?int $closedBy = null)
 * @method static bool reopen(\Karnoweb\TicketChat\Models\Conversation $conversation)
 * @method static bool assign(\Karnoweb\TicketChat\Models\Conversation $conversation, int $agentId)
 * @method static bool transfer(\Karnoweb\TicketChat\Models\Conversation $conversation, int $departmentId)
 * @method static bool changeStatus(\Karnoweb\TicketChat\Models\Conversation $conversation, string $status)
 * @method static bool changePriority(\Karnoweb\TicketChat\Models\Conversation $conversation, string $priority)
 * @method static bool lock(\Karnoweb\TicketChat\Models\Conversation $conversation)
 * @method static bool unlock(\Karnoweb\TicketChat\Models\Conversation $conversation)
 * @method static int unreadCount(int $userId, ?\Karnoweb\TicketChat\Models\Conversation $conversation = null, ?int $branchId = null)
 * @method static \Illuminate\Support\Collection forUser(int $userId, ?int $branchId = null)
 * @method static \Illuminate\Support\Collection forAgent(int $agentId, ?int $branchId = null)
 * @method static \Illuminate\Support\Collection forDepartment(int $departmentId, ?int $branchId = null)
 * @method static \Karnoweb\TicketChat\Models\Conversation|null find(int $id)
 * @method static \Karnoweb\TicketChat\Models\Conversation|null findByTicketNumber(string $ticketNumber, ?int $branchId = null)
 *
 * @see \Karnoweb\TicketChat\TicketManager
 */
class Ticket extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'ticket';
    }
}
