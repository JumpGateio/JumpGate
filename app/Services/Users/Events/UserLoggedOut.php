<?php

namespace App\Services\Users\Events;

use Illuminate\Queue\SerializesModels;
use App\Services\Users\Models\User;

class UserLoggedOut
{
    use SerializesModels;

    public User $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
