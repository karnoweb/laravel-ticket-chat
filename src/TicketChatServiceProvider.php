<?php

namespace Karnoweb\TicketChat;

use Illuminate\Support\ServiceProvider;
use Karnoweb\TicketChat\Contracts\ConversationServiceInterface;
use Karnoweb\TicketChat\Contracts\MessageServiceInterface;
use Karnoweb\TicketChat\Services\ConversationService;
use Karnoweb\TicketChat\Services\MessageService;
use Karnoweb\TicketChat\Services\DepartmentService;
use Karnoweb\TicketChat\Services\AttachmentService;
use Karnoweb\TicketChat\Models\Conversation;
use Karnoweb\TicketChat\Models\Message;
use Karnoweb\TicketChat\Observers\ConversationObserver;
use Karnoweb\TicketChat\Observers\MessageObserver;

class TicketChatServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/ticket-chat.php',
            'ticket-chat'
        );

        $this->app->bind(ConversationServiceInterface::class, ConversationService::class);
        $this->app->bind(MessageServiceInterface::class, MessageService::class);

        $this->app->singleton(DepartmentService::class);
        $this->app->singleton(AttachmentService::class);

        $this->app->singleton('ticket', function ($app) {
            return new TicketManager(
                $app->make(ConversationServiceInterface::class),
                $app->make(MessageServiceInterface::class)
            );
        });

        $this->app->singleton('chat', function ($app) {
            return new ChatManager(
                $app->make(ConversationServiceInterface::class),
                $app->make(MessageServiceInterface::class)
            );
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/config/ticket-chat.php' => config_path('ticket-chat.php'),
        ], 'ticket-chat-config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'ticket-chat-migrations');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        Conversation::observe(ConversationObserver::class);
        Message::observe(MessageObserver::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\AutoCloseTicketsCommand::class,
                Commands\CleanupAttachmentsCommand::class,
                Commands\SendSlaWarningsCommand::class,
                Commands\InstallCommand::class,
            ]);
        }
    }

    public function provides(): array
    {
        return [
            'ticket',
            'chat',
            ConversationServiceInterface::class,
            MessageServiceInterface::class,
            DepartmentService::class,
            AttachmentService::class,
        ];
    }
}
