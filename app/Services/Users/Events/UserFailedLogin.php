<?php

namespace App\Services\Users\Events;

use Illuminate\Queue\SerializesModels;

class UserFailedLogin
{
    use SerializesModels;

    public string $reason;

    /**
     * Create a new event instance.
     *
     * @param string $reason
     */
    public function __construct($reason)
    {
        $this->reason = $reason;
    }
}
