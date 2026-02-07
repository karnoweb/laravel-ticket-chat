<?php

namespace Karnoweb\TicketChat\Commands;

use Illuminate\Console\Command;
use Karnoweb\TicketChat\Models\Conversation;
use Karnoweb\TicketChat\Enums\ConversationType;
use Karnoweb\TicketChat\Enums\TicketStatus;

class SendSlaWarningsCommand extends Command
{
    protected $signature = 'ticket-chat:sla-warnings
                            {--warning-threshold=80 : Percentage of SLA time before warning}';

    protected $description = 'Send warnings for tickets approaching SLA breach';

    public function handle(): int
    {
        if (! config('ticket-chat.sla.enabled', false)) {
            $this->warn('SLA feature is disabled.');

            return self::SUCCESS;
        }

        $threshold = (int) $this->option('warning-threshold');
        $slaConfig = config('ticket-chat.sla.response_times', []);

        $this->info("Checking for tickets at {$threshold}% of SLA...");

        $tickets = Conversation::query()
            ->where('type', ConversationType::TICKET)
            ->whereIn('status', [TicketStatus::OPEN, TicketStatus::PENDING])
            ->whereNull('first_response_at')
            ->with(['assignedAgent', 'department'])
            ->get();

        $warnings = 0;

        foreach ($tickets as $ticket) {
            $priority = $ticket->priority->value;
            $slaMinutes = $slaConfig[$priority] ?? 1440;

            $elapsedMinutes = $ticket->created_at->diffInMinutes(now());
            $percentageUsed = ($elapsedMinutes / $slaMinutes) * 100;

            if ($percentageUsed >= $threshold && $percentageUsed < 100) {
                if (class_exists(\Karnoweb\TicketChat\Notifications\SlaBreachWarningNotification::class) && $ticket->assignedAgent) {
                    $ticket->assignedAgent->notify(new \Karnoweb\TicketChat\Notifications\SlaBreachWarningNotification($ticket, $percentageUsed, (int) ($slaMinutes - $elapsedMinutes)));
                }
                $warnings++;
            } elseif ($percentageUsed >= 100 && config('ticket-chat.features.activity_log')) {
                $ticket->activities()->create([
                    'action' => 'sla_breached',
                    'meta' => ['breached_at' => now()->toISOString()],
                ]);
                $warnings++;
            }
        }

        $this->info("Sent {$warnings} SLA warnings.");

        return self::SUCCESS;
    }
}
