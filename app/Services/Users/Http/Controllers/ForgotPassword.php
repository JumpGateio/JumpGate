<?php

namespace App\Services\Users\Http\Controllers;

use App\Http\Controllers\Base;
use App\Services\Users\Managers\ForgotPassword as ForgotPasswordManager;

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
     * @return \Inertia\Response
     */
    public function reset(): \Inertia\Response
    {
        $pageTitle = 'Password Reset';

        return $this->response(
            compact('pageTitle'),
            'auth.password.email'
        );
    }

    /**
     * Generate the token for the user to reset their password.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendEmail(): \Illuminate\Http\RedirectResponse
    {
        $this->validate(request(), ['email' => 'required|email']);

        // Attempt to send the email.
        $this->forgotPassword->sendEmail(request('email'));

        return redirect()->route('auth.password.sent');
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
            'auth.password.sent'
        );
    }

    /**
     * Display the form to input a new password.
     *
     * @param string $tokenString The password reset token for the user
     *
     * @return \Inertia\Response
     */
    public function confirm(string $tokenString): \Inertia\Response
    {
        $pageTitle = 'Set your new password';

        return $this->response(
            compact('pageTitle', 'tokenString'),
            'auth.password.reset'
        );
    }

    /**
     * Update the user's password.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(): \Illuminate\Http\RedirectResponse
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
