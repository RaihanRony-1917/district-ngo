<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $memberRequest;
    public function __construct($memberRequest)
    {
        $this->memberRequest = $memberRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }



    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "request_id" => $this->memberRequest->id,
            'name' => $this->memberRequest->name,
            'phone' => $this->memberRequest->phone,
            'message' => 'Member Request sent by: ' . $this->memberRequest->name,
            'time' => $this->memberRequest->created_at
        ];
    }
}
