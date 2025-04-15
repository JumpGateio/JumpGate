<?php

namespace App\Services\Users\Traits;

use App\Services\Users\Models\User\Detail;
use App\Services\Users\Models\User\Status;
use App\Services\Users\Services\Invitation;

trait CanInvite
{
    /**
     * Activate a user from an invitation.
     */
    public function activateInvitation()
    {
        // Remove the invitation token.
        $this->getInvitationToken()->delete();

        // Update the user table with the needed details.
        $this->updateLogin();
        $this->trackTime('activated_at');

        // Set the user's status to be correct.
        $this->setStatus(Status::ACTIVE);
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
    public function inviteNewUser(string $email, collection|int|array|string $roles,
                                  collection|int|array|string $permissions = []): User
    {
        $user = static::firstOrCreate(compact('email'));
        $user->addRoles($roles);
        $user->givePermissions($permissions);

        /** @var Invitation $invites */
        $invites = app(Invitation::class);
        $invites->generateToken($user->id);

        Detail::firstOrCreate([
            'user_id'      => $user->id,
            'display_name' => $email,
        ]);

        return $user;
    }

    /**
     * Resend an invitation to the user.
     */
    public function resendInvite()
    {
        $token = $this->getInvitationToken();

        $token->extend();
        $token->notifyUser();
    }

    /**
     * Remove the invite for the user.
     */
    public function revokeToken()
    {
        // Remove the invitation token.
        $this->getInvitationToken()->delete();
    }
}
