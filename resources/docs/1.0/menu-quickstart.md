# Menu Quick Start

---

- [Introduction](#introduction)
- [Creating a new menu](#creating)
- [Adding a link to the menu](#add-link)
- [Adding a drop down to the menu](#add-drop-down)
- [Accessing the menu](#accessing)

<a name="introduction"></a>
## Introduction
This is a short guide meant to get you up and running quickly with our custom menu system.

> {success} To learn more about the methods available check out the 
[class references](https://github.com/JumpGateio/Menu/tree/master/docs/2%20-%20Class%20Reference), or the 
[full example](https://github.com/JumpGateio/Menu/blob/master/docs/3%20-%20Sample/1%20-%20Full%20code%20example.md).

<a name="creating"></a>
## Creating a new menu

When adding a new menu you need to specify the menu name. This is the name that will be used to access the menu object in 
the future.

```php
$leftMenu = \Menu::getMenu('leftMenu');
// $leftMenu = menu('leftMenu');
```

<a name="add-link"></a>
## Adding a link to the menu
To add a link to the menu you just call the method `link()`. This method takes a slug as the first parameter.
This slug is used in `insertAfter()` and `insertBefore()`. The second parameter is a callback with your link data.

```php
$leftMenu->link('home', function (Link $link) {
    $link->name      = 'The name of the link';
    $link->url       = 'A url or you can use the route method with a laravel named route';
    $link->options[] = 'Add another option here';
});
```

<a name="add-drop-down"></a>
## Adding a drop down to the menu
To add a dop down just add use the `dropDown()` method. The first parameter is the slug. The second is the display text 
for the drop down.  The third is a call back where you wil add your link methods.

```php
$rightMenu->dropDown('user', auth()->user()->email, function (DropDown $dropDown) {
    $dropDown->link('profile.edit', function (Link $link) {
        $link->name = 'Edit your profile';
        $link->url  = 'user/profile/';
    });
    $dropDown->link('logout', function (Link $link) {
        $link->name = 'Logout';
        $link->url  = route('auth.logout');
    });
});
```

<a name="accessing"></a>
## Accessing the menu
Anywhere in your code base after the menu has been created you can call the `render()` method.

```php
$menu = \Menu::render('leftMenu');
// $menu = menu()->render('leftMenu');
```

This will return your menu object. From there you can loop through the links and add the appropriate html.

```blade
@foreach ($menu->link as $link)
    <a href='{ {$link->url}}'>{ {$link->name}}</a>
@endforeach
```
