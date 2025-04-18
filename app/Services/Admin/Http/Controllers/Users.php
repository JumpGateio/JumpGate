<?php

namespace App\Services\Admin\Http\Controllers;

use App\Services\Users\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Services\Users\Managers\UserActions;
use App\Services\Users\Models\Role;
use App\Services\Users\Models\User;
use App\Services\Users\Models\User\Status;

class Users extends Base
{
    public User $users;

    public function __construct(User $users)
    {
        parent::__construct();

        $this->users = $users;
    }

    public function index(): \Inertia\Response
    {
        $title       = 'User List';
        $permissions = [
            'create' => auth()->user()->hasPermission('create-user'),
            'update' => auth()->user()->hasPermission('update-user'),
            'delete' => auth()->user()->hasPermission('delete-user'),
        ];
        $filters     = request()->all('search', 'trashed');
        $users       = $this->users
            ->with(['status', 'details'])
            ->orderByNameAsc()
            ->filter(request()->only('search', 'trashed'))
            ->paginate(10)
            ->withQueryString()
            ->through(function (User $user) {
                return [
                    'id'            => $user->id,
                    'email'         => $user->email,
                    'status'        => $user->status->label,
                    'roles'         => $user->roles->display_name->implode(', '),
                    'admin_actions' => $user->admin_actions,
                    'deleted_at'    => $user->deleted_at,
                ];
            });

        return $this->response(
            compact('title', 'permissions', 'filters', 'users')
        );
    }

    public function show(User $user): \Inertia\Response
    {
        $title       = $user->details->display_name ?? 'User Details';
        $permissions = [
            'create' => auth()->user()->hasPermission('create-user'),
            'update' => auth()->user()->hasPermission('update-user'),
            'delete' => auth()->user()->hasPermission('delete-user'),
        ];
        $user->load('tokens');
        $user->load('actionTimestamps');
        $user->load('roles.permissions');
        $user->load('permissions');
        $user->permission_list = implode(', ', $user->permissions->name->toArray());
        $user->admin_actions   = $user->getAttribute('admin_actions');
        $user->load('socials');

        $user->roles->transform(function ($role) {
            $role->permission_list = implode(', ', $role->permissions->name->toArray());

            return $role;
        });

        return $this->response(compact('title', 'permissions', 'user'), 'Admin/Users/Show');
    }

    public function create(): \Inertia\Response
    {
        $title             = 'Create a new user';
        $roleOptions       = Role::orderBy('display_name', 'asc')->get()->pluck('display_name', 'id');
        $permissionOptions = Permission::orderBy('display_name', 'asc')->get()->pluck('display_name', 'id');
        $settings          = config('jumpgate.users.settings');

        $invitationOptions = supportCollector([
            'none'               => 'Select one',
            'generateActiveUser' => 'Just add user to database',
        ]);

        if (array_get($settings, 'allow_invitations')) {
            $invitationOptions->put('inviteNewUser', 'Send invite');
        }
        if (array_get($settings, 'require_email_activation')) {
            $invitationOptions->put('sendNewUserActivation', 'Send email activation');
        }

        $selected = 'none';
        if ($invitationOptions->count() === 2) {
            $selected = $invitationOptions->keys()->last();
        }

        return $this->response(
            compact(
                'title',
                'roleOptions',
                'permissionOptions',
                'invitationOptions',
                'selected'
            )
        );
    }

    public function store(): \Illuminate\Http\RedirectResponse
    {
        $email        = request('email');
        $roles        = request('roles');
        $permissions  = request('permissions');
        $inviteMethod = request('invite');

        Validator::make(request()->all(), [
            'email'  => 'required|email|unique:users,email',
            'roles'  => 'required',
            'invite' => [
                'required',
                Rule::notIn(['none']),
            ],
        ])->validate();

        try {
            $this->users->{$inviteMethod}($email, $roles, $permissions);
        } catch (\Exception $exception) {
            return redirect()
                ->route('admin.users.create')
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User added!');
    }

    public function edit(User $user): \Inertia\Response
    {
        $statusOptions     = Status::orderByNameAsc()->get()->pluck('label', 'id');
        $roleOptions       = Role::orderBy('display_name', 'asc')->get()->pluck('display_name', 'id');
        $permissionOptions = Permission::orderBy('display_name', 'asc')->get()->pluck('display_name', 'id');
        $title             = $user->email;

        $user = $user->frontEndDetails();

        return $this->response(
            compact(
                'user',
                'statusOptions',
                'roleOptions',
                'permissionOptions',
                'title'
            )
        );
    }

    public function update(User $user): \Illuminate\Http\RedirectResponse
    {
        $user->update(request('user'));
        $user->setStatus(request('status_id'));
        $user->setFailedLoginAttempts(request('failed_login_attempts'));
        $user->details->update(request('details'));
        $user->roles()->sync(request('roles'));
        $user->permissions()->sync(request('permissions'));

        return redirect()
            ->route('admin.users.index')
            ->with('message', 'User updated!');
    }

    public function confirm($id, $status, $action = null): \Inertia\Response
    {
        $user = $this->users->withTrashed()->find($id);

        $event = match ($status) {
            'resendInvite'  => 'resend an invite to',
            'revokeInvite'  => 'revoke the invite to',
            'resetPassword' => 'reset the password of ',
            default         => $status,
        };

        if (!is_null($action) && (int)$action === 0) {
            $event = 'un-' . $event;
        }

        $message = 'You are about to ' . $event . ' ' . $user->email . '.';
        $proceed = route('admin.users.confirmed', [$id, $status, $action]);
        $cancel  = str_replace(url('/'), '', url()->previous());

        return $this->response(compact('message', 'proceed', 'cancel'), 'Admin/Confirm');
    }

    public function confirmed($id, $status, $action = null): \Illuminate\Http\RedirectResponse
    {
        $user = $this->users->withTrashed()->find($id);

        return (new UserActions($user, $status, $action))
            ->execute()
            ->redirect();
    }
}
