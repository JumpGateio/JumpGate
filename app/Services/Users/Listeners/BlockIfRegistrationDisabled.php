<?php

namespace App\Services\Users\Listeners;

use App\Exceptions\RedirectionException;
use App\Services\Users\Events\UserLoggingIn;
use App\Services\Users\Events\UserRegistering;
use App\Services\Users\Models\User;

class BlockIfRegistrationDisabled
{
    /**
     * Handle the event.
     *
     * @param UserLoggingIn|UserRegistering $event
     *
     * @return bool
     * @throws \App\Exceptions\RedirectionException
     */
    public function handle(UserLoggingIn|UserRegistering $event): bool
    {
        if (config('jumpgate.users.settings.allow_registration')) {
            return true;
        }

        $email = $event->socialUser->getEmail();

        if (User::where('email', $email)->count() === 0) {
            throw new RedirectionException(
                500,
                'Registration is disabled for this site.',
                route('home')
            );
        }

        return false;
    }
}
