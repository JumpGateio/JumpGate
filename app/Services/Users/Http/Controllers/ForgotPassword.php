<?php

namespace App\Services\Users\Http\Controllers;

use App\Http\Controllers\Base;
use App\Services\Users\Managers\ForgotPassword as ForgotPasswordManager;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class ForgotPassword extends Base
{
    private ForgotPasswordManager $forgotPassword;

    /**
     * @param ForgotPasswordManager $forgotPassword
     */
    public function __construct(ForgotPasswordManager $forgotPassword)
    {
        $this->forgotPassword = $forgotPassword;
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return Response
     */
    public function reset(): Response
    {
        $this->setPageTitle('Password Reset');

        return $this->response(
            page: 'auth.password.email'
        );
    }

    /**
     * Generate the token for the user to reset their password.
     *
     * @return RedirectResponse
     */
    public function sendEmail(): RedirectResponse
    {
        $this->validate(request(), ['email' => 'required|email']);

        // Attempt to send the email.
        $this->forgotPassword->sendEmail(request('email'));

        return redirect()->route('auth.password.sent');
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
            page: 'auth.password.sent'
        );
    }

    /**
     * Display the form to input a new password.
     *
     * @param string $tokenString The password reset token for the user
     *
     * @return Response
     */
    public function confirm(string $tokenString): Response
    {
        $this->setPageTitle('Set your new password');

        return $this->response(
            compact('tokenString'),
            'auth.password.reset'
        );
    }

    /**
     * Update the user's password.
     *
     * @return RedirectResponse
     */
    public function handle(): RedirectResponse
    {
        // Make sure we have everything we need from the form.
        $this->validate(request(), $this->rules());

        // Try to update the user's password.
        return $this->forgotPassword
            ->updatePassword(request('token'), request('email'), request('password'))
            ->redirect();
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }
}
