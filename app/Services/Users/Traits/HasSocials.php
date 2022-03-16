<?php

namespace App\Services\Users\Traits;

use Laravel\Socialite\AbstractUser;
use App\Services\Users\Models\User\Social;

trait HasSocials
{
    /**
     * Add a social provider for a user.
     *
     * @param AbstractUser $socialUser
     * @param              $provider
     */
    public function addSocial(AbstractUser $socialUser, $provider)
    {
        $refreshToken = isset($socialUser->refreshToken) && $socialUser->refreshToken
            ? $socialUser->refreshToken
            : null;
        
        $token = is_null($socialUser->token)
            ? $provider
            : $socialUser->token;

        $this->socials()->create([
            'provider'      => $provider,
            'social_id'     => $socialUser->getId(),
            'email'         => $socialUser->getEmail(),
            'avatar'        => $socialUser->getAvatar(),
            'token'         => $token,
            'refresh_token' => $refreshToken,
            'expires_in'    => isset($socialUser->expiresIn) ? $socialUser->expiresIn : null,
        ]);
    }

    /**
     * Get the user's details for a social provider
     * if they exist.
     *
     * @param $provider
     *
     * @return mixed
     */
    public function getProvider($provider): mixed
    {
        return $this->socials()->where('provider', $provider)->first();
    }

    /**
     * Check if a user has a provider attached.
     *
     * @param $provider
     *
     * @return bool
     */
    public function hasProvider($provider): bool
    {
        return $this->socials()->where('provider', $provider)->count() > 0;
    }

    /**
     * Get all social providers a user has.
     *
     * @return mixed
     */
    public function socials(): mixed
    {
        return $this->hasMany(Social::class, 'user_id');
    }
}
