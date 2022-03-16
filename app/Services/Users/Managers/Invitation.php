<?php

namespace App\Services\Users\Services;

use JumpGate\Core\Services\Response;
use App\Services\Users\Models\User;
use App\Services\Users\Models\User\Status;
use App\Services\Users\Models\User\Token;

class Invitation
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
     * Generate an invitation token for a user.
     *
     * @param int $userId The user's ID.
     */
    public function generateToken(int $userId)
    {
        $user = $this->users->find($userId);

        if (! is_null($user)) {
            $user->generateInvitationToken();
            $user->trackTime('invited_at');
            $user->setStatus(Status::INACTIVE);
        }
    }

    /**
     * Find the invitation token, extend it's expire time and resend the email.
     *
     * @param string $tokenString The invitation token.
     */
    public function resend(string $tokenString)
    {
        $token = $this->findToken($tokenString);

        if (! is_null($token)) {
            session()->forget('inactive_email');

            $token->user->resendInvite();
        }
    }

    /**
     * Attempt to activate the user by the provided token.
     *
     * @param string $tokenString The invitation token.
     *
     * @return Response
     */
    public function activate(string $tokenString): Response
    {
        $token = $this->findToken($tokenString);

        // If we could not find a token or it has expired, fail the attempt.
        if (is_null($token) || $token->isExpired()) {
            return Response::failed('Activation failed.')
                ->route('auth.invitation.failed', $tokenString);
        }

        // Activate the user and log them in.
        $token->user->activateInvitation();

        auth()->login($token->user);

        return Response::passed('Your account has been activated.')
            ->route('home');
    }

    /**
     * Find a Token object by the token string.
     *
     * @param string $tokenString The invitation token.
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
            return $user->getInvitationToken();
        }

        return null;
    }
}
