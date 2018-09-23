# JumpGate App Walkthrough: Database

---

- [Introduction](#introduction)
- [Directories](#directories)
- [Planning the tables](#planning-the-tables)
- [Migrations](#migrations)
- [Models](#models)
- [Slugging](#slugging)

<a name="introduction"></a>
## Introduction

In this step of creating our todo app, we are going to build out the todo service.  We call this architecture a 
micro-service.  You can learn more about how we view this in our [micro services doc](/docs/{{version}}/jumpgate-micro-services).

> {info} You can see the source code at [GitHub](https://github.com/JumpGateio/ToDo-Walkthrough).

> This step is stored as a branch called [database](https://github.com/JumpGateio/ToDo-Walkthrough/tree/2-database).

<a name="directories"></a>
## Directories

To start off, we need our folders.  Create a folder called `ToDo` in your `app/Services` folder.  This is where all of our code 
for the todo system will live.  We will need a few folders in here by default.

```bash
📁app
  📁Services
    📁ToDo
      📁Http
        📁Controllers
        📁Routes
      📁Models
```

This should look somewhat familiar to you.  This is basically a miniature version of the app directory.

<a name="planning-the-tables"></a>
## Planning the Tables

Let's start with the data.  We need somewhere to store our lists and tasks.  To do this we will need database tables 
and models to interact with them.  I know the basic data structure I want, and detailed the basic structure below..

```php
# todo_lists
id:            auto increments primary key
user_id:       unsigned foreign key
name:          string not null
slug:          string not null
description:   text nullable
complete_flag: boolean default(0)
timestamps

# todo_tasks
id:            auto increments primary key
list_id:       unsigned foreign key
name:          string not null
description:   text nullable
complete_flag: boolean default(0)
timestamps
```

For now I think these are the only tables I will need.  I normally use this set up for database columns.

1. IDs
    1. These will be the ID of the table and any foreign key IDs.
1. Data fields
    1. Things that are data for this particular object.
1. Flags
    1. Anything that is a 0 or 1 value.
1. Date fields
    1. Laravel's default `created_at` and `updated_at` along with any custom date fields.
    
I also follow a certain convention for table names: `<service>_<purpose>`.  In this case, these are in the `todo` 
service so that is the prefix they are given.  I find this useful since it groups the tables in SQL making them easier to 
identify at a glance.

<a name="migrations"></a>
## Migrations

So now we need to add these to our database.  Laravel has a built in [migration system](https://laravel.com/docs/5.7/migrations) 
that we will leverage.  To do this, we can run an artisan command to generate our migration files for us.

```bash
php artisan make:migration create_todo_lists_table --create=todo_lists
php artisan make:migration create_todo_tasks_table --create=todo_tasks
```

These commands will create our migration files in `database/migrations` and populate them with boilerplate for our table 
names.  They should be easy to spot in that folder.  Open up `<date>_create_todo_lists_table.php` first.

In this file you will see two methods: `up` and `down`.  Up is used when we are creating the table (when we run 
`php artisan migrate`).  The down method is used when we rollback our migrations (`php artisan migrate:rollback`).  For 
now we only need to worry about the up method.

You should see the following boilerplate when you open the file.

```php
Schema::create('todo_lists', function (Blueprint $table) {
    $table->increments('id');
    $table->timestamps();
});
```

As you can see this already has two of the fields we wanted: `id` and `timestamps`.  So we just need to add the other ones.

```php
Schema::create('todo_lists', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('user_id')->unsigned();
    $table->string('name');
    $table->string('slug')->index();
    $table->text('description')->nullable();
    $table->boolean('complete_flag')->default(0)->index();
    $table->timestamps();
});
```

All of our fields are accounted for now.  There are a few things to notice here.  The `user_id` column is marked unsigned 
since all of Laravel's auto incrementing keys are this way as well.  We also added an index to `slug` and 
`complete_flag`.  We did this to make searching a bit faster since these are two columns that will likely be used in our 
where clauses frequently.  Now, we should make a foreign key to the `users` table.

```php
$table->increments('id');
$table->integer('user_id')->unsigned();
$table->string('name');
$table->string('slug')->index();
$table->text('description')->nullable();
$table->boolean('complete_flag')->default(0)->index();
$table->timestamps();

$table->foreign('user_id')
    ->references('id')
    ->on('users')
    ->onDelete('cascade');
```

We added the foreign key mark up now.  This is how Laravel sets these up.  It will give the foreign key a name following 
it's standard conventions.  I also enabled `onDelete('cascade')`.  Should a user be deleted, it will clean up our task lists 
for us.  Now, do the same thing for `todo_tasks`.

```php
$table->increments('id');
$table->integer('list_id')->unsigned();
$table->string('name');
$table->text('description')->nullable();
$table->boolean('complete_flag')->default(0)->index();
$table->timestamps();

$table->foreign('list_id')
    ->references('id')
    ->on('todo_lists')
    ->onDelete('cascade');
```

That's it!  Now we just migrate them into our database.

```bash
php artisan migrate
```

When this is done, you can refresh your SQL viewer and see the tables in your database.  You will also see entries in the 
`migrations` table for these migrations.

<a name="models"></a>
## Models

Let's interact with our tables.  To do this we need to create models in Laravel.  These all follow a fairly simple 
format.

> {warning} We can't use Laravel's `php artisan make:model` command since we are not storing them in the default location 
Laravel expects.

Go to your `app/Services/ToDo/Models` folder.  Here we will make two files: `Task.php` and `TaskList.php`.

**Task.php**
```php
<?php

namespace App\Services\ToDo\Models;

use App\Models\BaseModel;

class Task extends BaseModel
{
    public $table = 'todo_tasks';

    protected $fillable = [
        'list_id',
        'name',
        'description',
        'complete_flag',
    ];

    public function taskList()
    {
        return $this->belongsTo(TaskList::class, 'list_id');
    }
}
```

**TaskList.php**
```php
<?php

namespace App\Services\ToDo\Models;

use App\Models\BaseModel;
use App\Models\User;

class TaskList extends BaseModel
{
    public $table = 'todo_lists';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'complete_flag',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'list_id');
    }
}
```

As you can see, we have very similar data in each model.  The `table` property is required to know what database table this 
model maps to.  Next, the `fillable` property is used to let Laravel know what data can be set in mass assignment.  This 
would be instances where you use `create()` or `update()` to set multiple columns at once.  This is done to protect against 
a mass assignment vulnerability.  Next, is the relationship methods.  Laravel has a lot of built in methods to handle the 
many different types of relationships.  We only need a standard one-to-many here.  So a `TaskList` has many `Task` models, 
while a `Task` belongs to a `TaskList`.  A `TaskList` also belongs to a user so we added that relationship too.

> {info} You can learn more about mass assignment vulnerability in the [Laravel docs](https://laravel.com/docs/5.7/eloquent#mass-assignment).

<a name="slugging"></a>
## Slugging

You may have noticed that we did not make the `slug` column on `TaskList` a fillable column.  That is because we will be 
using a package to handle slugging our names.

```bash
composer require cviebrock/eloquent-sluggable:^4.6
php artisan package:discover
```

> {info} You can learn more about this package on [GitHub](https://github.com/cviebrock/eloquent-sluggable).

This package handles slugging table columns very well and is extremely configurable.  It's why it's our go-to for slugging 
tables.  Let's go ahead and add the needed configuration to our `TaskList` model.

```php
<?php

namespace App\Services\ToDo\Models;

use App\Models\BaseModel;
use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;

class TaskList extends BaseModel
{
    use Sluggable;

    ...Table Properties...

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    ...Relationship Methods...
}
```

To make this package work we need two things: the `Sluggable` trait and a `sluggable()` method.  The `sluggable` method 
expects to return an array.  The keys of this array tell it what column to store the slug to.  In our case that was 
`slug`.  The value of that array is another array containing the details of how to create the slug.  In our case we want 
it to use the `name` column as the `source`, so that's what we set.  You can test this easily.  Using `php artisan tinker` 
or just opening `app/Http/Controller/HomeController` and putting the following code in the `index()` method and refreshing 
your homepage will generate a new task list.

```php
\App\Services\ToDo\Models\TaskList::create([
    'user_id' => auth()->id(),
    'name' => 'Testing task lists',
]);
```

Look in your `todo_lists` table and make sure you have a row with the following details.

| id | user_id | name | slug | description | complete_flag |
| :- | :- | :- | :- | :- | :- |  
| 1 | 1 | Testing task lists | testing-task-lists | NULL | 0 |

If you ran it again, you would see the following rows.

| id | user_id | name | slug | description | complete_flag |
| :- | :- | :- | :- | :- | :- |  
| 1 | 1 | Testing task lists | testing-task-lists | NULL | 0 |
| 1 | 1 | Testing task lists | testing-task-lists-1 | NULL | 0 |

You can see the sluggable package working because it added the `-1` to the second task list.  Perfect!  Feel free to delete 
these rows from your table and continue on to set up your HTTP details.

> {info} The walkthrough continues in [Setting up Routes and Links](/docs/{{version}}/jumpgate-walkthrough-3-routes-links).
