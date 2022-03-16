<?php

namespace App\Services\Users\Traits;

use App\Services\Users\Models\User;
use Illuminate\Database\Query\Builder;

trait HasUser
{
    /**
     * Limit our results to those belonging to a user.
     *
     * @param Builder $query
     * @param int     $userId
     */
    public function scopeForUser(Builder $query, int $userId)
    {
        $query->where('user_id', $userId);
    }

    /**
     * Get the user this record is associated with.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
