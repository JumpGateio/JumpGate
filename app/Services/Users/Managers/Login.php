<?php

namespace App\Services\Users\Managers;

use JumpGate\Core\Services\Response;
use App\Services\Users\Events\UserFailedLogin;
use App\Services\Users\Events\UserLoggedIn;
use App\Services\Users\Models\User;
use App\Services\Users\Models\User\Status;

class Login
{
    /**
     * Try to log the user in and validate their status.
     *
     * @param array $userData The supplied email/password.
     *
     * @return Response
     */
    public function loginUser(array $userData): Response
    {
        // Login has failed with this email/password.
        if (! auth()->attempt($userData, request('remember', false))) {
            return $this->handleInvalidCredentials();
        }

        // Check if the user is inactive.
        if (auth()->user()->status_id === Status::INACTIVE) {
            return $this->handleInactiveUser();
        }

        // Check if the user has been blocked.
        if (auth()->user()->status_id === Status::BLOCKED) {
            return $this->handleBlockedUsers();
        }

        // User has passed all checks and can be redirected to the site.
        return $this->handleSuccessfulLogin();
    }

    /**
     * Called when the user's email/password are not valid.
     *
     * @return Response
     */
    private function handleInvalidCredentials(): Response
    {
        event(new UserFailedLogin('password'));

        // Try to track the failed login.
        User::failedLogin(request('email'));

        return Response::failed('Your email or password was incorrect.')
            ->route('auth.login');
    }

    /**
     * Called when the user is inactive.
     *
     * @return Response
     */
    private function handleInactiveUser(): Response
    {
        event(new UserFailedLogin('inactive'));

        // Log the user out.
        session(['inactive_email' => auth()->user()->email]);
        auth()->logout();

        return Response::failed('Your account is not yet activated.')
            ->route('auth.activation.inactive');
    }

    /**
     * Called when the user is blocked.
     *
     * @return Response
     */
    private function handleBlockedUsers(): Response
    {
        event(new UserFailedLogin('blocked'));

        // Log the user out.
        auth()->logout();

        return Response::failed('You are not allowed to access the site at this time.')
            ->route('auth.blocked');
    }

    /**
     * Called when the user has passed all authentication checks.
     *
     * @return Response
     */
    private function handleSuccessfulLogin(): Response
    {
        event(new UserLoggedIn(auth()->user()));

        // Update the user with the log in details.
        auth()->user()->updateLogin();

        return Response::passed('You have been logged in.')
            ->route('home');
    }
}
