<?php

namespace App\Services\Users\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Services\Users\Managers\SocialLogin;

class SocialAuthentication extends BaseController
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
     * @param null|string $provider
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(string $provider = null): \Illuminate\Http\RedirectResponse
    {
        return $this->login->redirect($provider);
    }

    /**
     * Use the returned user to register (if needed) and login.
     *
     * @param null|string $provider
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(string $provider = null): \Illuminate\Http\RedirectResponse
    {
        $this->login->loginUser($provider);

        return redirect()
            ->intended(route('home'))
            ->with('message', 'You have been logged in.');
    }
}
