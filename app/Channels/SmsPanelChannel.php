<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class SmsPanelChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        $message = $notification->toSmsPanel($notifiable);

        $message->send();
    }
}
