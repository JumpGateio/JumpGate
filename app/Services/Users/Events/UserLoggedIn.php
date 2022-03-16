<?php

namespace App\Services\Users\Events;

use Illuminate\Queue\SerializesModels;
use Laravel\Socialite\AbstractUser;
use App\Services\Users\Models\User;

class UserLoggedIn
{
    use SerializesModels;

    public User $user;

    public User|null $socialUser;

    /**
     * Create a new event instance.
     *
     * @param User              $user
     * @param AbstractUser|null $socialUser
     */
    public function __construct(User $user, AbstractUser $socialUser = null)
    {
        $this->user       = $user;
        $this->socialUser = $socialUser;
    }
}
