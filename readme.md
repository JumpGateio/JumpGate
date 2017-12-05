# Jumpgate App

- [Commands](#commands)
- [Users](#users)

<a name="commands"></a>
## Installation

```
cd <project dir>
git clone git@github.com:JumpGateio/JumpGate.git ./
composer install
cp .env.example .env
php artisan key:generate
yarn
npm run dev
```
At this point, your site will display the JumpGate home page using bootstrap 3.  From here on out, you will customize as you normally would.

> You can run `php artisan css:set uikit` to switch the front end to uikit.

1. Set up your database in the `.env` file
1. Run `php artisan migrate`.

<a name="users"></a>
## Users

If your site will need users you have 3 choices here.  

1. Install the [JumpGate-Users repository](/1-Getting%20Started/2-Users%20Install.md) instead.
1. Run through [adding users](/1-Getting%20Started/3-Add%20Users%20to%20Base%20Install.md) to a base JumpGate installation.
1. Create your own users system.
