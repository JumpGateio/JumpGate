<?php

namespace App\Services\Admin\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use JumpGate\Users\Services\UserActions;
use App\Models\User;
use JumpGate\Users\Models\Role;
use JumpGate\Users\Models\User\Status;

class Users extends Base
{
    /**
     * @var \App\Models\User
     */
    public $users;

    public function __construct(User $users)
    {
        parent::__construct();

        $this->users = $users;
    }

    public function index()
    {
        $title   = 'User List';
        $filters = request()->all('search', 'trashed');
        $users   = $this->users
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

        return $this->response(compact('title', 'filters', 'users'));
    }

    public function show(User $user)
    {
        $title = $user->details->display_name ?? 'User Details';
        $user->load('tokens');
        $user->load('actionTimestamps');
        $user->admin_actions = $user->getAttribute('admin_actions');

        if (config('jumpgate.users.settings.enable_social_auth')) {
            $user->load('socials');
        }

        return $this->response(compact('title', 'user'), 'Admin/Users/Show');
    }

    public function create()
    {
        $title       = 'Create a new user';
        $roleOptions = Role::orderBy('name', 'asc')->get()->pluck('name', 'id');
        $settings    = config('jumpgate.users.settings');

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
            compact('title', 'roleOptions', 'invitationOptions', 'selected')
        );
    }

    public function store()
    {
        $email        = request('email');
        $roles        = request('roles');
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
            $this->users->{$inviteMethod}($email, $roles);
        } catch (\Exception $exception) {
            return redirect()
                ->route('admin.users.create')
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User added!');
    }

    public function edit(User $user)
    {
        $statusOptions = Status::orderByNameAsc()->get()->pluck('label', 'id');
        $roleOptions   = Role::orderBy('name', 'asc')->get()->pluck('name', 'id');
        $title         = $user->email;

        $user = $user->frontEndDetails();

        return $this->response(
            compact('user', 'statusOptions', 'roleOptions', 'title')
        );
    }

    public function update(User $user)
    {
        $user->update(request('user'));
        $user->setStatus(request('status_id'));
        $user->setFailedLoginAttempts(request('failed_login_attempts'));
        $user->details->update(request('details'));
        $user->roles()->sync(request('roles'));

        return redirect()
            ->route('admin.users.index')
            ->with('message', 'User updated!');
    }

    public function confirm($id, $status, $action = null)
    {
        $user = $this->users->withTrashed()->find($id);

        switch ($status) {
            case 'resendInvite':
                $event = 'resend an invite to';
                break;
            case 'revokeInvite':
                $event = 'revoke the invite to';
                break;
            case 'resetPassword':
                $event = 'reset the password of ';
                break;
            default:
                $event = $status;
                break;
        }

        if (! is_null($action) && (int)$action === 0) {
            $event = 'un-' . $event;
        }

        $message = 'You are about to ' . $event . ' ' . $user->email . '.';
        $proceed = route('admin.users.confirmed', [$id, $status, $action]);
        $cancel  = str_replace(url('/'), '', url()->previous());

        return $this->response(compact('message', 'proceed', 'cancel'), 'Admin/Confirm');
    }

    public function confirmed($id, $status, $action = null)
    {
        $user = $this->users->withTrashed()->find($id);

        return (new UserActions($user, $status, $action))
            ->execute()
            ->redirect();
    }
}
