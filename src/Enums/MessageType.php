<?php

namespace Karnoweb\TicketChat\Enums;

enum MessageType: string
{
    case TEXT = 'text';
    case SYSTEM = 'system';
    case INTERNAL_NOTE = 'internal_note';
    case FILE = 'file';
    case IMAGE = 'image';

    public function isVisibleToCustomer(): bool
    {
        return $this !== self::INTERNAL_NOTE;
    }
}
