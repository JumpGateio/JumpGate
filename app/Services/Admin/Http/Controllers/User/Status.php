<?php

namespace App\Services\Admin\Http\Controllers\User;

use App\Services\Admin\Http\Controllers\Base;
use Illuminate\Support\Facades\Validator;
use App\Services\Users\Models\User\Status as StatusModel;

class Status extends Base
{
    /**
     * @var \App\Services\Users\Models\User\Status
     */
    public $statuses;

    public function __construct(StatusModel $statuses)
    {
        parent::__construct();

        $this->statuses = $statuses;
    }

    public function index()
    {
        $title    = 'Status List';
        $filters  = request()->all('search');
        $statuses = $this->statuses
            ->orderByNameAsc()
            ->filter(request()->only('search'))
            ->paginate(10)
            ->withQueryString()
            ->through(function (StatusModel $status) {
                return [
                    'id'    => $status->id,
                    'name'  => $status->name,
                    'label' => $status->label,
                ];
            });

        return $this->response(compact('title', 'filters', 'statuses'), 'Admin/Users/Status/Index');
    }

    public function create()
    {
        $title = 'Create a new status';

        return $this->response(
            compact('title'),
            'Admin/Users/Status/Create'
        );
    }

    public function store()
    {
        $name        = request('name');
        $label        = request('label');

        Validator::make(request()->all(), [
            'name'  => 'required|unique:user_statuses,name',
            'label'  => 'required',
        ])->validate();

        try {
            $this->statuses->firstOrCreate(compact('name', 'label'));
        } catch (\Exception $exception) {
            return redirect()
                ->route('admin.users.status.create')
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.users.status.index')
            ->with('success', 'Status added!');
    }

    public function edit(StatusModel $status)
    {
        $title = 'Edit: '. $status->label;

        return $this->response(
            compact('title', 'status'),
            'Admin/Users/Status/Edit'
        );
    }

    public function update(StatusModel $status)
    {
        $status->update(request()->all());

        return redirect()
            ->route('admin.users.status.index')
            ->with('message', 'Status updated!');
    }

    public function confirm($id, $status, $action = null)
    {
        $event = $status;
        $status = $this->statuses->find($id);

        if (! is_null($action) && (int)$action === 0) {
            $event = 'un-' . $event;
        }

        $message = 'You are about to ' . $event . ' ' . $status->label . '.';
        $proceed = route('admin.users.status.confirmed', [$id, $status, $action]);
        $cancel  = str_replace(url('/'), '', url()->previous());

        return $this->response(compact('message', 'proceed', 'cancel'), 'Admin/Confirm');
    }

    public function confirmed($id, $status, $action = null)
    {
        $this->statuses->find($id)->delete();

        return redirect()
            ->route('admin.users.status.index')
            ->with('message', 'Status deleted!');
    }
}
