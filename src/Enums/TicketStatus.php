<?php

namespace Karnoweb\TicketChat\Enums;

enum TicketStatus: string
{
    case OPEN = 'open';
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::OPEN => 'Open',
            self::PENDING => 'Pending',
            self::IN_PROGRESS => 'In Progress',
            self::RESOLVED => 'Resolved',
            self::CLOSED => 'Closed',
            self::ARCHIVED => 'Archived',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::OPEN => 'blue',
            self::PENDING => 'yellow',
            self::IN_PROGRESS => 'indigo',
            self::RESOLVED => 'green',
            self::CLOSED => 'gray',
            self::ARCHIVED => 'gray',
        };
    }

    public static function allowedTransitions(self $from): array
    {
        return match ($from) {
            self::OPEN => [self::PENDING, self::IN_PROGRESS, self::CLOSED],
            self::PENDING => [self::OPEN, self::IN_PROGRESS, self::CLOSED],
            self::IN_PROGRESS => [self::PENDING, self::RESOLVED, self::CLOSED],
            self::RESOLVED => [self::CLOSED, self::OPEN],
            self::CLOSED => [self::OPEN, self::ARCHIVED],
            self::ARCHIVED => [],
        };
    }

    public function canTransitionTo(self $to): bool
    {
        return in_array($to, self::allowedTransitions($this));
    }
}
