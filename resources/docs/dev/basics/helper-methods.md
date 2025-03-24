# Helper Methods

---

- [Core](#core)
    - [Base](#base)
    - [API](#api)
    - [Math](#math)
    - [Numbers](#numbers)
    - [Strings](#strings)
    - [Time](#time)
- [Database](#database)
- [Menu](#menu)
- [Auto View Resolution](#viewss)

## Available Methods

<a name="core"></a>
## Core

<a name="base"></a>
## Base

> {info} These are methods that are found in `helpers/base.php`.

### start_debug($name, $label)

This method is used to start a measurement with laravel debugbar.  It will use the name and label passed to it in the
measurement.

### stop_debug($name)

This method is used to stop a measurement with laravel debugbar.  It will use the name passed to it to find the measurement.

### pp($data, $return = false)

This is a simple helper for displaying output when you need to debug code.  It behaves very similarly to laravel's `dump()`
method.  If you pass return as true, it will return the output directly, otherwise it will echo it.

### ppd($data)

This is the same as `pp` but it adds a `die` at the end.  This is similar to laravel's `dd()` method (but not as pretty).

### objToArray($object)

The goal of this method is to convert an object into an array.  It will set the key of each array element as a `snake_case()`
of the property name.

<a name="api"></a>
## API

> {info} These helper methods are aimed at making guzzle calls easier to perform by handling the basic things for you.  They are
found in `helpers/api.php`.

### apiCall($call, $tap = null)

For this method, pass it the results of your call to guzzle (GET, POST, etc).  It will then wrap the results in a
`App\Models\Simple` model for ease of use.  If you pass the `tap` parameter, it will get that property from the results and
pass that to the model instead.

### apiCollection($call, $tap = null)

Similar to the previous method, this will return the results of your call as a collection of Simple models.  All other details
from the previous call apply.

<a name="math"></a>
## Math

> {info} These are all methods that will help you with common math needs.  They are found in `helpers/math.php`.

### percent($num_amount, $num_total)

This method will return the percent `$num_amount` is of `$num_total`.  It does not add the `%` string.

### decimal($num_amount, $num_total, $round = 2)

This method will return the decimal `$num_amount` is of `$num_total` to the `$round` decimal place.

### ordinal($cardinal)

This method will give you the number and it's ordinal suffix.  For example, passing `1` would return `1st`.

<a name="numbers"></a>
## Numbers

> {info} These are all methods that will help you with common number tasks.  They are found in `helpers/numbers.php`.

### toRomanNumeral($number)

As the name suggests, this will convert your number into string roman numerals.

<a name="strings"></a>
## Strings

> {info} These are all methods that will help you with common string tasks.  They are found in `helpers/strings.php`.

### classify($value)

This will convert a string to capitalized snake case.  For example `Hello world` would become `Hello_World`.

### humanReadableImplode($array, $separator = 'and')

This method will perform an implode on your array, but it will add `$separator` before the last entry.

```php
$array = [
    'Tom',
    'Bill',
    'Sam',
];

echo humanReadableImplode($array);
```

The above code would output `Tom, Bill and Sam`.

### json_validate($string)

This method will run `json_deode` on your string, then use `json_last_error` to figure out what actually happened and return
any error in a much more human readable way.

<a name="time"></a>
## Time

> {info} These are all methods that will help you with time conversions and ranges.  They are found in `helpers/time.php`.

### setTime($time)

This method is used extensively in our default Models.  It will take the time you give it and do a few things.

1. Grab the app timezone from the config.
1. If a user is logged in
    1. It will switch to that user's timezone from the `user_details` table.
    1. It will return the time converted from their timezone into UTC.
1. If not, it will return a carbon parse of that time in the app timezone.

### getTime($time)

This is the counterpart to `setTime()`.  This method will convert the time from UTC into either the app timezone or the
user's if they are logged in.

### carbonParse($date)

This is basically a shorthand for `\Carbon\Carbon::parse($time)`.  However, if a user is logged in, it will set the carbon
object to the user's timezone.

### convertToSeconds($time)

This method will convert a time signature (HH:MM:SS) into seconds by splitting the string and multiplying to get the number
of seconds that time would be.

### convertFromSeconds($time)

Alternately, this will take a number of seconds and tell you how many weeks, days, hours, minutes and remaining seconds
it equates to.

### secondsToReadable($seconds)

This is similar to the above, but it is more readable.  The output would be something like `2 days 10 hours 43 minutes
and 2 seconds`.

<a name="database"></a>
## Database

> {info} All database helper methods are found in `helpers.php`.

### collector($value = null)

This is a helper method to create a new `\App\Collections\EloquentCollection` with your value supplied.

### supportCollector($value = null)

This is a helper method to create a new `\App\Collections\SupportCollection` with your value supplied.

<a name="menu"></a>
## Menu

> {info} All menu helper methods are found in `helpers.php`.

### menu($menuName = null)

This is a helper method for creating a new menu container or finding one that already exists with the `$menuName`.

<a name="views"></a>
## Auto View Resolution

> {info} All view resolution helper methods are found in `helpers.php`.

### viewResolver()

This is a quick helper to get the ViewResolver out of the app container.

### inertiaResolver()

This is a quick helper to get the InertiaResolver out of the app container.

### checkDebugbar()

All this method does is check is the app is in local env and has the debugbar bound.  This is used throughout the package
to only take actions with the debug bar when it is necessary.
