<?php

namespace Karnoweb\TicketChat\Enums;

enum ParticipantRole: string
{
    case OWNER = 'owner';
    case ADMIN = 'admin';
    case MEMBER = 'member';
    case AGENT = 'agent';
    case CUSTOMER = 'customer';

    public function canManageConversation(): bool
    {
        return in_array($this, [self::OWNER, self::ADMIN, self::AGENT]);
    }
}
