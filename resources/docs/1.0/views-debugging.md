# Debugging Auto Views

---

- [Debugbar](#debugbar)
- [Debug Method](#debug-method)

<a name="debugbar"></a>
## Debugbar

If you are using debugbar then things get even easier.  When this package sees that debugbar is registered in the container 
then it starts collecting data about the view resolution for use in the debugbar.

To make it start collecting, just add the collector to the debugbar config (`configs/debugbar.php`).

```php
'collectors' => [
    ...
    'auto_views'      => true,  // Auto resolved view data
    ...
],
```

Once this is set up you will see a new tab on the debugbar for "Auto Resolved View".

![DebugBar Tab](https://raw.githubusercontent.com/JumpGateio/ViewResolution/master/docs/assets/images/debugbar_tab.png)

<a name="debug-method"></a>
## Debug Method

If you are not using [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) then you can use the `debug()` 
method.  To use this simply call `viewResolution()->debug()` anywhere after you have called `$this->view()` in your 
controller method.  This method returns the view model as is.  To make it readable wrap it up in a `dd()`.

```php
public function index()
{
    // Some logic
    
    $this->view();
    
    dd(viewResolution()->debug());
}
```

Once called it will print out something like the example below.

```php
ViewModel {#231 ▼
  +prefix: null
  +controller: "home"
  +action: "index"
  +view: "home.index"
  +prefixes: Collection {#228 ▼
    #items: array:3 [▼
      0 => "admin"
      1 => "home"
      2 => "dashboard"
    ]
  }
  +attemptedViews: Collection {#227 ▼
    #items: array:3 [▼
      0 => "admin.home.dashboard.home.index"
      1 => "admin.home.index"
      2 => "home.index"
    ]
  }
}
```

If no view was found, `$view` will be null. Likewise, if the view was found without a prefix, the prefix will be null.
