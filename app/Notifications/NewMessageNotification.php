<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('رسالة جديدة - SOOQLINK')
            ->greeting('مرحباً ' . $notifiable->name)
            ->line('لقد تلقيت رسالة جديدة من ' . $this->message->sender->name)
            ->line(substr($this->message->body, 0, 100) . '...')
            ->action('عرض الرسالة', url('/messages/' . $this->message->chat_id))
            ->line('شكراً لاستخدامك SOOQLINK!');
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'رسالة جديدة من ' . $this->message->sender->name,
            'chat_id' => $this->message->chat_id,
            'sender_id' => $this->message->sender_id,
        ];
    }
}

