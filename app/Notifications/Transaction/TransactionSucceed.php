<?php

namespace App\Notifications\Transaction;

use App\Channels\SmsPanelChannel;
use App\Drivers\SmsPanel\SmsPanelMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionSucceed extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [SmsPanelChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toSmsPanel(object $notifiable): SmsPanelMessage
    {
        return (new SmsPanelMessage)
                    ->to($notifiable->phone_number)
                    ->line('The introduction to the notification.')
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
