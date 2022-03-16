<?php

namespace App\Services\Users\Traits;

trait CanAuthenticate
{
    /**
     * Track the log in details for this user.
     *
     * @param string|null $type The way they tried to log in.
     */
    public function updateLogin(string $type = null)
    {
        $this->authenticated_as      = $type;
        $this->authenticated_at      = setTime('now');
        $this->failed_login_attempts = 0;
        $this->save();
    }

    /**
     * When a log in fails, increment the failed count.
     *
     * @param string $email The email the user tried to log in as.
     *
     * @return bool
     */
    public static function failedLogin(string $email): bool
    {
        $user = self::where('email', $email)->first();

        if (is_null($user)) {
            return false;
        }

        $user->increment('failed_login_attempts');

        $rules = config('jumpgate.users.blocking', null);

        if (is_null($rules)) {
            return true;
        }

        supportCollector($rules)
            ->each(function ($limit, $column) use ($user) {
                if ($limit === 0) {
                    return true;
                }

                $attempts = $user->{$column};

                if ($attempts >= $limit) {
                    $user->blocked();
                }
            });

        return false;
    }
}
