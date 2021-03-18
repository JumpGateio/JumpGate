# Switching Between Blade and Inertia

---

- [Controller](#controller)
- [Users](#users)

<a name="controller"></a>
## Controller

To start with, you will want to switch the `BaseController::response()` method to the version you want to use.

For Inertia, it should look like this:
```php
public function response($data = [], $page = null, $layout = null)
{
    return $this->inertia($data, $page);
}
```

For Blade, it should look like this:
```php
public function response($data = [], $page = null, $layout = null)
{
    $this->setViewData($data);
    return $this->view($page, $layout);
}
```

As long as all of your controller have been using the `response()` method, this will handle everything.  If you are using 
the unique methods (`view()`, `inertia()`, `success()`, `error()`, `ajaxResponse()`) you will need to switch those individually.

You can also freely remove the `UsesInertia` trait from the `BaseController`.

<a name="users"></a>
## Users

If you are using the `JumpGate/Users` package, you have a few more things to fo.  In the `config/jumpgate/users.php` file, 
you would want to switch your `driver` entry to either `blade` or `inertia` depending.  Next, you will want to republish 
the user files so that it can load the correct ones.

```bash
php artisan vendor:publish --provider="JumpGate\Users\Providers\UsersServiceProvider"
```

This will do a few things.  Without the `--force` flag it wont overwrite any existing files, so make sure to leave this off 
if you have already begun working with the use files.  The main reason you are calling this is to get the auth and admin 
front end files.  The blade files will be located in `resources/views/vendor/`.  The inertia ones will be in 
`resoirces/js/Pages`.  In either case it creates folder for `admin` and `auth`.  Whichever one you switch to, you can safely 
delete the other versions.

> {info} All the controllers in the users package use the `response()` method.  There is no need to update the controllers.
