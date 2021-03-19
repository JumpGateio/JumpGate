# Authentication

---

- [Introduction](#introduction)
- [Controllers and Services](#controllers-services)
- [Events](#events)
- [Token Management](#token-management)

<a name="introduction"></a>
## Introduction

This package comes with authentication already baked in.  Its the main purpose and it tries to solve most common needs 
in an easy to handle way.  We offer standard auth with local password storage, invitations, and email registration as well 
as social auth using a third party provider.  This doc will try to explain how all this works in case you need to make 
changes for your specific needs.

<a name="controllers-services"></a>
## Controllers and Services

We have separated out the pieces of authentication into a handful of controllers.  Each has a specific task it is in charge 
of.

- Activation
    - This handles email activation codes.
- Authentication
    - This handles actually logging in and logging out using standard site auth.
- ForgotPassword
    - This handles resetting passwords.
- Invitation
    - Allows sending out invitations with a token to create an account.
- Registration
    - This handles letting new users register on the app.
- SocialAuthentication
    - This handles using socialite to authenticate against a third party provider and storing the returned user data.

Most of the work in these controllers is actually handled by our services.  If you need to modify how something happens, 
and the event listeners don't cover it, you probably need to overload the services.  For the most part, the services match 
up with the names of the controllers.  Below are the few outliers.

- GetActions
    - This determines the available actions you can take on a user.  Things like invitations and registration.  This is 
    primarily used in the admin panel to populate the actions drop down.
- Login
    - This matches up to the Authentication controller.  It will properly validate the login and make a response based on 
    any possible failure or a successful login.
- UserActions
    - This services handles running the action on the user.  It knows how to switch between turning the command on and off.
      For example, it will delete a user or restore a user for you.


<a name="events"></a>
## Events

Throughout the authentication process, we fire off multiple events to allow your app to tie in to anything it should need 
to.  The below table details the event being fired, the properties it has, and where it is fired.

Event             | Properties                                 | Called From               | Notes
----------------- | ------------------------------------------ | ------------------------  | ------
`UserFailedLogin` | STRING 'password'                          | Services/Login.php        | Invalid credentials.
`UserFailedLogin` | STRING 'inactive'                          | Services/Login.php        | User is inactive.
`UserFailedLogin` | STRING 'blocked'                           | Services/Login.php        | User is blocked.
`UserLoggedIn`    | Models\User $user                          | Services/Login.php        | Successful login.
`UserRegistering` | Models\User $user                          | Services/Registration.php | Registration is about to happen.
`UserCreating`    | Models\User $user                          | Services/Registration.php | The user is about to be added to the database.
`UserCreated`     | Models\User $user                          | Services/Registration.php | The user is now in the database.
`UserRegistered`  | Models\User $user                          | Services/Registration.php | Registration is complete.
`UserLoggingIn`   | Laravel\Socialite\AbstractUser $socialUser | Services/SocialLogin.php  | A social authentication is about to be attempted.
`UserLoggedIn`    | Models\User $user                          | Services/SocialLogin.php  | A social authentication was successful.
&nbsp;            | Laravel\Socialite\AbstractUser $socialUser | &nbsp;                    | &nbsp;

Each of these events is included in the published Event provider we copy to the app.  The `UserLoggingIn`, and 
`UserRegistering` events also have listeners automatically assigned.  In both bases, it blocks registration when 
registration is disabled in the configs.

<a name="token-management"></a>
## Token Management

Many of the authentication features use tokens to handle verifying a correct process.  These are all stored in the 
`user_tokens` table and handled by the `Models\User\Token` class.  The type of token is stored as constants and stored in 
the `type` enum column on the table.  Activation, invitation and password resets all use this feature.  It has helpers for 
extending the expiration time, deleting by token instead of id, and expiring tokens.  All of these are handled in the services 
mentioned before.  If you want to see how we generate the token, look to the `Token::makeToken()` method.

<a name="social-security"></a>
## Social Security

As a measure of security, be aware all social `token` and `refresh_token` entries are encrypted on the way in.  They are 
also not displayed on the user view page in the admin panel.  This is done automatically on the way in using setters and 
decrypted on the way out (when making api calls for the user) by the getters.
