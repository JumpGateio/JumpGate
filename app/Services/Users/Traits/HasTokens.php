<?php

namespace App\Services\Users\Traits;

use App\Services\Users\Models\User\Token;
use App\Services\Users\Notifications\PasswordReset;
use App\Services\Users\Notifications\UserActivation;
use App\Services\Users\Notifications\UserCreated;
use App\Services\Users\Notifications\UserInvitation;

/**
 * Class HasTokens
 *
 * @package App\Services\Users\Traits
 *
 * @property \App\Services\Users\Models\User\Token[] $tokens
 */
trait HasTokens
{
    /**
     * Generate a new activation token for a user.
     *
     * @param int|null $hours
     *
     * @return Token
     */
    public function generateActivationToken(int $hours = null): Token
    {
        $token = app(Token::class)->generate(Token::TYPE_ACTIVATION, $this, $hours);

        $this->notify(new UserActivation);

        return $token;
    }

    /**
     * Generate a new invitation token for a user.
     *
     * @param int|null $hours
     *
     * @return Token
     */
    public function generateInvitationToken(int $hours = null): Token
    {
        $token = app(Token::class)->generate(Token::TYPE_INVITATION, $this, $hours);

        $this->notify(new UserInvitation);

        return $token;
    }

    /**
     * Generate a new password reset token for a user.
     *
     * @param int|null $hours
     *
     * @return Token
     */
    public function generatePasswordResetToken(int $hours = null): Token
    {
        $token = app(Token::class)->generate(Token::TYPE_PASSWORD_RESET, $this, $hours);

        $this->notify(new PasswordReset);

        return $token;
    }

    /**
     * Generate a new password reset token for a user.
     *
     * @param int|null $hours
     *
     * @return Token
     */
    public function generateNewUserPasswordResetToken(int $hours = null): Token
    {
        $token = app(Token::class)->generate(Token::TYPE_PASSWORD_RESET, $this, $hours);

        $this->notify(new UserCreated);

        return $token;
    }

    /**
     * Get the user's current activation token.
     *
     * @return Token
     */
    public function getActivationToken(): Token
    {
        return $this->tokens()->where('type', Token::TYPE_ACTIVATION)->first();
    }

    /**
     * Get the user's current invitation token.
     *
     * @return Token
     */
    public function getInvitationToken(): Token
    {
        return $this->tokens()->where('type', Token::TYPE_INVITATION)->first();
    }

    /**
     * Get the user's current password reset token.
     *
     * @return Token
     */
    public function getPasswordResetToken(): Token
    {
        return $this->tokens()->where('type', Token::TYPE_PASSWORD_RESET)->first();
    }

    /**
     * Any tokens generated for a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tokens(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Token::class, 'user_id');
    }
}
