# Social Providers

---

- [Set Up](#set-up)
- [Config Example](#config-example)

<a name="set-up"></a>
## Set Up

TODO: Give steps on setting up the providers

<a name="config-example"></a>
## Config Example
```php
    'providers' => [
        [
            'driver' => 'google',
            'scopes' => [
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/calendar',
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
    ]
```
