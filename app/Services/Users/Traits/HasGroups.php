<?php

namespace App\Services\Users\Traits;

use App\Services\Users\Models\Permission;
use App\Services\Users\Models\Group;

trait HasGroups
{
    /**
     * A user may have multiple groups.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'rbac_group_user');
    }

    /**
     * Assign the given group to the user.
     *
     * @param string $group
     *
     * @return mixed
     * @throws \Exception
     */
    public function assignGroup(string $group): mixed
    {
        if (Group::count() === 0) {
            throw new \Exception('No groups have been created.');
        }

        return $this->groups()->save(
            Group::whereName($group)->firstOrFail()
        );
    }

    /**
     * Determine if the user is inthe given group.
     *
     * @param mixed $group
     *
     * @return bool
     */
    public function hasGroup(mixed $group): bool
    {
        if (is_string($group)) {
            return $this->groups->contains('name', $group);
        }

        return ! ! $group->intersect($this->groups)->count();
    }

    /**
     * Determine if the user may perform the given permission.
     *
     * @param Permission $permission
     *
     * @return bool
     */
    public function hasPermission(Permission $permission): bool
    {
        return $this->hasGroup($permission->roles);
    }
}
