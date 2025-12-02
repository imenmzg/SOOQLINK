<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupplierVerifiedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $supplier;

    public function __construct($supplier)
    {
        $this->supplier = $supplier;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('تم التحقق من حسابك - SOOQLINK')
            ->greeting('مرحباً ' . $notifiable->name)
            ->line('تم التحقق من حسابك بنجاح!')
            ->line('يمكنك الآن نشر منتجاتك والبدء في استقبال طلبات عروض الأسعار.')
            ->action('الذهاب إلى لوحة التحكم', url('/supplier'))
            ->line('شكراً لاستخدامك SOOQLINK!');
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'تم التحقق من حسابك بنجاح',
            'supplier_id' => $this->supplier->id,
        ];
    }
}

