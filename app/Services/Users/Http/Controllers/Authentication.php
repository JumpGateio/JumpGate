<?php

namespace App\Services\Users\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Services\Users\Events\UserLoggedOut;
use App\Services\Users\Http\Requests\Login;
use App\Services\Users\Managers\Login as LoginManager;

class Authentication extends BaseController
{
    private LoginManager $login;

    /**
     * @param LoginManager $login
     */
    public function __construct(LoginManager $login)
    {
        $this->login = $login;
    }

    /**
     * Display the login form.
     */
    public function index(): \Inertia\Response
    {
        $pageTitle = 'Login';

        return $this->response(
            compact('pageTitle'),
            'auth.login'
        );
    }

    /**
     * Display the blocked page.
     */
    public function blocked(): \Inertia\Response
    {
        $pageTitle = 'Blocked';

        return $this->response(
            compact('pageTitle'),
            'auth.blocked'
        );
    }

    /**
     * Handle validating the login details.
     *
     * @param \App\Services\Users\Http\Requests\Login $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Login $request): \Illuminate\Http\RedirectResponse
    {
        // Set up the auth data
        $userData = [
            'email'    => $request->get('email'),
            'password' => $request->get('password'),
        ];

        // Let the login service handle the checks.
        return $this->login
            ->loginUser($userData)
            ->redirectIntended();
    }

    /**
     * Log the user out.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();
        auth()->logout();

        event(new UserLoggedOut($user));

        return redirect()
            ->route('home')
            ->with('message', 'You have been logged out.');
    }
}
