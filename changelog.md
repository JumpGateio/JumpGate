# Upgrade to 5.0

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
- Upgraded npm to 16.14.0
  - `nvm install 16.14.0`
  - `nvm use`
