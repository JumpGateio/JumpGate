<?php

namespace App\Notifications;

class Warning extends Notification
{
    protected $level = 'warning';

    protected $icon = 'fa fa-exclamation-triangle';
}
