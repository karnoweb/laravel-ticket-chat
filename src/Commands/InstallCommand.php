<?php

namespace Karnoweb\TicketChat\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'ticket-chat:install
                            {--force : Overwrite existing files}';

    protected $description = 'Install the Ticket Chat package';

    public function handle(): int
    {
        $this->info('Installing Ticket Chat...');

        $this->call('vendor:publish', [
            '--tag' => 'ticket-chat-config',
            '--force' => $this->option('force'),
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'ticket-chat-migrations',
            '--force' => $this->option('force'),
        ]);

        if ($this->confirm('Run migrations now?', true)) {
            $this->call('migrate');
        }

        $this->newLine();
        $this->info('Ticket Chat installed successfully!');
        $this->newLine();
        $this->line('Next steps:');
        $this->line('1. Add the HasTickets and HasConversations traits to your User model');
        $this->line('2. Configure your settings in config/ticket-chat.php');
        $this->line('3. Set up broadcasting if using Reverb');

        return self::SUCCESS;
    }
}
