<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Load Views/Inertia
    |--------------------------------------------------------------------------
    |
    | JumpGate Users comes with some default view files to make getting started
    | quicker.  To have the files loaded in for you, set the value to true.
    | Use the drive to switch between:
    |
    | blade, inertia
    |
    */

    'driver'     => env('USER_DRIVER', 'inertia'),
    'load_files' => true,

    /*
    |--------------------------------------------------------------------------
    | Available settings
    |--------------------------------------------------------------------------
    |
    | Here you can configure the users package with a few available settings.
    | If you set registration to false, then email activation will also be
    | considered false.
    |
    */

    'settings' => [
        // This will send out an email for the user to activate.
        'require_email_activation' => false,

        // If this is disabled, users will not be able to register on the site at all.
        // The route and  menu link will be removed.  The LoggingIn and Registering
        // events will also check this and force it to not work.  To add a user
        // when registration is disabled, you will have to add them through
        // the admin panel.  They can only log in if the user exists.
        'allow_registration'       => false,
        // This will give you the option in the admin dashboard to send
        // user an invitation to the site through email.
        'allow_invitations'        => false,

        // Tells the User seeder to create the default users.  These are defined in DefaultUsers::class.
        'create_default_users'     => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Automatic blocking
    |--------------------------------------------------------------------------
    |
    | While you can manually block a user by calling the block() method, you
    | may often want to automate some blocking rules.  You can do this below.
    | Each entry must contain what column is being checked and the value.
    | Set any column this to zero to disable that specific rule.
    |
    | Available checks: failed_login_attempts
    |
    */

    'blocking' => [
        'failed_login_attempts' => 10,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Group
    |--------------------------------------------------------------------------
    |
    | When a user signs up, this is the group they will be automatically
    | assigned to.  This should match the name column of the group.
    |
    */

    'default_role' => 'user',

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    |
    | When redirecting a user to login, we don't know which route to send
    | them to.  This lets us know what route to aim for.  If using
    | social auth, set this to auth.social.login.
    |
    */

    'default_route' => [
        'name'    => 'auth.social.login',
        'options' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Social Authentication Details
    |--------------------------------------------------------------------------
    |
    | If using social authentication, specify the driver being used here.  You
    | can also specify any additional scopes or extras you need here.
    | Setting the enable_social flag to true will add social routes.
    |
    | Note: You must have at least one provider or you will get an exception.
    |
    */

    'enable_social' => true,

    'providers' => [
        [
            'driver' => 'google',
            'scopes' => [
                'https://www.googleapis.com/auth/userinfo.email',
            ],
            'extras' => [
                'approval_prompt' => 'auto',
                'access_type'     => 'offline',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Social Only
    |--------------------------------------------------------------------------
    |
    | If using social authentication by setting enable_social to true, you can
    | allow social to be the only authentication, or exist alongside standard
    | auth.  Set the following to true to force only social logins.
    |
    | Once you set this to true, make sure to remove any routes pointing to
    | the non-social versions (ie auth.login and auth.register)
    |
    | NOTE: Setting this to true does not disable registration.
    |
    */

    'social_auth_only' => true,
];
