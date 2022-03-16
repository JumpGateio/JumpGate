<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //Registered::class => [
        //    SendEmailVerificationNotification::class,
        //],
        \App\Services\Users\Events\UserCreating::class    => [],
        \App\Services\Users\Events\UserCreated::class     => [],
        \App\Services\Users\Events\UserFailedLogin::class => [],
        \App\Services\Users\Events\UserLoggingIn::class   => [
            \App\Services\Users\Listeners\BlockIfRegistrationDisabled::class,
        ],
        \App\Services\Users\Events\UserLoggedIn::class    => [],
        \App\Services\Users\Events\UserRegistering::class => [
            \App\Services\Users\Listeners\BlockIfRegistrationDisabled::class,
        ],
        \App\Services\Users\Events\UserRegistered::class  => [],
        \App\Services\Users\Events\UserLoggedOut::class  => [],
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
