<?php

namespace App\Services\Users\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use App\Services\Users\Http\Requests\Registration as RegistrationRequest;
use App\Services\Users\Managers\Registration as RegistrationManager;

class Registration extends BaseController
{
    private RegistrationManager $registration;

    /**
     * @param RegistrationManager $registration
     */
    public function __construct(RegistrationManager $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Display the registration form.
     */
    public function index(): \Inertia\Response
    {
        $pageTitle = 'Register';

        return $this->response(
            compact('pageTitle'),
            'auth.register'
        );
    }

    /**
     * Handle validating the registration.
     *
     * @param \App\Services\Users\Http\Requests\Registration $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(RegistrationRequest $request): \Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();

        // Try to register the user.
        try {
            $user = $this->registration->registerUser();
        } catch (\Exception $exception) {
            DB::rollBack();

            logger()->error($exception);

            return redirect()->route('auth.register')
                ->with('errors', $exception->getMessage());
        }

        DB::commit();

        // If the app requires activation, generate a token and email them.
        if (config('jumpgate.users.require_email_activation')) {
            return redirect()->route('auth.activation.generate', $user->id);
        }

        // Log the user in.
        auth()->login($user);

        return redirect()
            ->route('home')
            ->with('message', 'Your account has been created.');
    }
}
