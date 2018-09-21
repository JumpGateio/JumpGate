# Social Providers

---

- [Set Up](#set-up)
- [.env](#env)
- [Services Config](#services-config)
- [Users Config](#users-config)

<a name="set-up"></a>
## Set Up

Setting up a new provider is a fairly straight forward task.  You will need to do some leg work before you get started 
though.

1. Determine the name you will give your provider in `services.php` and `users.php` config files.
1. Sign up for the API.  This should provide you with your client_secret, client_key.
1. Set your redirect URL as `<your site>/callback/<provider>` when you sign up.
1. Add these details to your `.env`.  They normally follow the convention of `[PROVIDER]_CLIENT_KEY` (as an example).
1. Add the provider to your `config/services.php`.
1. Add the provider to `config/jumpgate/users.php`.  (You can use the example config below)

This is the basic workflow.  After this, most APIs will work for authentication.  You can set `scopes` and `extras` in the 
`users.php` config if your API uses them.  These behave the exact way Laravel Socialite expects those values to.

Below you will find an example set up assuming you were authenticating through google.

> {info} You can see how to generate a google API in [our docs](/docs/{{version}}/users-social-google)

<a name="env"></a>
## .env

- `.env`

```dotenv
GOOGLE_KEY="SOME+KEY.apps.googleusercontent.com"
GOOGLE_SECRET="SOME+SECRET"
GOOGLE_REDIRECT_URI="http://mysite.lol/callback/google"
```

<a name="services-config"></a>
## Services config

- `config/services.php`

```php
    'google'     => [
        'client_id'     => env('GOOGLE_KEY'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT_URI'),
    ],
```

<a name="users-config"></a>
## Users config

- `config/jumpgate/users.php`

```php
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
        [
            'driver' => 'github',
            'scopes' => [],
            'extras' => [],
        ],
    ],
```
