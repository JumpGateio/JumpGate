<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification as BaseNotification;

abstract class Notification extends BaseNotification
{
    use Queueable;

    /**
     * @var string
     */
    private $message;

    /**
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['broadcast'];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'level'   => $this->level,
            'icon'    => $this->icon,
            'message' => $this->message,
        ];
    }
}
