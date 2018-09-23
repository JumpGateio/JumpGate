# JumpGate App Walkthrough: Set Up

---

- [Introduction](#introduction)
- [Prerequisites](#prerequisites)
- [Directories](#directories)
- [Start Installation](#start-installation)
- [Database](#database)
- [User Config](#user-config)
- [Finish Installation](#finish-installation)
- [Social Auth](#social-auth)
- [Gravatar](#gravatar)

<a name="introduction"></a>
## Introduction

In this walk through we will be building a simple to do app starting with JumpGate.  It really should not take too long so 
feel free to follow along.

During this walkthrough I will be assuming you are using the prerequisites listed below and your set up using valet.  If 
you are using homestead or something else, modify the valet sections to suit your environment.

> {info} You can see the source code at [GitHub](https://github.com/JumpGateio/ToDo-Walkthrough).

> This step is stored as a branch called [set up](https://github.com/JumpGateio/ToDo-Walkthrough/tree/1-setup).

<a name="prerequisites"></a>
## Prerequisites

1. [Node](https://nodejs.org/en/download/)
    1. `npm install npm@latest -g`
1. [Yarn](https://github.com/yarnpkg/yarn)
    1. `npm install -g yarn`
1. [Composer](https://getcomposer.org/download/)
1. [Homebrew](http://brew.sh/)
1. PHP/MySql
    1. [Homestead](https://laravel.com/docs/5.3/homestead)
    1. [Valet](https://laravel.com/docs/5.3/valet)
        1. `brew update`
        1. `brew install homebrew/php/php70`
        1. `brew install php701.xdebug`
        1. `brew install mariadb`
        1. `composer global require laravel/valet`
        1. `valet install`
        1. `valet domain dev`
    1. [Sequel Pro](https://www.sequelpro.com/)

<a name="directories"></a>
## Directories

First, go make the directory you want your projects to live in.  I use `~/Code/` but use anything you want.

In your terminal go into that directory (`cd ~/Code`) and run `valet park`.  This will let valet start sharing the 
directory.  Make a directory inside this one with your project name.  We will be using `ToDo`.

```bash
cd ~/Code
valet park
mkdir ToDo
cd Todo
```

Now we will bring in JumpGate.  

<a name="start-installation"></a>
## Start Installation

To begin, we need to pull it in and get the basic files set up.

```bash
git clone git@github.com:JumpGateio/JumpGate.git ./
composer install
php artisan jumpgate:setup --users --force
```

This is doing a few simple things.  We grab the web app from github and install all of it's dependencies.  Next, we let 
jumpgate do the tasks we need.  This will create our `.env` file, generate a site key, run `yarn` and `npm run dev`.

Since we want users in our to-do app, we tell jumpgate to set up with users using the `--users` flag.  Also, since this is 
a fresh app, we use `--force` to allow the users package to overwrite some of our existing files.

Once this is done, we need to set up our database before continuing.

> {info} Have a look at the [overview](/docs/{{version}}/overview) to see what packages and versions are included.
 
<a name="database"></a>
## Database

With installation started, lets look to the database.  Since we will need one we should work on the design that we 
will need and get teh database set up.

Open up sequel pro and set up a connection to localhost.  It should have a host of `127.0.0.1`, a username of `root` and 
that's it.  Save and connect to the host and click the "`Choose database...`" drop down to select "`Add Database`".  Name 
it "`todo`" and click "`Add`".  That's it!  You now have a database waiting for data.

In your project, open `.env` and add the database details as follows.

```
DB_CONNECTION=mysql
DB_HOST="127.0.0.1"
DB_PORT=3306
DB_DATABASE=todo
DB_USERNAME=root
DB_PASSWORD=
```

Now, we need to configure how we want our users to work.

<a name="user-config"></a>
## User Config

We need to tell the user package how we want users to work.  In this app, I want to allow social authentication through 
google and not allow standard registration.  So I want to change the following settings in the `config/jumpgate/users.php` 
file.

```php
'require_email_activation' => false,
'enable_social' => true,
'social_auth_only' => true,
```

This will tell the package that we don't need to activate, we will be using social auth and we will not be using standard 
auth.  Enabling social auth adds some migrations and seeds to our app for us.

> {primary} Before moving on, you could look at the `config/jumpgate/acl.php` to see if you want to change how the acl 
tables are set up.

<a name="finish-installation"></a>
## Finish Installation

Now that we have our configs how we want them, it's time to finish installation.  By default, the users package adds a set 
of links to our navbar to allow standard login.  Since we are using social auth through google, we need to change 
this.  Open `app/Http/Composers/Menu.php`.  You need to change the default `generateRightMenu()` method to a more 
social friendly set of links.

**You want the method to look like this when done**
```php
    /**
     * Adds items to the menu that appears on the right side of the main menu.
     */
    private function generateRightMenu()
    {
        $rightMenu = \Menu::getMenu('rightMenu');

        if (auth()->guest()) {
            $rightMenu->link('login', function (Link $link) {
                $link->name = 'Login';
                $link->url  = route('auth.social.login', ['google']);
            });
        }

        if (auth()->check()) {
            $rightMenu->dropdown('user', auth()->user()->display_name, function (DropDown $dropDown) {
                $dropDown->link('user_logout', function (Link $link) {
                    $link->name = 'Logout';
                    $link->url  = route('auth.logout');
                });
            });
        }
    }
```

In this method we are now allowing users to log in through google.  This is how the users package expects social auth links 
to look.  The extra parameter is the provider you are letting them log in through.  This could be anything, but for our 
app we are using google.  Since we disabled registration, we removed that link entirely.

> {info} You can learn more about the link package by viewing the [quick start guide](/docs/{{version}}/menu-quickstart).

Now that everything else is done, we need to get our database set up to handle users.  To do this we call one simple 
command.

```bash
php artisan jumpgate:user-database 
```

The `user-database` command handles setting up all the database tables for users and seeding them for you.  As of now, our 
site and database are ready to get started.  You should be able to see your site at `http://todo.dev`.

<a name="social-auth"></a>
## Social Auth

First, lets add some dependencies we will need to make social auth work.

```bash
composer require laravel/socialite
php artisan package:discover
```

[Socialite](https://laravel.com/docs/5.7/socialite) is a laravel package that makes dealing with social authentication 
very easy.  A community has formed around this package and they create authentication helpers for many common APIs.  You 
can find all the options at the [Laravel Socialite Providers](https://socialiteproviders.github.io/about.html) site.  Since 
we want google we get off a bit easy.  It's included in Laravel Socialite already.


Let's generate our site's API details.  We have a [full guide on this](/docs/{{version}}/users-social-google) you can 
follow to get your details set up.  This guide will walk you through generating your client details and setting up all of 
your .env file values.

Now we need to set it up in our configs.  There are two places we add social provider details to: `config/services.php` 
and `config/jumpgate/users.php`.

The services one is pretty straight forward.  This file is used if you want to interact with the API.

```php
    'google'     => [
        'client_id'     => env('GOOGLE_KEY'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT_URI'),
    ],
```

In the user's config file, we need to give it a bit more detail.  This file is used to determine how we connect to a given 
provider through Socialite.

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

This is a fairly standard set of options for google auth.  Feel free to change it however you need to.  

So as of now, we have everything we need for the configs.  Now we need the User model to understand our social set 
up.  Open `App\Models\User` and add the `\JumpGate\Users\Traits\HasSocials` trait to the class.

```php
use \JumpGate\Users\Traits\HasSocials;

class User extends BaseModel
{
    use HasSocials;
}
```

That's all it takes to get our users to interact with social auth.  You should take the time to test this.  Go to your 
homepage (http://todo.dev/) and click "`Login`" in the top right.  It should redirect you to the Google auth page.  Select 
your email and click "`Allow`".  This should redirect you back to your site as a logged in user.  You should also see your 
email in the top right as a drop down.

<a name="gravatar"></a>
## Gravatar

If you would rather it show a gravatar icon instead of your email.  It's pretty easy to do.  First, add the following method 
to your User model.

```php
    /**
     * Generate a gravatar from a user's email.
     *
     * @return string
     */
    public function getGravatarAttribute()
    {
        $google    = $this->getProvider('google');
        $emailHash = md5(strtolower(trim($google->email)));

        return 'https://www.gravatar.com/avatar/' . $emailHash;
    }
```

Next, open up `app/Http/Composers/Menu.php` and change the user drop down.

**It should look like this when done**
```php
if (auth()->check()) {
     $rightMenu->dropdown('user', auth()->user()->gravatar, function (DropDown $dropDown) {
         $dropDown->type  = 'auth';
         $dropDown->right = true;
         
         $dropDown->link('user_logout', function (Link $link) {
             $link->name = 'Logout';
             $link->url  = route('auth.logout');
         });
     });
 }
```

The menu views already handle this for you.  So just refresh your app and you will see the gravatar icon instead of text.

Next up, let's start writing code!

> {info} The walkthrough continues in [Setting up your database](/docs/{{version}}/jumpgate-walkthrough-2-database).
