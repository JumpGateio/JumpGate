<?php

namespace App\Services\Users\Models\User;

use App\Models\BaseModel;
use App\Services\Users\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timestamp extends BaseModel
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_action_timestamps';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that can be safely filled.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'activated_at',
        'invited_at',
        'blocked_at',
        'password_updated_at',
    ];

    /**
     * The attributes that should be mutated to Carbon dates.
     *
     * @var array
     */
    protected $dates = [
        'activated_at',
        'invited_at',
        'blocked_at',
        'password_updated_at',
    ];

    /**
     * All details belong to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
