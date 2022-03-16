<?php

namespace App\Services\Users\Managers;

use JumpGate\Core\Services\Response;
use App\Services\Users\Models\User;
use App\Services\Users\Models\User\Status;
use App\Services\Users\Models\User\Token;

class Activation
{
    private User $users;

    private Token $tokens;

    /**
     * @param User  $users
     * @param Token $tokens
     */
    public function __construct(User $users, Token $tokens)
    {
        $this->users  = $users;
        $this->tokens = $tokens;
    }

    /**
     * Generate an activation token for a user.
     *
     * @param int $userId The user's ID.
     */
    public function generateToken(int $userId)
    {
        $user = $this->users->find($userId);

        if (! is_null($user)) {
            $user->generateActivationToken();
            $user->setStatus(Status::INACTIVE);
        }
    }

    /**
     * Find the activation token, extend it's expire time and resend the email.
     *
     * @param string $tokenString The activation token.
     */
    public function resend(string $tokenString)
    {
        $token = $this->findToken($tokenString);

        if (! is_null($token)) {
            session()->forget('inactive_email');

            $token->extend();

            $token->notifyUser();
        }
    }

    /**
     * Attempt to activate the user by the provided token.
     *
     * @param string $tokenString The activation token.
     *
     * @return Response
     */
    public function activate(string $tokenString): Response
    {
        $token = $this->findToken($tokenString);

        // If we could not find a token or it has expired, fail the attempt.
        if (is_null($token) || $token->isExpired()) {
            return Response::failed('Activation failed.')
                ->route('auth.activation.failed', $tokenString);
        }

        // Activate the user and log them in.
        $token->user->activate();

        // Send them to set their password if this site uses passwords.
        if (! config('jumpgate.users.social_auth_only')) {
            $token->user->generatePasswordResetToken();

            return Response::passed('Your account has been activated.  Please set your new password.')
                ->route('auth.password.confirm');
        }

        auth()->login($token->user);

        return Response::passed('Your account has been activated.')
            ->route('home');
    }

    /**
     * Find a Token object by the token string.
     *
     * @param string $tokenString The activation token.
     *
     * @return Token|null
     */
    public function findToken(string $tokenString): ?Token
    {
        return $this->tokens->findByToken($tokenString);
    }

    /**
     * Find a Token object by the token string.
     *
     * @param string $email The user's email address.
     *
     * @return Token|null
     */
    public function findTokenByEmail(string $email): ?Token
    {
        $user = $this->users->where('email', $email)->first();

        if (! is_null($user)) {
            return $user->getActivationToken();
        }

        return null;
    }
}
