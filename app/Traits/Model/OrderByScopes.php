<?php

namespace App\Traits\Model;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class OrderScopes
 *
 * @method orderByCreatedAsc()
 * @method orderByCreatedDesc()
 * @method orderByAsc()
 * @method orderByDesc()
 */
trait OrderByScopes
{
    /**
     * Order by created_at ascending scope.
     *
     * @param Builder $query The current query to append to
     */
    public function scopeOrderByCreatedAsc(Builder $query)
    {
        return $query->orderBy('created_at', 'asc');
    }
    /**
     * Order by created_at descending scope.
     *
     * @param Builder $query The current query to append to
     */
    public function scopeOrderByCreatedDesc(Builder $query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Order by name ascending scope.
     *
     * @param Builder $query The current query to append to
     */
    public function scopeOrderByNameAsc(Builder $query)
    {
        return $query->orderBy('name', 'asc');
    }

    /**
     * Order by name descending scope.
     *
     * @param Builder $query The current query to append to
     */
    public function scopeOrderByNameDesc(Builder $query)
    {
        return $query->orderBy('name', 'desc');
    }
}
