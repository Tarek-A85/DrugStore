<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class UserNotification extends Notification
{
    use Queueable;
    private $order_id;
    private $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($id,$status)
    {
        $this->order_id=$id;
        $this->status=$status;
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
            "order_id"=>$this->order_id,
            "status"=>$this->status,
        ];
    }
}
