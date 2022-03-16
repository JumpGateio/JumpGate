<?php

namespace App\Services\Users\Models\User;

use App\Models\BaseModel;
use App\Services\Users\Models\User;
use App\Services\Users\Notifications\PasswordReset;
use App\Services\Users\Notifications\UserActivation;
use App\Services\Users\Notifications\UserInvitation;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;

/**
 * Class Token
 *
 * @package App\Services\Users\Models\User
 *
 * @property int              $user_id
 * @property string           $type
 * @property string           $token
 * @property \Carbon\Carbon   $created_at
 * @property \Carbon\Carbon   $updated_at
 * @property \Carbon\Carbon   $expires_at
 * @property \App\Models\User $user
 */
class Token extends BaseModel
{
    /**
     * Activation type token.
     *
     * @var string
     */
    const TYPE_ACTIVATION = 'activation';

    /**
     * Invitation type token.
     *
     * @var string
     */
    const TYPE_INVITATION = 'invitation';

    /**
     * Password reset type token.
     *
     * @var string
     */
    const TYPE_PASSWORD_RESET = 'password_reset';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_tokens';

    /**
     * The attributes that can be safely filled.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'token',
        'expires_at',
    ];

    /**
     * Getters we need access to at all times.
     *
     * @var array
     */
    protected $appends = [
        'isExpired',
    ];

    /**
     * The attributes that should be mutated to Carbon dates.
     *
     * @var array
     */
    protected $dates = [
        'expires_at',
    ];

    /**
     * Generate a new token for the type.
     *
     * @param string   $type
     * @param User     $user
     * @param int|null $hours
     *
     * @return $this
     */
    public function generate(string $type, User $user, int $hours = null): static
    {
        $hours = is_null($hours) ? 24 : $hours;

        $user_id    = $user->id;
        $email      = $user->getAuthIdentifier();
        $value      = str_shuffle(sha1($email . $type . spl_object_hash($this) . microtime(true)));
        $token      = self::makeToken($value);
        $expires_at = Carbon::now()->addHours($hours);

        return $this->create(compact('user_id', 'type', 'token', 'expires_at'));
    }

    /**
     * Create a unique token.
     *
     * @param $value
     *
     * @return string
     */
    public static function makeToken($value): string
    {
        return hash_hmac('sha256', $value, config('app.key'));
    }

    /**
     * Returns true if token is expired.
     *
     * @return boolean
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->isExpired();
    }

    /**
     * Returns true if token is expired.
     *
     * @return boolean
     */
    public function isExpired(): bool
    {
        return $this->expires_at <= Carbon::now();
    }

    /**
     * Notify the user of this token.
     */
    public function notifyUser()
    {
        $event = match ($this->type) {
            self::TYPE_PASSWORD_RESET => new PasswordReset,
            self::TYPE_ACTIVATION     => new UserActivation,
            self::TYPE_INVITATION     => new UserInvitation,
        };

        $this->user->notify($event);
    }

    /**
     * Extend the expiration of the token.
     *
     * @param int|null $hours
     */
    public function extend(int $hours = null)
    {
        $hours = is_null($hours) ? 24 : $hours;

        $this->update([
            'expires_at' => Carbon::now()->addHours($hours),
        ]);
    }

    /**
     * Expire the token immediately.
     */
    public function expire()
    {
        $this->update([
            'expires_at' => Carbon::now(),
        ]);
    }

    /**
     * Return a token object that contains the given token.
     *
     * @param string $token
     *
     * @return null|Token
     */
    public function findByToken($token): ?Token
    {
        return $this->where('token', $token)->first();
    }

    /**
     * Delete a token object that contains the given token.
     *
     * @param string $token
     *
     * @return null|Token
     * @throws \Exception
     */
    public function deleteByToken(string $token): ?Token
    {
        return $this->where('token', $token)->delete();
    }

    /**
     * Extend the expiration of a token.
     *
     * @param string   $token
     * @param null|int $hours
     */
    public function extendByToken(string $token, ?int $hours = null)
    {
        $token = $this->findByToken($token);

        if (! is_null($token)) {
            return $token->extend($hours);
        }
    }

    /**
     * Find an object by its token and immediately expire it.
     *
     * @param string $token
     */
    public function expireByToken(string $token)
    {
        $token = $this->findByToken($token);

        if (! is_null($token)) {
            return $token->expire();
        }
    }

    /**
     * Builds a query scope to return tokens of a certain type.
     *
     * @param Builder      $query
     * @param array|string $types of tokens
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeOfType(Builder $query, array|string $types): Builder
    {
        // Convert types string to array
        $types = (array)$types;

        // Query the tokens table for matching types
        return $query->whereIn('type', $types);
    }

    /**
     * Every token belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
