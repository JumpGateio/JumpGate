# InertiaJs

---

- [Basics](#basics)
- [Turning It Off](#turning-it-off)
- [Helper Methods](#helper-methods)
    - [inertia()](#inertia)
    - [render()](#render)
    - [ajaxResponse()](#ajax-response)
    - [error()](#error)
    - [success()](#success)

<a name="basics"></a>
## Basics
InertiaJs is a powerful framework for creating single page apps.  It uses a clever way of dynamically loading the needed 
javascript for a page and only what is needed.  Combined with its ability for persistent layouts and along with events 
and you can create a page that loads and operates with shocking speed.

- [Further reading on their site](https://inertiajs.com/)
- [Inertia Javascript Repo](https://github.com/inertiajs/inertia)
- [Inertia Laravel Repo](https://github.com/inertiajs/inertia-laravel)

<a name="turning-it-off"></a>
## Turning It Off
By default, this site will use inertia by making use of the render helper methods shown below.  To not use inertia you 
need to extend `BaseController` instead of `InertiaController` and then simply change the return of your controller 
methods.

*From:*
```php
return $this->inertia($data);
```

*To:*
```php
$this->setViewData($data);
return $this->view();
```

These helper methods handle everything.  The `inertia()` helper is just a wrapper for inertia's render method coupled with 
Jumpgate view resolution's auto discovery.  When returning `view()` it triggers JumpGate's auto view resolution to use blade 
files like normal laravel apps.

Any POST methods you have will need to switch away from the inertia helpers and use standard ways of handling them.

<a name="helper-methods"></a>
## Helper Methods
In order to handle the boilerplate that is needed for the server side of inertia, we have created helper methods in the 
BaseController.  These are designed to help you with common GET and POST requests.

<a name="inertia"></a>
### `inertia($data = [], $page = null)`
This helper method is unique.  It is stored in the `AutoResolvesViews` trait pulled into the `BaseController` class.  It 
uses the [auto view resolution package](/docs/{{version}}/views-usage) to determine where your component should be.

Instead of the inertia built in style of:

```php
Inertia::render('Home/Index', compact('loggedIn'));
```

You can simply do:

```php
return $this->inertia(compact('loggedIn'));
```

The view resolution will determine the most likely location for your component based on the route.  It takes prefixes into 
consideration and keeps hunting till it finds an existing file.  You can see what files it looked for in the "attempted views" 
section in the debugbar's "Auto resolved view" tab.

If you need to specify a unique location for the component you can use the second parameter.

```php
return $this->inertia(compact('loggedIn'), 'Home/Welcome');
```

The resolution will always check for capitalized names in the `resources/js/Pages/` directory.

> {info} You can read more on this in the [auto view resolution docs](/docs/{{version}}/views-usage).

<a name="render"></a>
### `render($page, $data = [])`
Inertia needs to know 2 things to render a page:

1. The page location in your `/resources/js/Pages/` directory.
1. Any data you want to send to it.

The render method helps with this.  All of your inertia vue pages should be located in `/resources/js/Pages/`.  So the 
first parameter you would pass would be `<Directory>/<Vue file>`.  The second parameters is any data you wish to send.  A 
`compact()` should be all you need here.  Using the simplest example found in the HomeController, here is what it looks 
like.

```php
public function index()
{
    $loggedIn = auth()->check();

    return $this->render(
        'Home/Index',
        compact('loggedIn')
    );
}
```

This example will load the Vue component in `/resources/js/Pages/Home/Index.vue`.  It will then pass a prop to that 
component with the name of `loggedIn`.  You can get the prop like normal though I would strongly suggest giving it an 
expected type.

```vue
props: {
  loggedIn: Boolean,
},
```

<a name="ajax-response"></a>
### `ajaxResponse($callback, $extras = [])`
This method is useful when you are handling a standard POST request.  It runs the code in the callback and then returns 
a `success()` or `error()` based on what happens.

Here is an example version from a game site that was worked on.

```php
/**
 * Ajax call to deposit money from the character to the bank account.
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function deposit()
{
    return $this->ajaxResponse(function () {
        $amount = (new BankManager())->deposit(request('amount'));

        return 'You have deposited ' . $amount . ' credits.';
    });
}
```

As you can see, we do the meat of the request inside the callback.  If anything it runs in the callback throws an exception, 
the helper method will catch it and return using the `error()` method.  If it passes, it will return with the `success()` 
method and pass the returned string as the success message.

This simple wrapper has saved a lot of unnecessary repeated code.  Use it when you don't need anything specific and this 
general approach will work.

Just for a bit of completeness, below is an example Vue ajax call that would use this method.

```javascript
submit()
{
    this.sending = true;
    axios.post(this.route('bank.deposit'), {'amount': this.amount})
        .then((response) => {
            this.bank.amount += this.amount
            this.amount = 0
            
            this.bootbox('success', response.data.message)
        })
        .catch((error) => {
            this.bootbox('danger', error.response.data)
        })
        .finally(() => this.sending = false)
},
```

The `ajaxResponse()` helper will return an error if it fails.  That error will be caught by the `.catch()`.  If it succeeds 
the resulting success message will be in `response.data.message` and this code will create a nice pop up showing the user 
that message.

<a name="error"></a>
### `error($message, $code = 400)`
This helper is used to return an error to the inertia client side.  The `$message` parameter should be one of 2 things:

1. A string containing the message you want the error to display.
1. An exception that will be parsed for the error message and the error code.

There are some sanity checks for incorrect status codes, but otherwise this will work for your needs.  Here is an example 
using this method specifically instead of using it inside the `ajaxResponse()` helper.

```php
if ($character->user_id !== auth()->id()) {
    return $this->error('That character does not belong to you!');
}

try {
    $manager = new Career;
    $manager->selectJob($career);
} catch (\Exception $exception) {
    return $this->error($exception);
}
```

This shows both the string and the exception ways of using it.  In Vue components you can get this from `axios` call 
with `error.response.data`.

<a name="success"></a>
### `success($message, $extras = [])`
The success helper is much simpler.  It just returns a JSON response with code 200 and whatever message you send it.

```php
/**
 * Handle selecting a new active character.
 *
 * @param \App\Services\Characters\Models\Character $character
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function update(CharacterModel $character)
{
    if ($character->user_id !== auth()->id()) {
        return $this->error('That character does not belong to you!');
    }

    (new Config)->setActiveCharacter($character->id);

    return $this->success('Switched to ' . $character->name . '!');
}
```

Normally, this will be used in the `ajaxResponse()`, but if you need to call it manually, its super simple to do so.  In 
Vue components you can get this from `axios` call with `response.data.message`.
