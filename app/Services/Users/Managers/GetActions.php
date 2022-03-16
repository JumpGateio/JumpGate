<?php

namespace App\Services\Users\Managers;

use App\Services\Users\Models\User;
use App\Services\Users\Models\User\Status;
use JumpGate\Database\Collections\SupportCollection;

class GetActions
{
    public User $user;

    public SupportCollection $actions;

    public function __construct(User $user)
    {
        $this->user    = $user;
        $this->actions = supportCollector();
    }

    /**
     * Get the list of available actions.
     */
    public function build(): SupportCollection
    {
        if ($this->user->trashed()) {
            return $this->actions;
        }

        $this->checkBlocked();
        $this->checkInactive();
        $this->checkInvites();
        $this->checkPasswordReset();

        return $this->actions;
    }

    /**
     * Actions for a blocked user.
     */
    protected function checkBlocked(): bool
    {
        if ($this->user->status_id === Status::BLOCKED) {
            return $this->addAction('Un-Block', 'unlock', $this->makeRoute('block', 0));
        }

        return $this->addAction('Block', 'lock', $this->makeRoute('block', 1));
    }

    /**
     * Actions for an inactive user.
     */
    protected function checkInactive(): bool
    {
        if ($this->user->status_id !== Status::INACTIVE) {
            return true;
        }

        return $this->addAction('Activate', 'check-square-o', $this->makeRoute('activate', 0));
    }

    /**
     * Actions for an invited user.
     */
    protected function checkInvites(): bool
    {
        if (! config('jumpgate.users.settings.allow_invitations')
            || is_null($this->user->actionTimestamps->invited_at ?? null)
        ) {
            return true;
        }

        $this->addAction('Re-Send Invite', 'envelope-o', $this->makeRoute('resendInvite'));

        return $this->addAction('Revoke Invite', 'times-circle-o', $this->makeRoute('revokeInvite'));
    }

    /**
     * Possible reset password action.
     */
    protected function checkPasswordReset(): bool
    {
        if (config('jumpgate.users.social_auth_only')) {
            return true;
        }

        return $this->addAction('Reset Password', 'refresh', $this->makeRoute('resetPassword'));
    }

    /**
     * A helper to make routes easily.
     *
     * @param string   $status
     * @param int|null $action
     *
     * @return string
     */
    protected function makeRoute(string $status, int $action = null): string
    {
        $route = 'admin.users.confirm';

        return route($route, [$this->user->id, $status, $action]);
    }

    /**
     * Adds the action to the collection.
     *
     * @param string $label
     * @param string $icon
     * @param string $route
     *
     * @return bool
     */
    protected function addAction(string $label, string $icon, string $route): bool
    {
        $action = (object)[
            'route' => $route,
            'icon'  => 'fa-' . $icon,
            'text'  => $label,
        ];

        $this->actions->add($action);

        return true;
    }
}
