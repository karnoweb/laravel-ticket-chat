# 📚 مستندات کامل پکیج Laravel Ticket Chat
### سیستم جامع تیکتینگ و پیام‌رسانی برای لاراول

---

## 📋 فهرست مطالب

1. [معرفی و ویژگی‌ها](#-معرفی-پکیج)
2. [نصب و راه‌اندازی](#-نصب-و-راه‌اندازی)
3. [پیکربندی](#️-پیکربندی)
4. [سیستم تیکت](#-سیستم-تیکت)
5. [سیستم چت](#-سیستم-چت)
6. [دپارتمان‌ها](#-دپارتمانها)
7. [پیوست‌ها و فایل‌ها](#-پیوستها-و-فایلها)
8. [تگ و برچسب](#️-تگ-و-برچسب)
9. [پاسخ‌های آماده](#-پاسخهای-آماده)
10. [رضایت‌سنجی (CSAT)](#-رضایتسنجی)
11. [SLA و زمان پاسخگویی](#️-sla)
12. [آمار و گزارشات](#-آمار-و-گزارشات)
13. [جستجو و فیلتر](#-جستجو-و-فیلتر)
14. [Real-time و Broadcasting](#-real-time)
15. [نوتیفیکیشن‌ها](#-نوتیفیکیشنها)
16. [دستورات Artisan](#-دستورات-artisan)
17. [مثال‌های کاربردی](#-مثالهای-کاربردی)
18. [بهترین شیوه‌ها](#-بهترین-شیوهها)

---

## 🎯 معرفی پکیج

**Laravel Ticket Chat** یک پکیج قدرتمند و بدون وابستگی به رابط کاربری (Headless) است که امکان پیاده‌سازی سیستم پشتیبانی و پیام‌رسانی کامل را در اختیار شما قرار می‌دهد.

### چرا این پکیج؟

| ویژگی | توضیح |
|-------|--------|
| 🎯 **Headless** | بدون Controller و View - فقط منطق خالص |
| 🔌 **انعطاف‌پذیر** | قابل استفاده با API, Livewire, Inertia, Filament |
| ⚡ **Real-time** | پشتیبانی از Laravel Reverb/Pusher |
| 🏢 **Enterprise Ready** | مناسب پروژه‌های بزرگ با SLA و گزارشات |
| 🧩 **ماژولار** | هر ویژگی قابل فعال/غیرفعال کردن |

### ویژگی‌های اصلی

```
┌─────────────────────────────────────────────────────────────┐
│                    Laravel Ticket Chat                       │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  🎫 تیکت (Ticket)          💬 چت مستقیم (Direct)            │
│  ├─ شماره پیگیری خودکار    ├─ گفتگوی ۱ به ۱                │
│  ├─ اولویت‌بندی            ├─ بازیابی گفتگوی قبلی          │
│  ├─ وضعیت‌های متعدد        └─ خوانده/نخوانده               │
│  ├─ تخصیص به اپراتور                                        │
│  └─ انتقال بین دپارتمان    👥 گروه (Group)                  │
│                             ├─ چت چند نفره                  │
│  🏢 دپارتمان               ├─ مدیریت اعضا                   │
│  ├─ ساختار سلسله‌مراتبی    └─ نقش‌های مختلف                │
│  ├─ ساعت کاری                                               │
│  ├─ تخصیص خودکار           📢 کانال (Channel)               │
│  └─ اپراتورهای اختصاصی     ├─ اطلاع‌رسانی یک‌طرفه          │
│                             └─ عضویت/لغو عضویت              │
│  📎 پیوست                                                    │
│  ├─ آپلود چندتایی          🏷️ تگ و برچسب                   │
│  ├─ کنترل حجم و نوع        ├─ دسته‌بندی تیکت‌ها            │
│  └─ ذخیره روی هر Disk      └─ فیلتر بر اساس تگ             │
│                                                              │
│  📝 پاسخ آماده             ⭐ رضایت‌سنجی (CSAT)             │
│  ├─ قالب‌های از پیش آماده  ├─ امتیازدهی ۱ تا ۵             │
│  ├─ متغیرهای پویا          ├─ نظر متنی                      │
│  └─ اختصاصی هر دپارتمان    └─ گزارش‌گیری                    │
│                                                              │
│  📝 یادداشت داخلی          ⏱️ SLA                           │
│  └─ فقط قابل مشاهده        ├─ زمان پاسخگویی                 │
│     برای اپراتورها         ├─ هشدار نزدیک شدن               │
│                             └─ گزارش نقض                     │
│                                                              │
│  📊 آمار و گزارشات         🔔 Real-time                     │
│  ├─ عملکرد اپراتورها       ├─ پیام جدید                     │
│  ├─ روند تیکت‌ها           ├─ در حال تایپ                   │
│  └─ میانگین زمان پاسخ      └─ وضعیت آنلاین                  │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

---

## 📥 نصب و راه‌اندازی

### پیش‌نیازها

- PHP 8.2 یا بالاتر
- Laravel 10.x یا 11.x
- پایگاه داده MySQL/PostgreSQL/SQLite

### مرحله ۱: نصب با Composer

```bash
composer require karnoweb/laravel-ticket-chat
```

### مرحله ۲: اجرای دستور نصب

```bash
php artisan ticket-chat:install
```

این دستور به صورت خودکار:
- فایل تنظیمات را publish می‌کند
- فایل‌های migration را کپی می‌کند
- migration ها را اجرا می‌کند

### مرحله ۳: افزودن Traits به مدل User

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// اضافه کردن این use ها
use Karnoweb\TicketChat\Traits\HasTickets;
use Karnoweb\TicketChat\Traits\HasConversations;
use Karnoweb\TicketChat\Traits\CanBeDepartmentAgent;

class User extends Authenticatable
{
    use Notifiable;
    
    // اضافه کردن این Traits
    use HasTickets;           // برای کار با تیکت‌ها
    use HasConversations;     // برای کار با چت
    use CanBeDepartmentAgent; // برای اپراتورها (اختیاری)

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
```

### مرحله ۴: تنظیم Broadcasting (اختیاری)

اگر می‌خواهید از قابلیت Real-time استفاده کنید:

```bash
# نصب Laravel Reverb
php artisan install:broadcasting
```

```php
// config/ticket-chat.php
'broadcasting' => [
    'enabled' => true,
    'driver' => 'reverb',
],
```

---

## ⚙️ پیکربندی

فایل `config/ticket-chat.php` تمام تنظیمات پکیج را در اختیار شما قرار می‌دهد:

### تنظیمات عمومی

```php
'general' => [
    // مدل کاربر پروژه شما
    'user_model' => App\Models\User::class,
    
    // پیشوند جداول دیتابیس
    'table_prefix' => 'tc_',
    
    // اتصال دیتابیس (null = پیش‌فرض)
    'database_connection' => null,
],
```

### فعال/غیرفعال کردن ویژگی‌ها

```php
'features' => [
    'direct_messages' => true,    // چت مستقیم
    'groups' => true,             // گروه‌ها
    'channels' => true,           // کانال‌ها
    'departments' => true,        // دپارتمان‌ها
    'file_uploads' => true,       // آپلود فایل
    'canned_responses' => true,   // پاسخ‌های آماده
    'internal_notes' => true,     // یادداشت داخلی
    'tags' => true,               // تگ‌ها
    'csat' => true,               // رضایت‌سنجی
    'sla' => false,               // SLA (غیرفعال پیش‌فرض)
    'auto_close' => true,         // بستن خودکار
    'activity_log' => true,       // لاگ فعالیت‌ها
],
```

### تنظیمات تیکت

```php
'tickets' => [
    // اولویت‌های مجاز
    'priorities' => ['low', 'medium', 'high', 'urgent'],
    
    // وضعیت‌های مجاز
    'statuses' => ['open', 'pending', 'in_progress', 'resolved', 'closed', 'archived'],
    
    // مقادیر پیش‌فرض
    'default_priority' => 'medium',
    'default_status' => 'open',
    
    // بستن خودکار بعد از چند روز عدم فعالیت
    'auto_close_days' => 7,
    
    // حداکثر تیکت باز برای هر کاربر
    'max_open_per_user' => 10,
    
    // فرمت شماره تیکت
    'ticket_number_prefix' => 'TKT-',
    'ticket_number_length' => 8,
],
```

### تنظیمات پیام

```php
'messages' => [
    // حداکثر طول پیام
    'max_length' => 5000,
    
    // محدودیت نرخ (تعداد در دقیقه)
    'rate_limit' => 30,
    
    // امکان ویرایش پیام
    'allow_edit' => true,
    'edit_window_minutes' => 15, // تا ۱۵ دقیقه بعد از ارسال
    
    // امکان حذف پیام
    'allow_delete' => false,
],
```

### تنظیمات پیوست

```php
'attachments' => [
    // Disk ذخیره‌سازی
    'disk' => 'public',
    
    // مسیر ذخیره
    'path' => 'ticket-chat/attachments',
    
    // حداکثر حجم (مگابایت)
    'max_size_mb' => 10,
    
    // حداکثر تعداد فایل در هر پیام
    'max_files_per_message' => 5,
    
    // پسوندهای مجاز
    'allowed_mimes' => [
        'jpg', 'jpeg', 'png', 'gif', 'webp',
        'pdf', 'doc', 'docx', 'xls', 'xlsx',
        'zip', 'rar', 'txt',
    ],
    
    // ساخت thumbnail برای تصاویر
    'generate_thumbnails' => true,
],
```

### تنظیمات SLA

```php
'sla' => [
    'enabled' => true,
    
    // زمان پاسخگویی بر حسب دقیقه
    'response_times' => [
        'urgent' => 60,    // ۱ ساعت
        'high' => 240,     // ۴ ساعت
        'medium' => 1440,  // ۲۴ ساعت
        'low' => 4320,     // ۷۲ ساعت
    ],
    
    // فقط ساعات کاری حساب شود
    'business_hours_only' => true,
],
```

---

## 🎫 سیستم تیکت

سیستم تیکت هسته اصلی پکیج است و تمام قابلیت‌های یک Helpdesk حرفه‌ای را ارائه می‌دهد.

### ایجاد تیکت

```php
use Karnoweb\TicketChat\Facades\Ticket;

// ====== روش ساده ======
$ticket = Ticket::create([
    'title' => 'مشکل در ورود به حساب کاربری',
    'created_by' => auth()->id(),
]);

echo $ticket->ticket_number; // TKT-A1B2C3D4

// ====== با تمام گزینه‌ها ======
$ticket = Ticket::create([
    'title' => 'خطا در پرداخت آنلاین',
    'description' => 'هنگام پرداخت با کارت بانکی خطای ۵۰۰ دریافت می‌کنم',
    'created_by' => auth()->id(),
    'department_id' => 2,           // دپارتمان مالی
    'priority' => 'high',           // اولویت بالا
    'meta' => [                     // اطلاعات اضافی
        'order_id' => 12345,
        'payment_method' => 'card',
        'browser' => request()->userAgent(),
    ],
]);
```

### چرخه حیات تیکت

```
┌──────────┐     ┌──────────┐     ┌─────────────┐     ┌──────────┐
│   OPEN   │────▶│ PENDING  │────▶│ IN_PROGRESS │────▶│ RESOLVED │
│  (باز)   │     │(در انتظار)│     │ (در حال    │     │(حل شده) │
└──────────┘     └──────────┘     │   بررسی)   │     └──────────┘
     │                             └─────────────┘           │
     │                                   │                   │
     │                                   │                   ▼
     │                                   │            ┌──────────┐
     └───────────────────────────────────┴───────────▶│  CLOSED  │
                                                      │ (بسته)   │
                                                      └──────────┘
                                                           │
                                                           ▼
                                                     ┌──────────┐
                                                     │ ARCHIVED │
                                                     │(آرشیو شده)│
                                                     └──────────┘
```

### ارسال پاسخ

```php
// ====== پاسخ ساده ======
$message = Ticket::reply(
    conversation: $ticket,
    userId: auth()->id(),
    body: 'با سلام، مشکل شما بررسی شد و حل گردید.'
);

// ====== پاسخ به پیام خاص (Reply) ======
$message = Ticket::reply($ticket, auth()->id(), 'بله، درست است.', [
    'reply_to_id' => 15, // شناسه پیام قبلی
]);

// ====== پاسخ با پیوست ======
$message = Ticket::reply($ticket, auth()->id(), 'فایل راهنما پیوست شد.', [
    'attachments' => [
        [
            'file_name' => 'guide.pdf',
            'file_path' => 'attachments/guide.pdf',
            'mime_type' => 'application/pdf',
            'size' => 1024000,
            'disk' => 'public',
        ]
    ]
]);
```

### یادداشت داخلی

یادداشت‌هایی که فقط اپراتورها می‌بینند:

```php
// این پیام برای مشتری نمایش داده نمی‌شود
$note = Ticket::addNote(
    $ticket,
    auth()->id(),
    'مشتری VIP است - با احترام خاص برخورد شود. شماره تماس: 09121234567'
);

// بررسی اینکه پیام یادداشت داخلی است
if ($message->isInternalNote()) {
    // فقط به اپراتورها نشان بده
}
```

### مدیریت وضعیت

```php
// تغییر وضعیت
Ticket::changeStatus($ticket, 'in_progress');  // در حال بررسی
Ticket::changeStatus($ticket, 'pending');      // در انتظار پاسخ مشتری
Ticket::changeStatus($ticket, 'resolved');     // حل شده

// بستن تیکت
Ticket::close($ticket, auth()->id());

// بازگشایی تیکت بسته شده
Ticket::reopen($ticket);

// آرشیو کردن (فقط برای تیکت‌های بسته)
Ticket::archive($ticket);

// بررسی وضعیت
if ($ticket->isOpen()) {
    // تیکت باز است
}

if ($ticket->isClosed()) {
    // تیکت بسته است
}
```

### مدیریت اولویت

```php
// تغییر اولویت
Ticket::changePriority($ticket, 'urgent');

// اولویت‌های موجود:
// - low    : کم
// - medium : متوسط (پیش‌فرض)
// - high   : بالا
// - urgent : فوری

// دسترسی به اطلاعات اولویت
echo $ticket->priority->value;  // urgent
echo $ticket->priority->label(); // فوری
echo $ticket->priority->color(); // red
```

### تخصیص و انتقال

```php
// تخصیص به اپراتور
Ticket::assign($ticket, $agentId);

// انتقال به دپارتمان دیگر
Ticket::transfer($ticket, $newDepartmentId);

// قفل کردن تیکت (جلوگیری از ارسال پیام جدید)
Ticket::lock($ticket);

// باز کردن قفل
Ticket::unlock($ticket);
```

### جستجو و فیلتر تیکت‌ها

```php
use Karnoweb\TicketChat\Facades\Ticket;
use Karnoweb\TicketChat\Models\Conversation;

// ====== با Facade ======

// تیکت‌های یک کاربر
$myTickets = Ticket::forUser(auth()->id());

// تیکت‌های اختصاص داده شده به اپراتور
$assignedToMe = Ticket::forAgent(auth()->id());

// تیکت‌های یک دپارتمان
$deptTickets = Ticket::forDepartment($departmentId);

// پیدا کردن با شماره تیکت
$ticket = Ticket::findByTicketNumber('TKT-A1B2C3D4');

// تعداد تیکت‌های خوانده نشده
$unreadCount = Ticket::unreadCount(auth()->id());


// ====== با Query Builder ======

// تیکت‌های باز با اولویت بالا
$urgentOpen = Conversation::tickets()
    ->open()
    ->byPriority('urgent')
    ->latest('created_at')
    ->get();

// تیکت‌های بدون اپراتور
$unassigned = Conversation::tickets()
    ->open()
    ->whereNull('assigned_to')
    ->get();

// تیکت‌های یک دپارتمان در ۷ روز اخیر
$recentTickets = Conversation::tickets()
    ->byDepartment(1)
    ->where('created_at', '>=', now()->subDays(7))
    ->with(['creator', 'assignedAgent', 'department'])
    ->paginate(20);

// جستجو در عنوان
$searchResults = Conversation::tickets()
    ->where('title', 'like', '%پرداخت%')
    ->orWhere('ticket_number', 'like', '%A1B2%')
    ->get();
```

---

## 💬 سیستم چت

علاوه بر تیکت، پکیج سه نوع گفتگوی دیگر را نیز پشتیبانی می‌کند:

### چت مستقیم (Direct Message)

گفتگوی خصوصی بین دو نفر:

```php
use Karnoweb\TicketChat\Facades\Chat;

// شروع گفتگو با کاربر دیگر
$conversation = Chat::directTo(
    fromUserId: auth()->id(),
    toUserId: $otherUserId,
    message: 'سلام! چطور می‌تونم کمکت کنم؟' // پیام اولیه (اختیاری)
);

// 💡 نکته: اگر قبلاً گفتگویی بین این دو نفر وجود داشته باشد،
// همان گفتگو برگردانده می‌شود و گفتگوی جدید ایجاد نمی‌شود
```

### گروه (Group Chat)

گفتگوی چند نفره:

```php
// ایجاد گروه
$group = Chat::createGroup(
    title: 'تیم پشتیبانی فنی',
    memberIds: [1, 2, 3, 4, 5],
    createdBy: auth()->id()
);

// سازنده گروه نقش owner دارد
// سایر اعضا نقش member دارند

// افزودن عضو جدید
Chat::addParticipant($group, $newUserId, 'member');

// افزودن ادمین
Chat::addParticipant($group, $adminUserId, 'admin');

// حذف عضو
Chat::removeParticipant($group, $userId);
```

### کانال (Channel)

برای اطلاع‌رسانی یک‌طرفه:

```php
// ایجاد کانال
$channel = Chat::createChannel(
    title: 'اطلاعیه‌های سیستم',
    createdBy: auth()->id()
);

// فقط ادمین‌ها می‌توانند در کانال پیام بفرستند

// عضویت کاربر در کانال
Chat::subscribeToChannel($channel, $userId);

// لغو عضویت
Chat::unsubscribeFromChannel($channel, $userId);
```

### ارسال پیام در چت

```php
// ارسال پیام ساده
$message = Chat::sendMessage(
    conversation: $conversation,
    userId: auth()->id(),
    body: 'سلام! این یک پیام تست است.'
);

// ارسال با گزینه‌ها
$message = Chat::sendMessage($conversation, auth()->id(), 'پاسخ من', [
    'reply_to_id' => 10,           // پاسخ به پیام شماره ۱۰
    'meta' => ['key' => 'value'],  // داده‌های اضافی
]);
```

### مدیریت خوانده شدن

```php
// علامت‌گذاری تمام پیام‌های گفتگو به عنوان خوانده شده
Chat::markAsRead($conversation, auth()->id());

// تعداد پیام‌های خوانده نشده در یک گفتگو
$unread = Chat::unreadCount(auth()->id(), $conversation);

// تعداد کل پیام‌های خوانده نشده کاربر
$totalUnread = Chat::unreadCount(auth()->id());
```

### نشانگر تایپ (Typing Indicator)

```php
// کاربر شروع به تایپ کرده
Chat::typingIndicator($conversation, auth()->id(), true);

// کاربر تایپ را متوقف کرده
Chat::typingIndicator($conversation, auth()->id(), false);
```

### لیست گفتگوها

```php
// همه گفتگوها (دایرکت + گروه)
$conversations = Chat::getConversationsForUser(auth()->id());

// فقط کانال‌هایی که عضو هستم
$channels = Chat::getChannelsForUser(auth()->id());
```

---

## 🏢 دپارتمان‌ها

سیستم دپارتمان برای سازمان‌دهی تیکت‌ها و اپراتورها:

### ایجاد دپارتمان

```php
use Karnoweb\TicketChat\Services\DepartmentService;

$deptService = app(DepartmentService::class);

// ====== دپارتمان ساده ======
$support = $deptService->create([
    'name' => 'پشتیبانی',
]);

// ====== دپارتمان کامل ======
$technical = $deptService->create([
    'name' => 'پشتیبانی فنی',
    'slug' => 'technical-support',     // اختیاری - خودکار ساخته می‌شود
    'description' => 'رفع مشکلات فنی نرم‌افزار',
    'email' => 'tech@example.com',
    'is_active' => true,
    'is_default' => false,
    
    // استراتژی تخصیص خودکار
    'auto_assign_strategy' => 'round_robin',
    // گزینه‌ها: manual, round_robin, load_balance
    
    // ساعات کاری
    'business_hours' => [
        'saturday' => ['start' => '09:00', 'end' => '17:00'],
        'sunday' => ['start' => '09:00', 'end' => '17:00'],
        'monday' => ['start' => '09:00', 'end' => '17:00'],
        'tuesday' => ['start' => '09:00', 'end' => '17:00'],
        'wednesday' => ['start' => '09:00', 'end' => '17:00'],
        'thursday' => ['start' => '09:00', 'end' => '13:00'],
        'friday' => ['closed' => true],
    ],
]);

// ====== دپارتمان زیرمجموعه ======
$network = $deptService->create([
    'name' => 'شبکه و زیرساخت',
    'parent_id' => $technical->id, // زیرمجموعه پشتیبانی فنی
]);
```

### مدیریت اپراتورها

```php
// افزودن اپراتور
$deptService->addAgent($department, $userId, 'agent');

// افزودن ادمین دپارتمان
$deptService->addAgent($department, $userId, 'admin');

// حذف اپراتور
$deptService->removeAgent($department, $userId);

// تنظیم دپارتمان پیش‌فرض
$deptService->setDefault($department);
```

### کار با دپارتمان‌ها

```php
use Karnoweb\TicketChat\Models\Department;

// لیست دپارتمان‌های فعال
$departments = Department::active()->get();

// دپارتمان پیش‌فرض
$default = Department::default()->first();

// اپراتورهای یک دپارتمان
$agents = $department->agents;
$admins = $department->admins;

// تیکت‌های دپارتمان
$tickets = $department->conversations()->tickets()->get();

// بررسی ساعت کاری
if ($department->isWithinBusinessHours()) {
    // در ساعت کاری هستیم
}

// ساختار درختی دپارتمان‌ها
$tree = $deptService->getTree();
```

### تخصیص خودکار

```php
// در config/ticket-chat.php دپارتمان را تنظیم کنید:
// 'auto_assign_strategy' => 'round_robin'

// وقتی تیکت ایجاد می‌شود، خودکار به یک اپراتور تخصیص داده می‌شود

// استراتژی‌های موجود:
// - manual      : تخصیص دستی (پیش‌فرض)
// - round_robin : چرخشی (هر تیکت به نفر بعدی)
// - load_balance: بر اساس بار کاری (به کسی که کمترین تیکت باز دارد)
```

---

## 📎 پیوست‌ها و فایل‌ها

### آپلود فایل

```php
use Karnoweb\TicketChat\Services\AttachmentService;

$attachmentService = app(AttachmentService::class);

// آپلود یک فایل
$attachment = $attachmentService->upload($message, $uploadedFile);

// آپلود چند فایل
$attachments = $attachmentService->uploadMultiple($message, $uploadedFiles);

// دسترسی به URL
$url = $attachment->url;
$thumbnailUrl = $attachment->thumbnail_url; // برای تصاویر

// اطلاعات فایل
echo $attachment->file_name;   // document.pdf
echo $attachment->mime_type;   // application/pdf
echo $attachment->human_size;  // 2.5 MB

// بررسی نوع فایل
if ($attachment->isImage()) { /* تصویر */ }
if ($attachment->isPdf()) { /* PDF */ }
if ($attachment->isDocument()) { /* سند */ }
```

### مثال آپلود در Controller

```php
public function uploadAttachment(Request $request, Conversation $ticket)
{
    $request->validate([
        'files.*' => 'required|file|max:10240', // حداکثر 10MB
    ]);

    // ابتدا یک پیام بسازید
    $message = Ticket::reply($ticket, auth()->id(), $request->message ?? '');

    // سپس فایل‌ها را آپلود کنید
    $attachmentService = app(AttachmentService::class);
    
    foreach ($request->file('files') as $file) {
        $attachmentService->upload($message, $file);
    }

    return response()->json([
        'message' => $message->load('attachments'),
    ]);
}
```

### حذف فایل

```php
$attachmentService->delete($attachment);
// هم فایل از storage و هم رکورد از دیتابیس حذف می‌شود
```

---

## 🏷️ تگ و برچسب

برای دسته‌بندی و سازمان‌دهی تیکت‌ها:

### ایجاد و مدیریت تگ

```php
use Karnoweb\TicketChat\Services\TagService;

$tagService = app(TagService::class);

// ایجاد تگ
$bugTag = $tagService->create([
    'name' => 'باگ',
    'color' => '#ff0000',
    'description' => 'گزارش‌های باگ نرم‌افزاری',
]);

$featureTag = $tagService->create([
    'name' => 'درخواست ویژگی',
    'color' => '#00ff00',
]);
```

### اختصاص تگ به تیکت

```php
// افزودن تگ با ID
$tagService->attachToConversation($ticket, [1, 2, 3]);

// افزودن تگ با نام (خودکار ایجاد می‌شود اگر وجود نداشته باشد)
$tagService->attachToConversation($ticket, ['باگ', 'فوری', 'مالی']);

// حذف تگ
$tagService->detachFromConversation($ticket, $tagId);

// همگام‌سازی (حذف قبلی‌ها، اضافه کردن جدیدها)
$tagService->syncConversationTags($ticket, [1, 4, 5]);
```

### جستجو و فیلتر با تگ

```php
// تگ‌های یک تیکت
$tags = $ticket->tags;

// تیکت‌های دارای تگ خاص
$tickets = Conversation::tickets()
    ->whereHas('tags', function ($q) {
        $q->where('slug', 'bug');
    })
    ->get();

// تگ‌های پرکاربرد
$popularTags = $tagService->getPopularTags(10);

// جستجوی تگ
$tags = $tagService->search('با');
```

---

## 📝 پاسخ‌های آماده

قالب‌های از پیش آماده برای پاسخگویی سریع:

### ایجاد پاسخ آماده

```php
use Karnoweb\TicketChat\Services\CannedResponseService;

$cannedService = app(CannedResponseService::class);

// پاسخ آماده عمومی
$welcome = $cannedService->create([
    'title' => 'خوش‌آمدگویی',
    'shortcut' => '/welcome',
    'body' => 'سلام {customer_name} عزیز،

از تماس شما با پشتیبانی متشکریم.
شماره پیگیری تیکت شما: {ticket_number}

همکاران ما در اسرع وقت پاسخگوی شما خواهند بود.

با احترام،
تیم پشتیبانی',
]);

// پاسخ آماده اختصاصی دپارتمان
$paymentIssue = $cannedService->create([
    'title' => 'مشکل پرداخت',
    'shortcut' => '/payment-issue',
    'body' => 'برای بررسی مشکل پرداخت، لطفاً موارد زیر را ارسال کنید:
1. شماره تراکنش
2. تاریخ و ساعت تراکنش
3. مبلغ تراکنش
4. اسکرین‌شات از خطا',
    'department_id' => 2, // دپارتمان مالی
]);
```

### استفاده از پاسخ آماده

```php
// پیدا کردن با shortcut
$response = $cannedService->findByShortcut('/welcome');

// رندر کردن با جایگزینی متغیرها
$renderedText = $cannedService->render($response, $ticket);
// متغیرهای {customer_name} و {ticket_number} جایگزین می‌شوند

// ارسال پاسخ
Ticket::reply($ticket, auth()->id(), $renderedText);
```

### متغیرهای قابل استفاده

| متغیر | توضیح |
|-------|--------|
| `{ticket_number}` | شماره تیکت |
| `{ticket_title}` | عنوان تیکت |
| `{customer_name}` | نام مشتری |
| `{agent_name}` | نام اپراتور |
| `{department_name}` | نام دپارتمان |
| `{current_date}` | تاریخ امروز |
| `{current_time}` | ساعت فعلی |

### لیست پاسخ‌های آماده

```php
// پاسخ‌های یک دپارتمان (شامل عمومی‌ها)
$responses = $cannedService->getForDepartment($departmentId);

// جستجو
$results = $cannedService->search('پرداخت', $departmentId);
```

---

## ⭐ رضایت‌سنجی

امتیازدهی مشتریان پس از بسته شدن تیکت:

### ثبت امتیاز

```php
use Karnoweb\TicketChat\Services\FeedbackService;

$feedbackService = app(FeedbackService::class);

// ثبت امتیاز (معمولاً توسط مشتری بعد از بسته شدن تیکت)
$feedback = $feedbackService->submit(
    conversation: $ticket,
    userId: auth()->id(),
    rating: 5,                        // ۱ تا ۵
    comment: 'پشتیبانی عالی بود!'    // اختیاری
);
```

### دریافت آمار

```php
// امتیاز یک تیکت
$feedback = $feedbackService->getForConversation($ticket);

// میانگین امتیاز کلی
$avgRating = $feedbackService->getAverageRating();

// میانگین امتیاز یک دپارتمان
$avgRating = $feedbackService->getAverageRating(departmentId: 2);

// میانگین امتیاز یک اپراتور
$avgRating = $feedbackService->getAverageRating(agentId: 5);

// آمار کامل
$stats = $feedbackService->getStatistics($departmentId);
// خروجی:
// [
//     'total' => 150,
//     'average' => 4.2,
//     'distribution' => [
//         1 => 5,   // ۵ نفر امتیاز ۱
//         2 => 10,  // ۱۰ نفر امتیاز ۲
//         3 => 20,  // ...
//         4 => 50,
//         5 => 65,
//     ],
//     'positive_percentage' => 76.7, // درصد امتیازهای مثبت
// ]
```

---

## ⏱️ SLA

مدیریت زمان پاسخگویی و تضمین کیفیت:

### فعال‌سازی

```php
// config/ticket-chat.php
'sla' => [
    'enabled' => true,
    
    'response_times' => [
        'urgent' => 60,    // ۱ ساعت
        'high' => 240,     // ۴ ساعت
        'medium' => 1440,  // ۲۴ ساعت
        'low' => 4320,     // ۷۲ ساعت
    ],
    
    'business_hours_only' => true,
],
```

### بررسی وضعیت SLA

```php
use Karnoweb\TicketChat\Services\SlaService;

$slaService = app(SlaService::class);

// وضعیت کامل SLA
$status = $slaService->getSlaStatus($ticket);
// [
//     'status' => 'warning',        // ok, warning, breached
//     'percentage_used' => 85.5,    // درصد استفاده شده
//     'minutes_remaining' => 45,    // دقایق باقی‌مانده
//     'deadline' => '2024-01-15T14:30:00Z',
//     'already_responded' => false,
// ]

// محاسبه deadline
$deadline = $slaService->calculateDeadline($ticket);

// زمان باقی‌مانده (دقیقه)
$remaining = $slaService->getTimeRemaining($ticket);

// بررسی وضعیت
if ($slaService->isBreached($ticket)) {
    // SLA نقض شده!
}

if ($slaService->isWarning($ticket, threshold: 80)) {
    // نزدیک به deadline (۸۰٪ استفاده شده)
}
```

### هشدار خودکار

```bash
# اجرای دستی
php artisan ticket-chat:sla-warnings

# زمان‌بندی در Kernel.php
$schedule->command('ticket-chat:sla-warnings')
    ->everyFifteenMinutes();
```

---

## 📊 آمار و گزارشات

### نمای کلی

```php
use Karnoweb\TicketChat\Services\StatisticsService;

$statsService = app(StatisticsService::class);

// آمار کلی
$overview = $statsService->getOverview();
// [
//     'total_tickets' => 150,
//     'open_tickets' => 25,
//     'closed_tickets' => 100,
//     'resolved_tickets' => 25,
//     'resolution_rate' => 83.3,
// ]

// آمار یک دپارتمان
$deptStats = $statsService->getOverview(departmentId: 2);

// آمار یک بازه زمانی
$monthStats = $statsService->getOverview(
    from: now()->startOfMonth(),
    to: now()->endOfMonth()
);
```

### تفکیک بر اساس وضعیت و اولویت

```php
// تیکت‌ها بر اساس وضعیت
$byStatus = $statsService->getTicketsByStatus();
// ['open' => 25, 'pending' => 10, 'in_progress' => 15, 'closed' => 100]

// تیکت‌ها بر اساس اولویت
$byPriority = $statsService->getTicketsByPriority();
// ['low' => 30, 'medium' => 50, 'high' => 15, 'urgent' => 5]
```

### روند تیکت‌ها

```php
// تعداد تیکت‌های روزانه در ۳۰ روز اخیر
$trend = $statsService->getTicketsTrend(days: 30);
// ['2024-01-01' => 5, '2024-01-02' => 8, '2024-01-03' => 12, ...]
```

### میانگین زمان‌ها

```php
// میانگین زمان اولین پاسخ (دقیقه)
$avgResponse = $statsService->getAverageResponseTime();

// میانگین زمان حل مشکل (ساعت)
$avgResolution = $statsService->getAverageResolutionTime();
```

### عملکرد اپراتور

```php
$agentStats = $statsService->getAgentPerformance($agentId);
// [
//     'tickets_assigned' => 50,    // تیکت‌های تخصیص داده شده
//     'tickets_closed' => 45,      // تیکت‌های بسته شده
//     'messages_sent' => 200,      // پیام‌های ارسالی
//     'average_rating' => 4.5,     // میانگین امتیاز
// ]
```

### عملکرد دپارتمان‌ها

```php
$deptPerformance = $statsService->getDepartmentPerformance();
// [
//     [
//         'id' => 1,
//         'name' => 'پشتیبانی فنی',
//         'total_tickets' => 80,
//         'closed_tickets' => 65,
//         'avg_response_minutes' => 45,
//     ],
//     ...
// ]
```

---

## 🔍 جستجو و فیلتر

### جستجوی پیشرفته

```php
use Karnoweb\TicketChat\Services\SearchService;

$searchService = app(SearchService::class);

$results = $searchService->searchConversations([
    // نوع
    'type' => 'ticket',
    
    // وضعیت (می‌تواند آرایه باشد)
    'status' => ['open', 'pending'],
    
    // اولویت
    'priority' => 'high',
    
    // دپارتمان
    'department_id' => 1,
    
    // اپراتور اختصاص داده شده
    'assigned_to' => 5,
    
    // بدون اپراتور
    'unassigned' => true,
    
    // ایجاد کننده
    'created_by' => 10,
    
    // بازه تاریخ
    'date_from' => '2024-01-01',
    'date_to' => '2024-01-31',
    
    // تگ‌ها
    'tags' => [1, 2, 3],
    
    // جستجو در عنوان و توضیحات
    'keyword' => 'پرداخت',
    
    // جستجو در متن پیام‌ها
    'message_search' => 'خطای شبکه',
    
    // فقط گفتگوهای دارای پیام خوانده نشده
    'has_unread' => true,
    'user_id' => auth()->id(),
    
    // مرتب‌سازی
    'sort_by' => 'last_message_at', // created_at, updated_at, priority, status
    'sort_dir' => 'desc',
])->paginate(20);
```

### جستجو در پیام‌های یک گفتگو

```php
$messages = $searchService->searchMessages($conversation, 'کلمه کلیدی');
```

### جستجوی سریع

```php
$results = $searchService->quickSearch('پرداخت', auth()->id());
// [
//     'tickets' => [...],   // تیکت‌های مرتبط
//     'messages' => [...],  // پیام‌های مرتبط
// ]
```

---

## 🔔 Real-time

### پیکربندی

```php
// config/ticket-chat.php
'broadcasting' => [
    'enabled' => true,
    'driver' => 'reverb',
    
    'events' => [
        'message_sent' => true,
        'message_read' => true,
        'conversation_closed' => true,
        'conversation_assigned' => true,
        'typing_indicator' => true,
        'participant_joined' => true,
        'participant_left' => true,
        'new_ticket_created' => true,
    ],
],
```

### کانال‌ها

```php
// routes/channels.php

use Illuminate\Support\Facades\Broadcast;
use Karnoweb\TicketChat\Models\Conversation;

// کانال گفتگو (Private)
Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    $conversation = Conversation::find($conversationId);
    return $conversation && $conversation->participants->contains('id', $user->id);
});

// کانال کاربر
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// کانال دپارتمان
Broadcast::channel('department.{departmentId}', function ($user, $departmentId) {
    return $user->departments->contains('id', $departmentId);
});
```

### گوش دادن در Frontend

```javascript
// با استفاده از Laravel Echo

// گوش دادن به پیام‌های جدید
Echo.private(`conversation.${conversationId}`)
    .listen('.message.sent', (e) => {
        console.log('پیام جدید:', e.message);
        // اضافه کردن پیام به لیست
        appendMessage(e.message);
    })
    .listen('.message.read', (e) => {
        console.log('پیام خوانده شد:', e.message_id);
        // نمایش تیک آبی
        markAsRead(e.message_id);
    })
    .listen('.user.typing', (e) => {
        if (e.is_typing) {
            showTypingIndicator(e.user_id);
        } else {
            hideTypingIndicator(e.user_id);
        }
    })
    .listen('.conversation.closed', (e) => {
        console.log('گفتگو بسته شد');
        disableInput();
    });

// گوش دادن به تیکت‌های جدید (برای اپراتور)
Echo.private(`department.${departmentId}`)
    .listen('.conversation.created', (e) => {
        console.log('تیکت جدید:', e.conversation);
        showNotification('تیکت جدید دریافت شد');
    });

// نوتیفیکیشن‌های شخصی
Echo.private(`user.${userId}`)
    .listen('.conversation.assigned', (e) => {
        console.log('تیکت به شما اختصاص داده شد:', e.ticket_number);
    });
```

---

## 🔔 نوتیفیکیشن‌ها

### پیکربندی

```php
// config/ticket-chat.php
'notifications' => [
    'enabled' => true,
    'channels' => ['mail', 'database'],
    
    'events' => [
        'ticket_created' => true,
        'ticket_replied' => true,
        'ticket_assigned' => true,
        'ticket_status_changed' => true,
        'ticket_closed' => true,
        'mention' => true,
        'sla_breach_warning' => true,
    ],
],
```

### Event ها و Listener ها

```php
// app/Providers/EventServiceProvider.php

use Karnoweb\TicketChat\Events\ConversationCreated;
use Karnoweb\TicketChat\Events\ConversationClosed;
use Karnoweb\TicketChat\Events\ConversationAssigned;
use Karnoweb\TicketChat\Events\MessageSent;

protected $listen = [
    ConversationCreated::class => [
        SendNewTicketNotification::class,
        NotifyDepartmentAgents::class,
    ],
    MessageSent::class => [
        SendNewMessageNotification::class,
        SendMentionNotification::class,
    ],
    ConversationAssigned::class => [
        NotifyAssignedAgent::class,
    ],
    ConversationClosed::class => [
        SendTicketClosedNotification::class,
        SendCSATRequest::class,
    ],
];
```

### مثال Listener

```php
<?php

namespace App\Listeners;

use Karnoweb\TicketChat\Events\MessageSent;
use App\Notifications\NewMessageNotification;

class SendNewMessageNotification
{
    public function handle(MessageSent $event): void
    {
        $message = $event->message;
        $conversation = $message->conversation;
        
        // به همه شرکت‌کنندگان (به جز فرستنده) نوتیفیکیشن بفرست
        foreach ($conversation->participants as $participant) {
            if ($participant->id === $message->user_id) {
                continue;
            }
            
            if ($participant->pivot->is_muted) {
                continue;
            }
            
            $participant->notify(new NewMessageNotification($message));
        }
    }
}
```

---

## ⌨️ دستورات Artisan

### نصب

```bash
php artisan ticket-chat:install
php artisan ticket-chat:install --force  # بازنویسی فایل‌ها
```

### بستن خودکار تیکت‌های غیرفعال

```bash
# بستن تیکت‌هایی که ۷ روز (پیش‌فرض) فعالیتی نداشتند
php artisan ticket-chat:auto-close

# با تعداد روز سفارشی
php artisan ticket-chat:auto-close --days=14

# فقط نمایش (بدون بستن واقعی)
php artisan ticket-chat:auto-close --dry-run
```

### پاکسازی پیوست‌ها

```bash
# حذف پیوست‌های قدیمی‌تر از ۹۰ روز
php artisan ticket-chat:cleanup-attachments --older-than=90

# حذف فایل‌های یتیم (بدون رکورد در دیتابیس)
php artisan ticket-chat:cleanup-attachments --orphaned

# فقط نمایش
php artisan ticket-chat:cleanup-attachments --dry-run
```

### هشدار SLA

```bash
php artisan ticket-chat:sla-warnings
php artisan ticket-chat:sla-warnings --warning-threshold=70
```

### زمان‌بندی

```php
// app/Console/Kernel.php

protected function schedule(Schedule $schedule): void
{
    // بستن خودکار - هر روز ساعت ۲ صبح
    $schedule->command('ticket-chat:auto-close')
        ->dailyAt('02:00');

    // چک SLA - هر ۱۵ دقیقه
    $schedule->command('ticket-chat:sla-warnings')
        ->everyFifteenMinutes();

    // پاکسازی فایل‌ها - هفته‌ای یکبار
    $schedule->command('ticket-chat:cleanup-attachments --orphaned')
        ->weekly();
}
```

---

## 🎯 مثال‌های کاربردی

### مثال ۱: API Controller برای مشتریان

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Karnoweb\TicketChat\Facades\Ticket;
use Karnoweb\TicketChat\Facades\Chat;
use Karnoweb\TicketChat\Models\Conversation;
use Karnoweb\TicketChat\Models\Department;
use Karnoweb\TicketChat\Services\AttachmentService;
use Karnoweb\TicketChat\Services\FeedbackService;

class CustomerTicketController extends Controller
{
    public function __construct(
        private AttachmentService $attachmentService,
        private FeedbackService $feedbackService
    ) {}

    /**
     * لیست تیکت‌های من
     */
    public function index(Request $request): JsonResponse
    {
        $tickets = Conversation::tickets()
            ->forUser(auth()->id())
            ->when($request->status, fn($q, $s) => $q->byStatus($s))
            ->with(['department:id,name', 'assignedAgent:id,name'])
            ->withCount(['messages'])
            ->latest('last_message_at')
            ->paginate(15);

        // اضافه کردن تعداد پیام‌های خوانده نشده
        $tickets->each(function ($ticket) {
            $ticket->unread_count = $ticket->unreadCountForUser(auth()->id());
        });

        return response()->json([
            'success' => true,
            'data' => $tickets,
            'total_unread' => Ticket::unreadCount(auth()->id()),
        ]);
    }

    /**
     * ایجاد تیکت جدید
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:255',
            'message' => 'required|string|min:10|max:5000',
            'department_id' => 'nullable|exists:tc_departments,id',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'attachments.*' => 'nullable|file|max:10240|mimes:jpg,png,pdf,doc,docx',
        ]);

        // ایجاد تیکت
        $ticket = Ticket::create([
            'title' => $validated['title'],
            'created_by' => auth()->id(),
            'department_id' => $validated['department_id'],
            'priority' => $validated['priority'] ?? 'medium',
        ]);

        // ارسال پیام اولیه
        $message = Ticket::reply($ticket, auth()->id(), $validated['message']);

        // آپلود پیوست‌ها
        if ($request->hasFile('attachments')) {
            $this->attachmentService->uploadMultiple(
                $message,
                $request->file('attachments')
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'تیکت با موفقیت ایجاد شد',
            'data' => [
                'ticket' => $ticket->load(['department', 'messages.attachments']),
                'ticket_number' => $ticket->ticket_number,
            ],
        ], 201);
    }

    /**
     * نمایش تیکت
     */
    public function show(int $id): JsonResponse
    {
        $ticket = Conversation::tickets()
            ->forUser(auth()->id())
            ->with([
                'department:id,name',
                'assignedAgent:id,name',
                'tags:id,name,color',
                'messages' => fn($q) => $q->visible()
                    ->with(['user:id,name', 'attachments', 'replyTo:id,body,user_id'])
                    ->oldest(),
                'feedback',
            ])
            ->findOrFail($id);

        // علامت‌گذاری به عنوان خوانده شده
        Chat::markAsRead($ticket, auth()->id());

        return response()->json([
            'success' => true,
            'data' => $ticket,
        ]);
    }

    /**
     * ارسال پاسخ
     */
    public function reply(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|min:1|max:5000',
            'attachments.*' => 'nullable|file|max:10240',
        ]);

        $ticket = Conversation::tickets()
            ->forUser(auth()->id())
            ->findOrFail($id);

        // بررسی اینکه تیکت بسته نباشد
        if ($ticket->isClosed()) {
            return response()->json([
                'success' => false,
                'message' => 'امکان ارسال پیام در تیکت بسته وجود ندارد',
            ], 422);
        }

        $message = Ticket::reply($ticket, auth()->id(), $validated['message']);

        if ($request->hasFile('attachments')) {
            $this->attachmentService->uploadMultiple(
                $message,
                $request->file('attachments')
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'پیام ارسال شد',
            'data' => $message->load(['user:id,name', 'attachments']),
        ]);
    }

    /**
     * بستن تیکت توسط مشتری
     */
    public function close(int $id): JsonResponse
    {
        $ticket = Conversation::tickets()
            ->forUser(auth()->id())
            ->findOrFail($id);

        if ($ticket->isClosed()) {
            return response()->json([
                'success' => false,
                'message' => 'تیکت قبلاً بسته شده است',
            ], 422);
        }

        Ticket::close($ticket, auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'تیکت با موفقیت بسته شد',
        ]);
    }

    /**
     * ثبت امتیاز
     */
    public function rate(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $ticket = Conversation::tickets()
            ->forUser(auth()->id())
            ->findOrFail($id);

        if (!$ticket->isClosed()) {
            return response()->json([
                'success' => false,
                'message' => 'امتیازدهی فقط برای تیکت‌های بسته امکان‌پذیر است',
            ], 422);
        }

        $feedback = $this->feedbackService->submit(
            $ticket,
            auth()->id(),
            $validated['rating'],
            $validated['comment']
        );

        return response()->json([
            'success' => true,
            'message' => 'از امتیاز شما متشکریم',
            'data' => $feedback,
        ]);
    }

    /**
     * لیست دپارتمان‌ها
     */
    public function departments(): JsonResponse
    {
        $departments = Department::active()
            ->select('id', 'name', 'description')
            ->orderBy('order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $departments,
        ]);
    }
}
```

### مثال ۲: API Controller برای اپراتورها

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Karnoweb\TicketChat\Facades\Ticket;
use Karnoweb\TicketChat\Facades\Chat;
use Karnoweb\TicketChat\Models\Conversation;
use Karnoweb\TicketChat\Services\SearchService;
use Karnoweb\TicketChat\Services\StatisticsService;
use Karnoweb\TicketChat\Services\CannedResponseService;
use Karnoweb\TicketChat\Services\TagService;

class AgentTicketController extends Controller
{
    public function __construct(
        private SearchService $searchService,
        private StatisticsService $statsService,
        private CannedResponseService $cannedService,
        private TagService $tagService
    ) {}

    /**
     * داشبورد اپراتور
     */
    public function dashboard(): JsonResponse
    {
        $agentId = auth()->id();

        return response()->json([
            // آمار کلی
            'overview' => $this->statsService->getOverview(),
            
            // آمار شخصی اپراتور
            'my_stats' => $this->statsService->getAgentPerformance($agentId),
            
            // تیکت‌های من
            'my_open_tickets' => Ticket::forAgent($agentId)->count(),
            
            // تیکت‌های بدون اپراتور
            'unassigned_tickets' => Conversation::tickets()
                ->open()
                ->whereNull('assigned_to')
                ->count(),
            
            // نمودار روند
            'trend' => $this->statsService->getTicketsTrend(days: 7),
        ]);
    }

    /**
     * لیست تیکت‌ها با فیلتر پیشرفته
     */
    public function index(Request $request): JsonResponse
    {
        $tickets = $this->searchService->searchConversations([
            'type' => 'ticket',
            'status' => $request->status,
            'priority' => $request->priority,
            'department_id' => $request->department_id,
            'assigned_to' => $request->assigned_to,
            'unassigned' => $request->boolean('unassigned'),
            'keyword' => $request->keyword,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'tags' => $request->tags,
            'sort_by' => $request->sort_by ?? 'last_message_at',
            'sort_dir' => $request->sort_dir ?? 'desc',
        ])
            ->with(['creator:id,name,email', 'assignedAgent:id,name', 'department:id,name', 'tags:id,name,color'])
            ->withCount('messages')
            ->paginate($request->per_page ?? 20);

        return response()->json($tickets);
    }

    /**
     * نمایش تیکت
     */
    public function show(int $id): JsonResponse
    {
        $ticket = Conversation::tickets()
            ->with([
                'creator:id,name,email',
                'assignedAgent:id,name',
                'department',
                'tags:id,name,color',
                'messages' => fn($q) => $q->with(['user:id,name', 'attachments', 'replyTo:id,body'])->oldest(),
                'activities' => fn($q) => $q->with('user:id,name')->latest()->limit(20),
                'feedback',
            ])
            ->findOrFail($id);

        // SLA Status
        $slaStatus = app(\Karnoweb\TicketChat\Services\SlaService::class)->getSlaStatus($ticket);

        Chat::markAsRead($ticket, auth()->id());

        return response()->json([
            'ticket' => $ticket,
            'sla' => $slaStatus,
        ]);
    }

    /**
     * پاسخ اپراتور
     */
    public function reply(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'is_internal' => 'boolean',
        ]);

        $ticket = Conversation::findOrFail($id);

        if ($validated['is_internal'] ?? false) {
            $message = Ticket::addNote($ticket, auth()->id(), $validated['message']);
        } else {
            $message = Ticket::reply($ticket, auth()->id(), $validated['message']);
        }

        return response()->json([
            'success' => true,
            'data' => $message->load(['user:id,name', 'attachments']),
        ]);
    }

    /**
     * تخصیص تیکت
     */
    public function assign(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'agent_id' => 'required|exists:users,id',
        ]);

        $ticket = Conversation::findOrFail($id);
        Ticket::assign($ticket, $validated['agent_id']);

        return response()->json([
            'success' => true,
            'message' => 'تیکت تخصیص داده شد',
        ]);
    }

    /**
     * گرفتن تیکت (تخصیص به خودم)
     */
    public function claim(int $id): JsonResponse
    {
        $ticket = Conversation::findOrFail($id);
        Ticket::assign($ticket, auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'تیکت به شما اختصاص داده شد',
        ]);
    }

    /**
     * انتقال به دپارتمان دیگر
     */
    public function transfer(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:tc_departments,id',
            'note' => 'nullable|string', // یادداشت برای دپارتمان جدید
        ]);

        $ticket = Conversation::findOrFail($id);
        
        // یادداشت انتقال
        if (!empty($validated['note'])) {
            Ticket::addNote($ticket, auth()->id(), 
                "انتقال به دپارتمان دیگر:\n" . $validated['note']
            );
        }

        Ticket::transfer($ticket, $validated['department_id']);

        return response()->json([
            'success' => true,
            'message' => 'تیکت منتقل شد',
        ]);
    }

    /**
     * تغییر وضعیت
     */
    public function changeStatus(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:open,pending,in_progress,resolved,closed',
        ]);

        $ticket = Conversation::findOrFail($id);
        Ticket::changeStatus($ticket, $validated['status']);

        return response()->json([
            'success' => true,
            'message' => 'وضعیت تغییر کرد',
        ]);
    }

    /**
     * تغییر اولویت
     */
    public function changePriority(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $ticket = Conversation::findOrFail($id);
        Ticket::changePriority($ticket, $validated['priority']);

        return response()->json([
            'success' => true,
            'message' => 'اولویت تغییر کرد',
        ]);
    }

    /**
     * مدیریت تگ‌ها
     */
    public function updateTags(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'tags' => 'array',
            'tags.*' => 'string',
        ]);

        $ticket = Conversation::findOrFail($id);
        $this->tagService->syncConversationTags($ticket, $validated['tags'] ?? []);

        return response()->json([
            'success' => true,
            'message' => 'تگ‌ها به‌روزرسانی شدند',
            'tags' => $ticket->fresh()->tags,
        ]);
    }

    /**
     * پاسخ‌های آماده
     */
    public function cannedResponses(Request $request): JsonResponse
    {
        $responses = $this->cannedService->getForDepartment($request->department_id);

        return response()->json([
            'success' => true,
            'data' => $responses,
        ]);
    }

    /**
     * رندر پاسخ آماده
     */
    public function renderCannedResponse(Request $request, int $ticketId): JsonResponse
    {
        $ticket = Conversation::findOrFail($ticketId);
        $response = $this->cannedService->findByShortcut($request->shortcut);

        if (!$response) {
            return response()->json([
                'success' => false,
                'message' => 'پاسخ آماده یافت نشد',
            ], 404);
        }

        $renderedText = $this->cannedService->render($response, $ticket);

        return response()->json([
            'success' => true,
            'data' => [
                'text' => $renderedText,
            ],
        ]);
    }

    /**
     * بستن تیکت
     */
    public function close(int $id): JsonResponse
    {
        $ticket = Conversation::findOrFail($id);
        Ticket::close($ticket, auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'تیکت بسته شد',
        ]);
    }
}
```

### مثال ۳: کامپوننت Livewire

```php
<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Karnoweb\TicketChat\Facades\Ticket;
use Karnoweb\TicketChat\Facades\Chat;
use Karnoweb\TicketChat\Models\Conversation;

class TicketChat extends Component
{
    use WithPagination;

    public Conversation $ticket;
    public string $newMessage = '';
    public bool $isTyping = false;
    public array $typingUsers = [];

    public function mount(int $ticketId)
    {
        $this->ticket = Conversation::findOrFail($ticketId);
        
        // علامت‌گذاری به عنوان خوانده شده
        Chat::markAsRead($this->ticket, auth()->id());
    }

    public function render()
    {
        return view('livewire.ticket-chat', [
            'messages' => $this->ticket->messages()
                ->visible()
                ->with(['user', 'attachments', 'replyTo'])
                ->oldest()
                ->get(),
        ]);
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|min:1|max:5000',
        ]);

        Ticket::reply($this->ticket, auth()->id(), $this->newMessage);

        $this->reset('newMessage');
        $this->dispatch('message-sent');
    }

    public function typing()
    {
        Chat::typingIndicator($this->ticket, auth()->id(), true);
    }

    public function stopTyping()
    {
        Chat::typingIndicator($this->ticket, auth()->id(), false);
    }

    // گوش دادن به پیام‌های real-time
    #[On('echo-private:conversation.{ticket.id},.message.sent')]
    public function onNewMessage($event)
    {
        $this->ticket->refresh();
        Chat::markAsRead($this->ticket, auth()->id());
    }

    #[On('echo-private:conversation.{ticket.id},.user.typing')]
    public function onUserTyping($event)
    {
        if ($event['is_typing']) {
            $this->typingUsers[$event['user_id']] = true;
        } else {
            unset($this->typingUsers[$event['user_id']]);
        }
    }
}
```

---

## ✅ بهترین شیوه‌ها

### ۱. استفاده از Queue برای عملیات سنگین

```php
// config/queue.php
'default' => env('QUEUE_CONNECTION', 'redis'),

// نوتیفیکیشن‌ها و broadcast ها به صورت خودکار queue می‌شوند
```

### ۲. Cache کردن داده‌های پرتکرار

```php
// Cache کردن دپارتمان‌ها
$departments = Cache::remember('departments', 3600, function () {
    return Department::active()->get();
});

// Cache کردن پاسخ‌های آماده
$cannedResponses = Cache::remember("canned_responses_{$deptId}", 3600, function () use ($deptId) {
    return CannedResponse::forDepartment($deptId)->get();
});
```

### ۳. Index های مناسب در دیتابیس

Migration های پکیج شامل index های لازم هستند، اما برای جداول سفارشی:

```php
// برای جستجوی سریع‌تر
$table->index(['type', 'status']);
$table->index('created_at');
$table->index('last_message_at');
```

### ۴. محدود کردن Eager Loading

```php
// ❌ بد - بارگذاری همه چیز
$ticket->load(['messages', 'participants', 'activities', 'tags', 'feedback']);

// ✅ خوب - فقط آنچه نیاز است
$ticket->load([
    'messages' => fn($q) => $q->visible()->latest()->limit(50),
    'tags:id,name,color',
]);
```

### ۵. استفاده از Observer ها

```php
// پکیج از Observer استفاده می‌کند برای:
// - ثبت Activity Log
// - ارسال نوتیفیکیشن
// - به‌روزرسانی SLA

// می‌توانید Observer های خود را اضافه کنید
Conversation::observe(YourCustomObserver::class);
```

### ۶. تست نویسی

```php
use Karnoweb\TicketChat\Facades\Ticket;

test('user can create ticket', function () {
    $user = User::factory()->create();
    
    $ticket = Ticket::create([
        'title' => 'Test Ticket',
        'created_by' => $user->id,
    ]);
    
    expect($ticket)->toBeInstanceOf(Conversation::class);
    expect($ticket->ticket_number)->toStartWith('TKT-');
});

test('agent can reply to ticket', function () {
    $ticket = createTicket();
    $agent = User::factory()->create();
    
    $message = Ticket::reply($ticket, $agent->id, 'Test reply');
    
    expect($message->body)->toBe('Test reply');
    expect($ticket->fresh()->messages)->toHaveCount(1);
});
```

### ۷. مدیریت خطاها

```php
use Karnoweb\TicketChat\Exceptions\ConversationLockedException;
use Karnoweb\TicketChat\Exceptions\InvalidStatusTransitionException;
use Karnoweb\TicketChat\Exceptions\RateLimitExceededException;

try {
    Ticket::reply($ticket, $userId, $message);
} catch (ConversationLockedException $e) {
    return response()->json(['error' => 'تیکت قفل است'], 423);
} catch (RateLimitExceededException $e) {
    return response()->json(['error' => 'تعداد پیام‌های شما زیاد است'], 429);
}
```

---

## 📋 خلاصه متدها و کلاس‌ها

### Ticket Facade

| متد | پارامترها | توضیح |
|-----|-----------|--------|
| `create` | `array $data` | ایجاد تیکت |
| `reply` | `$ticket, $userId, $body, $options` | ارسال پاسخ |
| `addNote` | `$ticket, $userId, $body` | یادداشت داخلی |
| `close` | `$ticket, $closedBy` | بستن تیکت |
| `reopen` | `$ticket` | بازگشایی |
| `assign` | `$ticket, $agentId` | تخصیص |
| `transfer` | `$ticket, $departmentId` | انتقال |
| `changeStatus` | `$ticket, $status` | تغییر وضعیت |
| `changePriority` | `$ticket, $priority` | تغییر اولویت |
| `lock` | `$ticket` | قفل کردن |
| `unlock` | `$ticket` | باز کردن قفل |
| `unreadCount` | `$userId` | تعداد خوانده نشده |
| `forUser` | `$userId` | تیکت‌های کاربر |
| `forAgent` | `$agentId` | تیکت‌های اپراتور |
| `forDepartment` | `$deptId` | تیکت‌های دپارتمان |
| `find` | `$id` | پیدا کردن با ID |
| `findByTicketNumber` | `$number` | پیدا کردن با شماره |

### Chat Facade

| متد | پارامترها | توضیح |
|-----|-----------|--------|
| `directTo` | `$from, $to, $message` | چت مستقیم |
| `createGroup` | `$title, $members, $createdBy` | ایجاد گروه |
| `createChannel` | `$title, $createdBy` | ایجاد کانال |
| `sendMessage` | `$conv, $userId, $body, $options` | ارسال پیام |
| `markAsRead` | `$conv, $userId` | خوانده شده |
| `typingIndicator` | `$conv, $userId, $isTyping` | در حال تایپ |
| `unreadCount` | `$userId, $conv` | تعداد خوانده نشده |
| `addParticipant` | `$conv, $userId, $role` | افزودن عضو |
| `removeParticipant` | `$conv, $userId` | حذف عضو |
| `subscribeToChannel` | `$channel, $userId` | عضویت در کانال |
| `unsubscribeFromChannel` | `$channel, $userId` | لغو عضویت |
| `getConversationsForUser` | `$userId` | لیست گفتگوها |
| `getChannelsForUser` | `$userId` | لیست کانال‌ها |

### User Traits

| Trait | متدها |
|-------|--------|
| `HasTickets` | `tickets()`, `createdTickets()`, `assignedTickets()`, `openTickets()`, `ticketUnreadCount()` |
| `HasConversations` | `conversations()`, `directConversations()`, `groupConversations()`, `messages()`, `totalUnreadCount()` |
| `CanBeDepartmentAgent` | `departments()`, `activeDepartments()`, `isDepartmentAdmin()`, `isDepartmentAgent()` |

---

## 🆘 پشتیبانی

- **GitHub Issues**: برای گزارش باگ و درخواست ویژگی
- **GitHub Discussions**: برای سوالات و بحث
- **Email**: support@karnoweb.com

---

**نسخه**: 1.0.0  
**لایسنس**: MIT  
**نویسنده**: Karnoweb