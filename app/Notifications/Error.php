<?php

namespace App\Notifications;

class Error extends Notification
{
    protected $level = 'danger';

    protected $icon = 'fa fa-exclamation-triangle';
}
