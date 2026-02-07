<?php

namespace Karnoweb\TicketChat\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Karnoweb\TicketChat\Models\Conversation directTo(int $fromUserId, int $toUserId, ?string $message = null)
 * @method static \Karnoweb\TicketChat\Models\Conversation createGroup(string $title, array $memberIds, int $createdBy)
 * @method static \Karnoweb\TicketChat\Models\Conversation createChannel(string $title, int $createdBy)
 * @method static \Karnoweb\TicketChat\Models\Message sendMessage(\Karnoweb\TicketChat\Models\Conversation $conversation, int $userId, string $body, array $options = [])
 * @method static void markAsRead(\Karnoweb\TicketChat\Models\Conversation $conversation, int $userId)
 * @method static void typingIndicator(\Karnoweb\TicketChat\Models\Conversation $conversation, int $userId, bool $isTyping = true)
 * @method static int unreadCount(int $userId, ?\Karnoweb\TicketChat\Models\Conversation $conversation = null)
 * @method static bool addParticipant(\Karnoweb\TicketChat\Models\Conversation $conversation, int $userId, string $role = 'member')
 * @method static bool removeParticipant(\Karnoweb\TicketChat\Models\Conversation $conversation, int $userId)
 * @method static bool subscribeToChannel(\Karnoweb\TicketChat\Models\Conversation $conversation, int $userId)
 * @method static bool unsubscribeFromChannel(\Karnoweb\TicketChat\Models\Conversation $conversation, int $userId)
 * @method static \Illuminate\Support\Collection getConversationsForUser(int $userId)
 * @method static \Illuminate\Support\Collection getChannelsForUser(int $userId)
 *
 * @see \Karnoweb\TicketChat\ChatManager
 */
class Chat extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'chat';
    }
}
