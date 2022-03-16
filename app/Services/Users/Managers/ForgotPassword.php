<?php

namespace App\Services\Users\Services;

use JumpGate\Core\Services\Response;
use App\Services\Users\Models\User;
use App\Services\Users\Models\User\Token;

class ForgotPassword
{
    private User $users;

    private Token $tokens;

    /**
     * ForgotPassword constructor.
     *
     * @param User  $users
     * @param Token $tokens
     */
    public function __construct(User $users, Token $tokens)
    {
        $this->users  = $users;
        $this->tokens = $tokens;
    }

    /**
     * If the email exists, generate a reset token for that user.
     *
     * @param string $email The user's email.
     */
    public function sendEmail(string $email)
    {
        $user = $this->users->where('email', $email)->first();

        if (! is_null($user)) {
            $user->generatePasswordResetToken();
        }
    }

    /**
     * Attempt to update the user's password.
     *
     * @param string $token    The token string.
     * @param string $email    The provided email.
     * @param string $password The new password.
     *
     * @return Response
     */
    public function updatePassword(string $token, string $email, string $password): Response
    {
        // Get the token being used.
        $token = $this->tokens->findByToken($token);

        // Make sure the correct email was supplied.
        if ($token->user->email !== $email) {
            return Response::failed('The email does not match this token.')
                ->route('auth.password.reset');
        }

        // Reset the user's password and let them log in.
        $token->user->resetPassword($password);

        return Response::passed('Password updated.')
            ->route('auth.login');
    }
}
