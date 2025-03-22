<?php

namespace App\Traits\Model;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class ActiveScopes
 *
 * @method active()
 * @method inactive()
 */
trait ActiveScopes
{
    /**
     * Get only active rows.
     *
     * @param Builder $query The current query to append to
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('activeFlag', 1);
    }

    /**
     * Get only inactive rows.
     *
     * @param Builder $query The current query to append to
     */
    public function scopeInactive(Builder $query)
    {
        return $query->where('activeFlag', 0);
    }
}
