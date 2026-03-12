<?php

namespace App\Providers;

use App\Services\Users\Events\UserCreated;
use App\Services\Users\Events\UserCreating;
use App\Services\Users\Events\UserFailedLogin;
use App\Services\Users\Events\UserLoggedIn;
use App\Services\Users\Events\UserLoggedOut;
use App\Services\Users\Events\UserLoggingIn;
use App\Services\Users\Events\UserRegistered;
use App\Services\Users\Events\UserRegistering;
use App\Services\Users\Listeners\BlockIfRegistrationDisabled;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Registered::class => [
        //    SendEmailVerificationNotification::class,
        // ],
        UserCreating::class    => [],
        UserCreated::class     => [],
        UserFailedLogin::class => [],
        UserLoggingIn::class   => [
            BlockIfRegistrationDisabled::class,
        ],
        UserLoggedIn::class    => [],
        UserRegistering::class => [
            BlockIfRegistrationDisabled::class,
        ],
        UserRegistered::class  => [],
        UserLoggedOut::class   => [],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}
