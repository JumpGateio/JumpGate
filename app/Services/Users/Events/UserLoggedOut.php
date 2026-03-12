<?php

namespace App\Services\Users\Events;

use App\Services\Users\Models\User;
use Illuminate\Queue\SerializesModels;

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
