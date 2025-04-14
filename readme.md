# Jumpgate App

- [Requirements](#requirements)
- [Basic Installation](#basic-installation)
- [Windows Development](#windows-dev)
- [Reverb, Telescope, and Pulse](#optional-packages)

<a name="requirements"></a>
## Requirements

- [Laravel Server Requirements](https://laravel.com/docs/12.x/deployment#server-requirements)
- PHP 8.2+
- Node 23+
- npm 11+

<a name="used-packages"></a>
## Used Packages

| Package   | Version | Links                                                                                   |
|-----------|---------|-----------------------------------------------------------------------------------------|
| Laravel   | 12      | [Github](https://github.com/laravel/laravel)&nbsp;[Docs](https://laravel.com/docs/12.x) |
| Bootstrap | 5       | [Docs](https://getbootstrap.com/docs/5.3/getting-started/introduction/)                 |
| VueJS     | 3       | [Docs](vuejs.org/guide)                                                                 |
| InertiaJs | 2       | [Docs](https://inertiajs.com/)                                                          |
| LaraTrust | 8       | [Docs](https://laratrust.santigarcor.me/docs/8.x/)                                      |

<a name="basic-installation"></a>
## Basic Installation

1. `cd <project dir>`
2. `git clone git@github.com:JumpGateio/JumpGate.git ./`
3. `composer install`
4. `php artisan jumpgate:setup`
5. At this point you will need to modify your configs.
   1. Update `.env`
   2. Update `config/jumpgate/users.php`
6. `php artisan jumpgate:database`

This concludes the basic set up for JumpGate.  At this point you should be able to go to your site in the browser and
see the default JumpGate landing page.

> [!NOTE]
> Change the `public/img/site_logo.png` to your site image.  This is used in the auth files next to the form.

<a name="windows-dev"></a>
## Windows Development

- [Herd](https://herd.laravel.com)
  - This will manage php and node easily for you.
- [Beekeeper](https://www.beekeeperstudio.io)
  - This is a simple tool for MySQL.

<a name="optional-packages"></a>
## Reverb, Telescope, and Pulse

| Adding the Package               | Documentation                                             | Config File            | Description                              |
|----------------------------------|-----------------------------------------------------------|------------------------|------------------------------------------|
| `php artisan jumpgate:reverb`    | [Reverb Docs](https://laravel.com/docs/12.x/reverb)       | `config/reverb.php`    | Broadcasting Events                      |
| `php artisan jumpgate:telescope` | [Telescope Docs](https://laravel.com/docs/12.x/telescope) | `config/telescope.php` | Detailed insights on application actions |
| `php artisan jumpgate:pulse`     | [Pulse Docs](https://laravel.com/docs/12.x/pulse)         | `config/pulse.php`     | Performance insights                     |

We have default values in the config files that will work great with JumpGate.  You can make any changes you want or
remove these included config files if you don't want to use some of these packages.

We also have build in links for these in the menu bar.  `app/Http/Composers/Menu.php@generateRightMenu()` has these links
included by default.  Feel free to delete them if you are not using the packages.
