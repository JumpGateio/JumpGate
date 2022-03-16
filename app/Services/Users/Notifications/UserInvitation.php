<?php

namespace App\Services\Users\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserInvitation extends Notification
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
        $url     = route('auth.invitation.activate', [$notifiable->getInvitationToken()->token]);
        $appName = config('app.name');

        return (new MailMessage)
            ->greeting('You have been invited to join ' . $appName . '!')
            ->line('Please click the button below to activate your account.')
            ->action('Verify your email', $url)
            ->line('We look forward to seeing you soon!');
    }
}
