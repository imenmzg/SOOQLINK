<?php

namespace App\Notifications;

use App\Models\RFQ;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RFQReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $rfq;

    public function __construct(RFQ $rfq)
    {
        $this->rfq = $rfq;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('طلب عرض سعر جديد - SOOQLINK')
            ->greeting('مرحباً ' . $notifiable->name)
            ->line('لقد تلقيت طلب عرض سعر جديد من ' . $this->rfq->client->name)
            ->line('الموضوع: ' . $this->rfq->subject)
            ->line('الكمية: ' . $this->rfq->quantity)
            ->action('عرض التفاصيل والرد', url('/supplier/rfqs/' . $this->rfq->id))
            ->line('شكراً لاستخدامك SOOQLINK!');
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'طلب عرض سعر جديد من ' . $this->rfq->client->name,
            'rfq_id' => $this->rfq->id,
            'subject' => $this->rfq->subject,
        ];
    }
}

