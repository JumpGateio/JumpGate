<?php

namespace App\Services\Users\Events;

use Illuminate\Queue\SerializesModels;
use Laravel\Socialite\AbstractUser;

class UserLoggingIn
{
    use SerializesModels;

    public AbstractUser|null $socialUser;

    /**
     * Create a new event instance.
     *
     * @param AbstractUser|null $socialUser
     */
    public function __construct(AbstractUser $socialUser = null)
    {
        $this->socialUser = $socialUser;
    }
}
