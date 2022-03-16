<?php

namespace App\Services\Users\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Services\Users\Managers\Activation as ActivationManager;
use Illuminate\Http\RedirectResponse;

class Activation extends BaseController
{
    private ActivationManager $activation;

    /**
     * @param ActivationManager $activation
     */
    public function __construct(ActivationManager $activation)
    {
        $this->activation = $activation;
    }

    /**
     * Generate an activation token for a user.
     *
     * @param int $userId The ID of the user getting the token.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generate(int $userId): RedirectResponse
    {
        $this->activation->generateToken($userId);

        return redirect()->route('auth.activation.sent');
    }

    /**
     * Extend the expiry time for the activation token for
     * a user and re-send the email.
     *
     * @param string $tokenString The user's activation token.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(string $tokenString): RedirectResponse
    {
        $this->activation->resend($tokenString);

        return redirect()->route('auth.activation.sent');
    }

    /**
     * Activate the user's account and log them in.
     *
     * @param string $tokenString The user's activation token.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate(string $tokenString): RedirectResponse
    {
        return $this->activation
            ->activate($tokenString)
            ->redirect();
    }

    /**
     * Display the sent email message.
     *
     * @return \Inertia\Response
     */
    public function sent(): \Inertia\Response
    {
        $pageTitle = 'Email sent';

        return $this->response(
            compact('pageTitle'),
            'auth.activation.sent'
        );
    }

    /**
     * Display the account inactive page.
     *
     * @return \Inertia\Response
     */
    public function inactive(): \Inertia\Response
    {
        $pageTitle = 'Inactive account';

        $token = $this->activation->findTokenByEmail(session('inactive_email'));

        return $this->response(
            compact('pageTitle', 'token'),
            'auth.activation.inactive'
        );
    }

    /**
     * Display the page saying that activation failed.
     *
     * @param string $tokenString The user's activation token.
     *
     * @return \Inertia\Response
     */
    public function failed(string $tokenString): \Inertia\Response
    {
        $pageTitle = 'Activation failed';

        $token = $this->activation->findToken($tokenString);

        return $this->response(
            compact('pageTitle', 'token'),
            'auth.activation.failed'
        );
    }
}
