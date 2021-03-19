# Published Files

---

- [Introduction](#introduction)
- [Commands](#commands)
- [Http](#http)
- [Models](#models)
- [Services](#services)
- [Configs](#configs)
- [Factories](#factories)
- [Front End](#front-end)

<a name="introduction"></a>
## Introduction

When you run `php artisan vendor:publish --provider="JumpGate\Users\Providers\UsersServiceProvider"` to publish the user 
files, we add a lot of stuff to your app.  This document will go over each, where they go, and what they do.

> {warning} If you add the `--force` flag when running `jumpgate:set-up --users --force` it will overwrite 
whatever you have in these files already.  Only use `--force` if you are certain it wont remove your work.

<a name="commands"></a>
## Commands

The only command we add is the UserDatabase command.  This is used after you have run `jumpgate:set-up` and after you have 
modified the `config/jumpgate/users.php` to the settings your app needs.  The UserDatabase command runs the following commands 
for you.

```bash
php artisan laratrust:migration
php artisan migrate
php artisan db:seed --class="UserStatus"
php artisan db:seed --class="LaratrustSeeder"
```

Basically, after you set up your config, this handles getting the database up and running.

<a name="http"></a>
## Http

We also add new composer files to `app/Http/Composers`.  It overrides your `Menu.php` and `AdminSidebar.php` composer classes 
to add the new auth routes.  In `Menu.php` it adds an auth section to the `rightMenu` for login, register and logout.  For 
`AdminSidebar.php` it adds all the admin routes that come stock with the package.

It also overwrites the `Authenticate` middleware to add the `redirectTo()` handling.

<a name="models"></a>
## Models

We automatically publish a `User.php` model to `app/Models` for you.  This extends `JumpGate\Users\Models\User` and adds 
the `Illuminate\Notifications\Notifiable` and `JumpGate\Users\Traits\HasSocials` traits.  Notifiable works along side the 
notification classes we add for you and the ones you add.  The HasSocials trait adds the ability to interact with the 
`user_socials` table easily.

<a name="services"></a>
## Services

This package publishes a single service to your app inside the `app/Services` directory.  We only add the Admin area to your 
site for you.  This service will display and handle users for you in the admin panel.

We add a dashboard to show you how to use the included tile helper to display information.  We also add an artisan route.  This 
page will allow you to run any artisan command from the web interface.  It will work on any command added to your site, including 
custom ones.

For the user side, we add all the basic needs.  Create, edit and delete users.  Take any available action on them (restore 
deleted, re-send invite, block, reset password) with all pages set up and ready.  Any potentially dangerous action goes through 
a confirmation page first.  We also add CRUS operations for the user statuses.  Both users and statuses also have a full 
search set up.

<a name="configs"></a>
## Configs

The only config we publish is an update for `config/routes.php`.  The only change we make is a new entry to find the User 
route classes this package adds.  They are located in `vendor/jumpgate/users/src/JumpGate/Users/Http/Routes`.

<a name="factories"></a>
## Factories

All models this package has have a matching factory which is included for you and ready to go for testing.  We decided to 
publish these instead of keep them in the package since you may make changes to any of these tables and then need to modify 
the factories.

<a name="front-end"></a>
## Front End

Lastly, we publish a lot of front end files for you.  Depending on which driver you set in the config, we either publish 
blade files or vue components.  These handle login, registration, invitations, password resets and all the admin pieces 
needed.  Blade files are published to `resources/views/vendor` and vue files are published to `resources/js/Pages`.
