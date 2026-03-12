<?php

namespace App\Services\Users\Http\Controllers;

use App\Http\Controllers\Base;
use App\Services\Users\Managers\SocialLogin;
use Illuminate\Http\RedirectResponse;

class SocialAuthentication extends Base
{
    private SocialLogin $login;

    /**
     * SocialAuthentication constructor.
     *
     * @param SocialLogin $login
     */
    public function __construct(SocialLogin $login)
    {
        $this->login = $login;
    }

    /**
     * Redirect the user to the social providers auth page.
     *
     * @param string|null $provider
     *
     * @return RedirectResponse
     */
    public function login(?string $provider = null): RedirectResponse
    {
        return $this->login->redirect($provider);
    }

    /**
     * Use the returned user to register (if needed) and login.
     *
     * @param string|null $provider
     *
     * @return RedirectResponse
     */
    public function callback(?string $provider = null): RedirectResponse
    {
        $this->login->loginUser($provider);

        return redirect()
            ->intended(route('home'))
            ->with('message', 'You have been logged in.');
    }
}
