# Helper Classes

---

- [Controller](#controller)
- [Response](#response)
- [Route](#route)
- [Seeder](#seeder)
- [Transformer](#transformer)

<a name="controller"></a>
## Controller

The JumpGate BaseController class adds a lot of extra functionality to help with common tasks.  To use it you should have 
your `Controller` class (the one all of your other controllers extend) extend 
`JumpGate\Core\Http\Controllers\BaseController`.  In a standard jumpgate application, `App\Http\Controllers\BaseController` 
already extends this, so you can extend that class instead.

### Helper Methods

#### setViewData()
This method allows you to pass data to the view.  It accepts either a key/value pair of parameters or it will accept PHP's 
`compact()` function.

```php
$this->setViewData('user', User::find($userId);
$this->setViewData(compact('user'));
```

> {primary} Both of these will send a variable named `$user` to the view.

#### setJavascriptData
This method allows you to pass data directly to javascript.  It accepts either a key/value pair of parameters or it will accept PHP's 
`compact()` function.  You can access this in your javascript by using your set namespace followed by the variable name.

> {primary} You can set your namespace in `app/config/javascript.php` or in you `.env` file using the key 
`JS_NAMESPACE`.  It is `app` by default.

In your controller:
```php
$this->setJavascriptData('user', User::find($userId);
$this->setJavascriptData(compact('user'));
```

> {primary} All of these will send a variable named `js_namespace.user` to javascript.

In your javascript:
```
let user = js_namespace.user
````

<a name="response"></a>
## Response

The `JumpGate\Core\Services\Response` class is meant to make handling responses in your app much easier.  This is used 
throughout our packages, but below is an example from `JumpGate\Users\Services\Login`.

```php
private function handleSuccessfulLogin()
{
    event(new UserLoggedIn(auth()->user()));
    
    // Update the user with the log in details.
    auth()->user()->updateLogin();
    
    return Response::passed('You have been logged in.')
                   ->route('home');
}
```

In this method, we fire an event that the user has logged in and update the timestamp for the user's last login.  Then we 
use the response class to handle the message.  We initialize the response as a passing/successful response and give it the 
message to flash to screen.  We then tell it where it should redirect to.  When a controller returns a response object it 
will handle the redirection for you.

> {info} You can also use `redirectIntended()` to use the route a user was trying to access first.

<a name="route"></a>
## Route

> {info} You can learn more about class based routing in [their docs](/docs/{{version}}/core-class-based-routing)

The `JumpGate\Core\Http\Routes\BaseRoute` class is used when you make a class route.  All your class routes should extend 
this base class as it has all the methods the contract expects.  It defines the different parts a route group can contain 
and getters and setters for them all.

<a name="seeder"></a>
## Seeder

Have your seeds in `database/seeds/` extend `JumpGate\Core\Abstracts\Seeder`.  This class adds a method called `truncate()` that 
will truncate any table regardless of indexes.

<a name="transformer"></a>
## Transformer

The `JumpGate\Core\Abstracts\Transformer` class will enforce a contract on your transformer that it must contain a 
`transform()` method. It will also give you access to the `transformAll($resources)` method that will transform all items 
in `$resources` and place them in a collection. 
