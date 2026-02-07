<?php

namespace Karnoweb\TicketChat\Enums;

enum ConversationType: string
{
    case DIRECT = 'direct';
    case TICKET = 'ticket';
    case GROUP = 'group';
    case CHANNEL = 'channel';

    public function label(): string
    {
        return match ($this) {
            self::DIRECT => 'Direct Message',
            self::TICKET => 'Support Ticket',
            self::GROUP => 'Group Chat',
            self::CHANNEL => 'Channel',
        };
    }
}
