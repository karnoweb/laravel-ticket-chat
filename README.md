# Laravel Ticket Chat

A powerful ticketing and messaging system for Laravel applications.

## Features

- **Ticket System** – Support ticket management with status, priority, departments
- **Direct Messages** – One-on-one conversations
- **Group Chat** – Multi-user conversations
- **Channels** – Broadcast-style channels
- **Departments** – Organize tickets by department with agents
- **Attachments** – File upload support
- **Real-time** – Broadcasting (Reverb/Pusher) support
- **SLA** – Service level agreements (optional)
- **CSAT** – Customer satisfaction ratings
- **Tags** – Label and organize tickets
- **Canned Responses** – Pre-defined reply templates
- **Internal Notes** – Private agent notes

## Requirements

- PHP 8.3+
- Laravel 13.x

## Installation

```bash
# Laravel 13
composer require karnoweb/laravel-ticket-chat:^13.0

# Laravel 10–12
composer require karnoweb/laravel-ticket-chat:^2.0
```

Run the install command:

```bash
php artisan ticket-chat:install
```

Or manually:

```bash
php artisan vendor:publish --tag=ticket-chat-config
php artisan vendor:publish --tag=ticket-chat-migrations
php artisan migrate
```

## Configuration

Add the traits to your User model:

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Karnoweb\TicketChat\Traits\HasTickets;
use Karnoweb\TicketChat\Traits\HasConversations;
use Karnoweb\TicketChat\Traits\CanBeDepartmentAgent;

class User extends Authenticatable
{
    use HasTickets, HasConversations, CanBeDepartmentAgent;
}
```

## Usage

### Create a ticket

```php
use Karnoweb\TicketChat\Facades\Ticket;

$ticket = Ticket::create([
    'title' => 'Need help',
    'description' => 'Description here',
    'created_by' => auth()->id(),
    'department_id' => 1,
    'priority' => 'high',
    'branch_id' => 1,  // optional (v2 multi-branch)
]);
```

### Multi-branch support (v2)

When `features.multi_branch` is enabled, you can scope tickets and conversations by branch:

- **Creating:** Pass `branch_id` in the ticket data array, or as the last argument to `Chat::directTo()`, `Chat::createGroup()`, and `Chat::createChannel()`.
- **Listing:** Use the optional `$branchId` parameter on `Ticket::forUser()`, `Ticket::forAgent()`, `Ticket::forDepartment()`, `Ticket::findByTicketNumber()`, `Chat::getConversationsForUser()`, and `Chat::getChannelsForUser()`.
- **Unread count:** `Ticket::unreadCount($userId, null, $branchId)` and `Chat::unreadCount($userId, null, $branchId)` restrict the count to conversations in that branch.

If `branch_id` / `$branchId` is omitted, behaviour is unchanged (all data).

**Default branch:** When `general.default_branch_id` is set (e.g. via `TICKET_CHAT_DEFAULT_BRANCH_ID`), all creates and reads use that branch automatically when no branch is passed. Set it in `config/ticket-chat.php` or your `.env` to always scope to one branch without passing `$branchId` everywhere.

### Reply to a ticket

```php
Ticket::reply($ticket, auth()->id(), 'Your message here');
```

### Direct message

```php
use Karnoweb\TicketChat\Facades\Chat;

$conversation = Chat::directTo(auth()->id(), $otherUserId, 'Hello!');
```

### Send message

```php
Chat::sendMessage($conversation, auth()->id(), 'Message text');
```

## Artisan Commands

- `php artisan ticket-chat:install` – Install the package
- `php artisan ticket-chat:auto-close` – Auto-close inactive tickets
- `php artisan ticket-chat:cleanup-attachments` – Clean old/orphaned attachments
- `php artisan ticket-chat:sla-warnings` – Send SLA breach warnings

## Documentation

**مستندات کامل استفاده (فارسی)** در فایل [docs/USAGE.md](docs/USAGE.md) قرار دارد و شامل موارد زیر است:

- نصب و راه‌اندازی
- پیکربندی کامل
- سیستم تیکت (ایجاد، پاسخ، وضعیت، اولویت، تخصیص، انتقال)
- سیستم چت (دایرکت، گروه، کانال)
- دپارتمان‌ها و اپراتورها
- پیوست‌ها و فایل‌ها
- تگ و برچسب
- پاسخ‌های آماده (Canned Responses)
- رضایت‌سنجی (CSAT)
- SLA و زمان پاسخگویی
- آمار و گزارشات
- جستجو و فیلتر
- Real-time و Broadcasting
- نوتیفیکیشن‌ها
- دستورات Artisan
- مثال‌های کاربردی (API Controller مشتری، API Controller اپراتور، Livewire)
- بهترین شیوه‌ها
- خلاصه متدها و کلاس‌ها

## License

MIT
