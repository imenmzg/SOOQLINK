<?php

namespace App\Notifications;

use App\Models\RFQ;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RFQReplyNotification extends Notification implements ShouldQueue
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
        $reply = $this->rfq->replies()->latest()->first();
        
        return (new MailMessage)
            ->subject('رد على طلب عرض السعر - SOOQLINK')
            ->greeting('مرحباً ' . $notifiable->name)
            ->line('لقد تلقيت رداً على طلب عرض السعر الخاص بك من ' . $this->rfq->supplier->company_name)
            ->line('السعر المقترح: ' . number_format($reply->price, 2) . ' DZD')
            ->action('عرض التفاصيل', url('/client/rfqs/' . $this->rfq->id))
            ->line('شكراً لاستخدامك SOOQLINK!');
    }

    public function toArray($notifiable): array
    {
        $reply = $this->rfq->replies()->latest()->first();
        
        return [
            'message' => 'رد على طلب عرض السعر من ' . $this->rfq->supplier->company_name,
            'rfq_id' => $this->rfq->id,
            'price' => $reply->price ?? null,
        ];
    }
}

