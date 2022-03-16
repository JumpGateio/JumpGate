<?php

namespace App\Services\Users\Traits;

trait CanResetPassword
{
    /**
     * Reset a user's password.
     *
     * @param $password
     */
    public function resetPassword($password = null)
    {
        // Remove the activation token.
        $this->getPasswordResetToken()->delete();

        // Update the user table with the needed details.
        $this->password = $password;
        $this->trackTime('password_updated_at');
        $this->save();
    }
}
