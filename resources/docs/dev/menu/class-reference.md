# Menu Class Reference

---

- [Container](#container)
    - [getMenu](#get-menu), [add](#add), [exists](#exists), [hasLinks](#has-links), [render](#render), [Active](#active)
- [DropDown](#drop-down)
    - [isDropDown](#drop-down-is-drop-down), [hasLinks](#drop-down-has-links), [disableActiveParentage](#disable-active-parentage), [activeParentage](#active-parentage), [toJson](#drop-down-to-json)
- [Link](#link)
    - [getOption](#get-option), [isDropDown](#link-is-drop-down), [toJson](#link-to-json)
- [Menu](#menu)
- [Middleware](#middleware)
- [Traits](#traits)
    - [Activate](#activate), [Insertable](#insertable), [Linkable](#linkable)

<a name="container"></a>
## Container

The container class is what holds all the different menus you create in your app.  You can access this class in a couple of 
ways.

```php
// New Instance
$menu = (new Container)->getMenu('leftMenu');

// Facade
$menu = \Menu::getMenu('leftMenu');

// Helper
$menu = menu()->getMenu('leftMenu');

// For getMenu specifically, you can just pass the menu name to the helper.
// If you don't pass a menu name, it just returns a container instance.
$menu = menu('leftMenu');
```

The Container class extends Laravel's Support\Collection class.  It has all methods available there.  It's list of items 
is the menus you have added.  Each menu is 1 item.

<a name="get-menu"></a>
## getMenu($menuName)

This method is pretty simple, it just checks if the container has a menu with the name.  If it does, it returns the menu 
object.  If not, it creates a new one and returns that object.

<a name="add"></a>
## add($menuName)

This creates a new Menu object with the name given and places it in the Container's `items` array.  All menu names are 
passed through the `snakeName()` method on the way in to add uniformity when handling them later.

<a name="exists"></a>
## exists($menuName)

Here we use the local `getMenuObject()` method to search for a menu with the provided name.  It returns true if a menu 
with a matching name is found with the `items` array.

<a name="has-links"></a>
## hasLinks($menuName)

All this does is count the `links` property on the menu with the given name.  If greater than zero it returns true.

<a name="render"></a>
## render($menuName)

This is kind of the most important method on the class.  This is what is responsible for converting the menu into something 
ready for the front end.  It verifies that the menu exists and then makes sure to update the active setting for the 
menu. 

<a name="active"></a>
## Active

The idea of Active is saying that you want a particular link to be set as active.  There are a few methods within the class 
and a middleware that will help you do this on your own.  If you want to set it manually on a menu you can.  You can pass 
your slug to `setActive($slug)`.  This will explode by `::`, so if you want to make more than 1 link active you can.  When 
the `render()` method is called, it runs a local method called `updateActive()`.  This is what handles actually setting each 
matching link as active.  It also uses this time to set parents as active in the case of drop downs.  You can tell a drop 
down to use active parentage (going active when any of its child links becomes active) by setting the `activateWithLinks` 
property to true on your drop down.  It is set to true by default.

<a name="drop-down"></a>
## DropDown

Since DropDown and Link both use the Linkable trait, they will have similar methods.  So it will look odd at first, but it 
is necessary to the system as a whole.

<a name="drop-down-is-drop-down"></a>
## isDropDown()

This method simply returns true.  It is used when going through all links on a menu and determining if the link is a drop 
down or a single link.

<a name="drop-down-has-links"></a>
## hasLinks()

This counts the `links` property on the drop down.  If there are more than zero, it returns true.

<a name="disable-active-parentage"></a>
## disableActiveParentage()

Just sets the `activateWithLinks` property to false.  

<a name="active-parentage"></a>
## activeParentage()

Returns the value of the `activeWithLinks` property.

<a name="drop-down-to-json"></a>
## toJson($options)

This attempts to convert the drop down as a whole to a valid json object.  This is useful if you want it in json format to 
be used in javascript or in an API for any reason.

<a name="link"></a>
## Link

This class is used for individual links.  They can either be assigned directly to a Menu object or they can be a link inside 
of a DropDown object.

<a name="get-option"></a>
## getOption($name)

This looks through the `options` array property on the class and returns its value.  If it does not find an option with the 
given name it will return false.

Options are set when creating the link.  They can contain any keys/values you want.

```php
$leftMenu->link('docs', function (Link $link) {
    $link->name              = 'Documentation';
    $link->url               = route('larecipe.index');
    $link->options['inertia] = false;
});
```

<a name="link-is-drop-down"></a>
## isDropDown()

For the Link class this will always return false.

<a name="link-to-json"></a>
## toJson($options)

This attempts to convert the Link as a whole to a valid json object.  This is useful if you want it in json format to 
be used in javascript or in an API for any reason.

<a name="menu"></a>
## Menu

This class is pretty much just a DTO containing links and a name.  It uses the Linkable and Insertable traits and contains 
no other unique methods of its own.

<a name="middleware"></a>
## Middleware

The Menu package includes a helpful middleware to handle setting links as active when you are on their route.  To enable this 
you will need to add the middleware to your `app/Http/Kernel.php`.

```php
protected $routeMiddleware = [
    ...existing middleware...
    'active' => \JumpGate\Menu\Middleware\MenuMiddleware::class,
];
```

> {info} This part is set by default in the JumpGate repository.

To use the middleware, you have to add `active:<slug>` to your routes middleware.  Lets assume you have a link similar to 
the following example.

```php
$leftMenu->link('docs', function (Link $link) {
    $link->name = 'Documentation';
    $link->url  = route('larecipe.index');
});
```

The slug you would care about is the `docs`.  It is always the first parameter passed to both the `link()` and the `dropDown()` 
methods.  So to set the above link as active, you would need something like the following in your route.

```php
$router->get('docs')
       ->name('docs.index')
       ->uses('DocumentController@index')
       ->middleware('active:docs');
```

The important piece is that the value after the `:` is the same as the first parameter in the `link()` method.  Doing this 
will automatically add `active => true` to your links/drop down with the slugs match.  Below I have included some non-class 
based route examples.

```php
Route::get('/', [
    'middleware' => 'active:home', // menu is the middle ware and home is the slug of your menu item.
    'as'         => 'home',
    'uses'       => 'HomeController@index'
]);

Route::group(['namespace' => 'App\Http\Controllers', 'middleware' => 'active:home'], function () {
    Route::get('/', [
        'as'   => 'home',
        'uses' => 'HomeController@index'
    ]);
});
```

<a name="traits"></a>
## Traits

The traits shipped with this package are used by the different container classes (Menu, Link, DropDown) to easily share 
functionality.

<a name="activate"></a>
## Activate

This trait is used by the DropDown and Link classes.  It simply adds the `active` property to the class (defaulting to 
false).  It then adds the `setActive()` and `isActive()` methods.

<a name="inertable"></a>
## Insertable

This trait is used by Menu, DropDown, and Link.  This is an odd one.  It attempts to allow you to insert an item at a 
specific point in the list.  It adds the `insert = false` property to the class.  It gives you access to `insertAfter($slug)`, 
and `insertBefore($slug)` methods.  These will use the slug and walk through the items on the class.  Once it finds the 
slug passed, it will try to insert the new item before or after the slug depending on which method you called.

```php
$menu = menu('test');

$menu->link('slug', function () {
    //
});

$menu->link('slug2', function (Link $link) {
    $link->insertBefore('slug');
});
```

In this example, slug2 would be the first link in the list of that menu.

<a name="linkable"></a>
## Linkable

This trait is used by the Menu, and DropDown classes.  This traits is used when a class can have links on it.  It sets the 
`menu` property (the parent menu to this class), and `links` property (should be set to a collection by the class's constructor).  It 
adds a `dropDown($slug, #name, $callback)` method.  This is used to add a new drop down link.  It also has a `link($slug, $callback)` 
method.  It has the `getMenu()` we covered at the beginning as well.  Basically, this trait is what you use most when creating 
the menu in your app.
