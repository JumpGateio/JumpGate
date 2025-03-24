# Upgrade to 10.0

- Laravel updated to 12
- PHP updated to 8.2
- Upgraded npm to 22
- Fixing setup command to use new features
  - Allows different versions of font-awesome.
- Pulled extra JumpGate packages into this app.
  - Menu, Core, Database, ViewResolution
- Removed bootstrap 4 and inserted tailwind

# Upgrade to 9.0

- Laravel updated to 9
  - [Upgrade guide](https://laravel.com/docs/9.x/upgrade)
- PHP updated to 8.0.2
  - `brew update`
  - `brew tap shivammathur/php`
  - `brew install shivammathur/php/php@8.0`
  - `brew link --overwrite --force php@8.0`
  - Set PHP settings in phpstorm to 8.0, and CLI interpreter should be at `/usr/local/Cellar/php@8.0/8.0.16//bin/php`
- Removed larecipe
  - Not updated to Laravel 9 as of version 2.4.4
  - When it comes back:
    - Add back to `composer.json`.
    - Uncomment its entry in `app/Http/Composer/Menu.php`.
    - Uncomment the setup code in `app/Console/Commands/JumpGate/SetUp.php` in the `handleAssets()` method.
- Upgraded npm to 16.14.0
  - `nvm install 16.14.0`
  - `nvm use`
  - Run `npx browserslist@latest --update-db` to remove warnings during `npm` commands.
