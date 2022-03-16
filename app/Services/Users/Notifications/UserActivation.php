<?php

namespace App\Services\Users\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserActivation extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        $url = route('auth.activation.activate', [$notifiable->getActivationToken()->token]);

        return (new MailMessage)
            ->greeting('Thanks for registering!')
            ->line('Please click the button below to verify your account.')
            ->action('Verify your email', $url)
            ->line('Thank you for using our application!');
    }
}
