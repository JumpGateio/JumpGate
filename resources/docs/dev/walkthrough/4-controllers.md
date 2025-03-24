# JumpGate App Walkthrough: Controllers

---

- [Introduction](#introduction)

<a name="introduction"></a>
## Introduction

In this step of creating our todo app, we are going to continue building out the todo service.  We will be setting up our 
controllers.  These all live in the `app/Services/ToDo/Http/Controllers` directory.

> {info} You can see the source code at [GitHub](https://github.com/JumpGateio/ToDo-Walkthrough).

> This step is stored as a branch called [controllers](https://github.com/JumpGateio/ToDo-Walkthrough/tree/4-controllers).

<a name="controllers"></a>
## Controllers

The controllers in JumpGate are not too dissimilar from base Laravel.  We just a few extra tools that you can leverage.  To 
begin, create `TaskList.php` in `app/Services/ToDo/Http/Controllers`.  You will notice this name matches up with the name 
we gave the routes in the previous section.

```php
<?php

namespace App\Services\ToDo\Http\Controllers;

use App\Http\Controllers\Base;
use App\Services\ToDo\Models\TaskList as TaskListModel;

class TaskList extends Base
{
    public function index()
    {
        $lists = TaskListModel::where('user_id', auth()->id())->get();

        $this->setViewData(compact('lists'));

        return $this->view();
    }

    public function show($id)
    {
        $list = TaskListModel::find($id);

        if ($list->user_id !== auth()->id()) {
            return $this->redirectWhenUserDoesNotOwnList();
        }

        $this->setViewData(compact('list'));

        return $this->view();
    }

    public function create()
    {
        return $this->view();
    }

    public function store()
    {
        try {
            TaskListModel::create(request()->all());
        } catch (\Exception $exception) {
            return redirect()
                ->route('task-list.index')
                ->with('error', 'Could not create task list: ' . $exception->getMessage());
        }

        return redirect()
            ->route('task-list.index')
            ->with('message', 'Your task list has been added.');
    }

    public function edit($id)
    {
        $list = TaskListModel::find($id);

        if ($list->user_id !== auth()->id()) {
            return $this->redirectWhenUserDoesNotOwnList();
        }

        $this->setViewData(compact('list'));

        return $this->view();
    }

    public function update($id)
    {
        try {
            TaskListModel::find($id)
                ->update(request()->all());
        } catch (\Exception $exception) {
            return redirect()
                ->route('task-list.index')
                ->with('error', 'Could not update task list: ' . $exception->getMessage());
        }

        return redirect()
            ->route('task-list.index')
            ->with('message', 'Your task list has been updated.');
    }

    public function delete($id)
    {
        $list = TaskListModel::find($id);

        if ($list->user_id !== auth()->id()) {
            return $this->redirectWhenUserDoesNotOwnList();
        }

        try {
            $list->delete();
        } catch (\Exception $exception) {
            return redirect()
                ->route('task-list.index')
                ->with('error', 'Could not delete task list: ' . $exception->getMessage());
        }

        return redirect()
            ->route('task-list.index')
            ->with('message', 'Your task list has been removed.');
    }

    /**
     * If the list does not belong to the user that requested
     * the page, redirect them to their list with an error.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectWhenUserDoesNotOwnList()
    {
        return redirect()
            ->route('task-list.index')
            ->with('error', 'You do not own this list.');
    }
}
```

Here is our finished controller.  We have a method for each route.  For the index method, we grab only the tasks that belong 
to the authenticated user (`auth()->id()` is a Laravel shortcut for `auth()->user()->id`).  Then we use a JumpGate feature: 
`setViewData()`.  This method is how we pass data to the views.  Under the hood it does a view share, but the main benefit 
is that it understands PHP's `compact()` method.

> {success} Learn more about [controller helper methods](/docs/{{version}}/core-helper-classes#controller).

In a few of the methods we want to make sure that the user accessing the page is the actual owner of the TaskList.  Since 
that code was the same in each we made the `redirectWhenUserDoesNotOwnList()` method to handle that.  Everything else here 
should look familiar aside from the `return $this->view()` call at the end of our GET routes.  This method tells JumpGate 
to begin automatically finding your view based on the route prefix, controller, and method name.  You can override this 
magic by setting the exact view you want it to use as the first parameter.

> {success} Learn more about [auto view resolution](/docs/{{version}}/views-usage).

That's it for the task list controller.  Now just do the same thing for the Task controller.

```php
<?php

namespace App\Services\ToDo\Http\Controllers;

use App\Http\Controllers\Base;
use App\Services\ToDo\Models\Task as TaskModel;
use App\Services\ToDo\Models\TaskList;

class Task extends Base
{
    public function show($id)
    {
        $task = TaskModel::with('list')
            ->find($id);

        if ($task->list->user_id !== auth()->id()) {
            return $this->redirectWhenUserDoesNotOwnTask();
        }

        $this->setViewData(compact('task'));

        return $this->view();
    }

    public function create($listId)
    {
        $lists = TaskList::orderByNameAsc()
            ->get()
            ->pluck('name', 'slug');

        $this->setViewData(compact('lists', 'listId'));

        return $this->view();
    }

    public function store($listId)
    {
        try {
            TaskModel::create(request()->all());
        } catch (\Exception $exception) {
            return redirect()
                ->route('task.index')
                ->with('error', 'Could not create task: ' . $exception->getMessage());
        }

        return redirect()
            ->route('task.index')
            ->with('message', 'Your task has been added.');
    }

    public function edit($id)
    {
        $task = TaskModel::with('list')
            ->find($id);

        if ($task->list->user_id !== auth()->id()) {
            return $this->redirectWhenUserDoesNotOwnTask();
        }

        $lists = TaskList::orderByNameAsc()
            ->get()
            ->pluck('name', 'slug');

        $this->setViewData(compact('task', 'lists'));

        return $this->view();
    }

    public function update($id)
    {
        try {
            TaskModel::find($id)
                ->update(request()->all());
        } catch (\Exception $exception) {
            return redirect()
                ->route('task.index')
                ->with('error', 'Could not update task: ' . $exception->getMessage());
        }

        return redirect()
            ->route('task.index')
            ->with('message', 'Your task has been updated.');
    }

    public function delete($id)
    {
        $task = TaskModel::with('list')
            ->find($id);

        if ($task->list->user_id !== auth()->id()) {
            return $this->redirectWhenUserDoesNotOwnTask();
        }

        try {
            $task->delete();
        } catch (\Exception $exception) {
            return redirect()
                ->route('task.index')
                ->with('error', 'Could not delete task: ' . $exception->getMessage());
        }

        return redirect()
            ->route('task.index')
            ->with('message', 'Your task has been removed.');
    }

    /**
     * If the list does not belong to the user that requested
     * the page, redirect them to their list with an error.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectWhenUserDoesNotOwnTask()
    {
        return redirect()
            ->route('task.index')
            ->with('error', 'You do not own this task.');
    }
}
```

This is almost the same as the previous controller.  A few notable changes:

1. We have no `index()` method.
1. We have to tap from `task` to `list` to get the `user_id` and verify ownership.
1. We used the `orderByNameAsc()` from JumpGate models.  As the name suggests it orders the collection of models by their 
name.
1. The `pluck()` method is a Laravel collection method useful for making select drop downs.

That's it for controllers.

> {info} The walkthrough continues in [creating views](/docs/{{version}}/jumpgate-walkthrough-5-views).
