<?php

namespace App\Services\Users\Services;

use App\Services\Users\Models\User;
use JumpGate\Core\Services\Response;

class UserActions
{
    public User $user;

    public string $status;

    public int $action;

    public string $method;

    public function __construct(User $user, $status, $action)
    {
        $this->user   = $user;
        $this->status = $status;
        $this->action = (int)$action;
    }

    /**
     * Determine what to do on the user.
     *
     * @return Response
     */
    public function execute(): Response
    {
        $this->determineMethod();

        $this->user->{$this->method}();

        return Response::passed($this->getMessage())
            ->route('admin.users.index');
    }

    /**
     * Based on the status and action, determine the method
     * to call on the user object.
     */
    protected function determineMethod()
    {
        $methods = [
            'block'         => ['unblock', 'block'],
            'delete'        => ['restore', 'delete'],
            'activate'      => ['activate'],
            'resetPassword' => ['generateNewUserPasswordResetToken'],
            'resendInvite'  => ['resendInvite'],
            'revokeInvite'  => ['revokeInvite'],
        ];

        $this->method = array_get($methods, $this->status . '.' . $this->action);
    }

    /**≤
     * Based on the method, determine a logic message
     * to display when redirecting.
     *
     * @return string
     */
    protected function getMessage(): string
    {
        return match ($this->method) {
            'resendInvite'     => 'Invite resent.',
            'revokeInvite'     => 'Invite revoked.',
            'resetPassword'    => 'Password reset.',
            'block', 'unblock' => 'User ' . $this->method . 'ed.',
            default            => 'User ' . $this->method . 'd.',
        };
    }
}
