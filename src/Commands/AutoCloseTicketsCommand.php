<?php

namespace Karnoweb\TicketChat\Commands;

use Illuminate\Console\Command;
use Karnoweb\TicketChat\Models\Conversation;
use Karnoweb\TicketChat\Enums\ConversationType;
use Karnoweb\TicketChat\Enums\TicketStatus;
use Karnoweb\TicketChat\Facades\Ticket;

class AutoCloseTicketsCommand extends Command
{
    protected $signature = 'ticket-chat:auto-close
                            {--days= : Days of inactivity before closing}
                            {--dry-run : Show what would be closed without actually closing}';

    protected $description = 'Automatically close inactive tickets';

    public function handle(): int
    {
        if (! config('ticket-chat.features.auto_close', true)) {
            $this->warn('Auto-close feature is disabled in config.');

            return self::SUCCESS;
        }

        $days = $this->option('days') ?? config('ticket-chat.tickets.auto_close_days', 7);
        $dryRun = $this->option('dry-run');

        $this->info("Looking for tickets inactive for {$days} days...");

        $cutoffDate = now()->subDays($days);

        $tickets = Conversation::query()
            ->where('type', ConversationType::TICKET)
            ->whereIn('status', [TicketStatus::RESOLVED, TicketStatus::PENDING])
            ->where(function ($query) use ($cutoffDate) {
                $query->where('last_message_at', '<', $cutoffDate)
                    ->orWhere(function ($q) use ($cutoffDate) {
                        $q->whereNull('last_message_at')
                            ->where('updated_at', '<', $cutoffDate);
                    });
            })
            ->get();

        if ($tickets->isEmpty()) {
            $this->info('No tickets to close.');

            return self::SUCCESS;
        }

        $this->info("Found {$tickets->count()} tickets to close.");

        if ($dryRun) {
            $this->table(
                ['ID', 'Ticket Number', 'Status', 'Last Activity'],
                $tickets->map(fn ($t) => [
                    $t->id,
                    $t->ticket_number,
                    $t->status->value,
                    $t->last_message_at?->diffForHumans() ?? $t->updated_at->diffForHumans(),
                ])
            );
            $this->warn('Dry run - no tickets were closed.');

            return self::SUCCESS;
        }

        $bar = $this->output->createProgressBar($tickets->count());
        $bar->start();

        $closed = 0;
        foreach ($tickets as $ticket) {
            try {
                Ticket::close($ticket);
                app(\Karnoweb\TicketChat\Services\MessageService::class)
                    ->sendSystemMessage($ticket, 'This ticket was automatically closed due to inactivity.');
                $closed++;
            } catch (\Exception $e) {
                $this->error("Failed to close ticket {$ticket->ticket_number}: {$e->getMessage()}");
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Successfully closed {$closed} tickets.");

        return self::SUCCESS;
    }
}
