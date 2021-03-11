# Social Set Up

---

- [Socialite](#socialite)
- [Database](#database)
- [Models](#models)

<a name="socialite"></a>
## Socialite

First things first, you will need to install socialite.

```bash
composer require laravel/socialite
php artisan package:discover
```

> {info} Laravel should auto discover the provider and alias, but to be safe, we want to run discover.

This is all that is required to get started with socialite.  It comes with some providers automatically installed, but you 
can visit [Laravel Socialite Providers](https://socialiteproviders.github.io/about.html) for a larger list of already made 
providers for many popular APIs.  You can also find documentation for socialite itself at [Laravel's Docs](https://laravel.com/docs/5.7/socialite).

<a name="database"></a>
## Database

By default, this package wont install any social tables in the database until you set `enable_social` to `true` in your 
`config/jumpgate/users.php`.  If you enable this after running the initial migrations, its not a problem, just 
set it to true and then run `php artisan migrate` and it will now add them.

> {primary} Running the social migration also sets the password field on the `users` table to nullable.

When a user logs in through a social provider it will create a new row in the `user_socials` table for that provider.  It 
stores the `social_id` (the user's ID with that provider) and the `avatar` (any avatar the user may have set for them).  So 
if you allow multiple providers, a user will have multiple records in this table that you can use as needed.

It will also log the last provider the user logged in through in the `users` table on the `authenticated_as` column.

<a name="models"></a>
## Models

Now that you have your new database tables, you should create a link for the `User` model to access the `Social` model.  We 
have done this for you in that you just need to have your User model use the `JumpGate\Users\Traits\HasSocials` trait and 
you're done.

> {warning} Make sure you add this since the login process expects the `addSocial()` and `hasProvider()` methods to exist on the 
user model.
