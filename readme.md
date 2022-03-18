# Jumpgate App

- [Requirements](#requirements)
- [Basic Installation](#basic-installation)
  - [Telescope & Websockets](#telescope--websockets)
- [Users](#users)

<a name="requirements"></a>
## Requirements

- PHP 8+
- Node 15+
- npm 15+

<a name="basic-installation"></a>
## Basic Installation

```
cd <project dir>
git clone git@github.com:JumpGateio/JumpGate.git ./
composer install
php artisan jumpgate:setup
```
At this point, your site will display the JumpGate home page using bootstrap 4.

1. Set up your database in the `.env` file
2. Set up your preferences in `config/jumpgate/users.php`.
3. Run `php artisan jumpgate:database --users`.
4. Run `php artisan jumpgate:telescope` if you want telescope monitoring on the site.
   1. [Telescope Docs](https://laravel.com/docs/9.x/telescope)
5. Run `php artisan jumpgate:events` if you want to broadcast events using echo.
   1. [Laravel Websockets Docs](https://beyondco.de/docs/laravel-websockets/getting-started/introduction)

<a name="telescope-websockets"></a>
### Telescope & Websockets

Telescope and laravel websockets are not assumed to be installed, but there are pieces of it be default for ease of use.

- `config/telescope.php` & `config/websockets.php`
  - These files are included with jumpgate by default.
  - They have sensible settings for a normal jumpgate app.
  - Delete them freely if you don't want either package.
- `app/Http/Composers/Menu.php`
  - In the `generateRightMenu()` method, there is a commented out link for telescope and websockets.
  - If you install one of the packages, uncomment its entry there..
  - If you chose not to use one, you can freely remove that block.
