<?php

namespace App\Services\Users\Events;

use App\Services\Users\Models\User;
use Illuminate\Queue\SerializesModels;
use Laravel\Socialite\AbstractUser;

class UserRegistered
{
    use SerializesModels;

    public User $user;

    public ?AbstractUser $socialUser;

    /**
     * Create a new event instance.
     *
     * @param User              $user
     * @param AbstractUser|null $socialUser
     */
    public function __construct(User $user, ?AbstractUser $socialUser = null)
    {
        $this->user       = $user;
        $this->socialUser = $socialUser;
    }
}
