<?php

namespace App\Services\Users\Http\Controllers;

use App\Http\Controllers\Base;
use App\Services\Users\Managers\Invitation as InvitationManager;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class Invitation extends Base
{
    private InvitationManager $invitation;

    /**
     * @param InvitationManager $invitation
     */
    public function __construct(InvitationManager $invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Generate an invitation token for a user.
     *
     * @param int $userId The ID of the user getting the token.
     *
     * @return RedirectResponse
     */
    public function generate(int $userId): RedirectResponse
    {
        $this->invitation->generateToken($userId);

        return redirect()->route('auth.invitation.sent');
    }

    /**
     * Extend the expiry time for the invitation token for
     * a user and re-send the email.
     *
     * @param string $tokenString The user's invitation token.
     *
     * @return RedirectResponse
     */
    public function resend(string $tokenString): RedirectResponse
    {
        $this->invitation->resend($tokenString);

        return redirect()->route('auth.invitation.sent');
    }

    /**
     * Activate the user's account and log them in.
     *
     * @param string $tokenString The user's invitation token.
     *
     * @return RedirectResponse
     *
     * @throws \Exception
     */
    public function activate(string $tokenString): RedirectResponse
    {
        return $this->invitation
            ->activate($tokenString)
            ->redirect();
    }

    /**
     * Display the sent email message.
     *
     * @return Response
     */
    public function sent(): Response
    {
        $this->setPageTitle('Email sent');

        return $this->response(
            page: 'auth.invitation.sent'
        );
    }

    /**
     * Display the account inactive page.
     *
     * @return Response
     */
    public function inactive(): Response
    {
        $this->setPageTitle('Inactive account');

        $token = $this->invitation->findTokenByEmail(session('inactive_email'));

        return $this->response(
            compact('token'),
            'auth.invitation.inactive'
        );
    }

    /**
     * Display the page saying that invitation failed.
     *
     * @param string $tokenString The user's invitation token.
     *
     * @return Response
     */
    public function failed(string $tokenString): Response
    {
        $this->setPageTitle('Invite failed');

        $token = $this->invitation->findToken($tokenString);

        return $this->response(
            compact('token'),
            'auth.invitation.failed'
        );
    }
}
