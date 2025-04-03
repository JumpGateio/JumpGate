<?php

namespace Database\Seeders\Users;

use App\Services\Users\Models\User;
use App\Services\Users\Models\Role;
use Database\Seeders\Base;

class DefaultUsers extends Base
{
    /**
     * @var array<field, value>|array[]
     */
    protected array $defaultUsers = [
        [
            'email' => 'stygian.warlock.v2@gmail.com',
            'roles' => ['developer'],
        ],
        [
            'email' => 'riddles8888@gmail.com',
            'roles' => ['developer'],
        ],
    ];

    public function run()
    {
        $createFlag = config('jumpgate.users.settings.create_default_users');

        if (! $createFlag) {
            $this->command->info('Default users not enabled.  Skipping.');

            return;
        }

        $addedUsers = supportCollector($this->defaultUsers)
            ->transform(function ($user) {
                if (User::where('email', $user['email'])->count() > 0) {
                    $this->command->info('User ' . $user['email'] . ' already exists.  Skipping.');

                    return null;
                }

                $roleIds = Role::whereIn('name', $user['roles'])->get()->id->toArray();
                $user = (new User)->generateActiveUser($user['email'], $roleIds);
                $user->update(['password' => 'test']);

                return $user->email;
            })
            ->filter()
            ->implode(',');

        if (! is_null($addedUsers)) {
            $this->command->comment('Added ' . $addedUsers . ' to users table');
        }
    }
}
