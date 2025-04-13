<?php

namespace App\Services\Users\Traits;

use App\Services\Users\Models\User\Status;
use App\Services\Users\Managers\Activation;

trait CanActivate
{
    /**
     * Activate a user.
     */
    public function activate()
    {
        // Remove the activation token.
        $this->getActivationToken()->delete();

        $this->updateActivationDetails();
    }

    /**
     * Invite a user.
     *
     * @param string                      $email
     * @param int|array|string|collection $roles
     * @param int|array|string|collection $permissions
     *
     * @return User
     */
    public function sendNewUserActivation(string $email, collection|int|array|string $roles,
                                          collection|int|array|string $permissions = []): User
    {
        $user = static::firstOrCreate(compact('email'));
        $user->roles()->attach($roles);
        $user->permissions()->attach($permissions);

        /** @var Activation $invites */
        $invites = app(Activation::class);
        $invites->generateToken($user->id);

        Detail::firstOrCreate([
            'user_id'      => $user->id,
            'display_name' => $email,
        ]);

        return $user;
    }

    /**
     * Update a users activation details.
     */
    public function updateActivationDetails()
    {
        // Update the user table with the needed details.
        $this->updateLogin();
        $this->trackTime('activated_at');

        // Set the user's status to be correct.
        $this->setStatus(Status::ACTIVE);
    }

    /**
     * Determine if this user is currently active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status_id === Status::ACTIVE;
    }

    /**
     * Determine if this user is currently inactive.
     *
     * @return bool
     */
    public function isInactive(): bool
    {
        return $this->status_id === Status::INACTIVE;
    }
}
