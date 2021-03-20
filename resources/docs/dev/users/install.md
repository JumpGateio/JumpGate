# Users

---

- [Install From Scratch](#install-from-scratch)
- [Install Using Command](#install-using-command)
- [Install Manually](#install-manually)
- [Finish Set Up](#finishing-set-up)

<a name="install-from-scratch"></a>
## Install From Scratch

To install users on a brand new jumpgate app is really easy.  When you are setting up, modify your `jumpgate:setup` command.

Instead of:
```bash
php artisan jumpgate:setup
```

Run:
```bash
php artisan jumpgate:setup --users --force
```

> {info} The `--force` flag allows users to publish over existing files.

<a name="install-using-command"></a>
## Install Using Command

To do this, you can run the `php artisan jumpgate:setup-users` command from your terminal.  You can add the `--force` flag. 
but be warned, this will overwrite some of your files.  To see a full list of what files will be written you can look on 
the [JumpGate Users GitHub](https://github.com/JumpGateio/Users/tree/master/src/publish).

<a name="install-manually"></a>
## Install Manually

If you don't want to use the built in commands, you can install users manually anytime.  Just follow these steps.

```bash
composer require jumpgate/users
php artisan package:discover
php artisan vendor:publish --provider="JumpGate\Users\Providers\UsersServiceProvider"
```

At this point you will want to update your new `config/jumpgate/users.php` file.  Make sure to check the big things such 
as whether or not you want social auth and if you want that to be the only auth.  Once you are done editing this file, can 
finish up.

<a name="finishing-set-up"></a>
## Finishing Set Up

In all of the above cases you will still want to update your `config/jumpgate/users.php` file and then run this last 
command.  This command sets up the database and seeds everything.

```bash
php artisan jumpgate:user-database
```
