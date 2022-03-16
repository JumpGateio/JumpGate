<?php

namespace App\Services\Users\Traits;

trait HasGravatar
{
    /**
     * Generate a gravatar from a user's email.
     *
     * @return string
     */
    public function getGravatarAttribute(): string
    {
        $emailHash = md5(strtolower(trim($this->email)));

        return 'https://www.gravatar.com/avatar/' . $emailHash;
    }
}
