<?php

namespace App\Services\Users\Models;

use App\Models\BaseModel;
use App\Services\JumpGate\Core\Collections\SupportCollection;
use App\Services\Users\Managers\GetActions;
use App\Services\Users\Models\User\Detail;
use App\Services\Users\Models\User\Status;
use App\Services\Users\Models\User\Timestamp;
use App\Services\Users\Traits\CanActivate;
use App\Services\Users\Traits\CanAuthenticate;
use App\Services\Users\Traits\CanBlock;
use App\Services\Users\Traits\CanInvite;
use App\Services\Users\Traits\CanResetPassword;
use App\Services\Users\Traits\HasGravatar;
use App\Services\Users\Traits\HasSocials;
use App\Services\Users\Traits\HasTokens;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\HasRolesAndPermissions;

/**
 * Class User
 *
 * @package App\Services\Users\Models
 *
 * @property int                                       $id
 * @property string                                    $email
 * @property string                                    $password
 * @property int                                       $status_id
 * @property int                                       $failed_login_attempts
 * @property string                                    $authenticated_as
 * @property \Carbon\Carbon                            $authenticated_at
 * @property \Carbon\Carbon                            $activated_at
 * @property \Carbon\Carbon                            $blocked_at
 * @property \Carbon\Carbon                            $password_updated_at
 * @property string                                    $remember_token
 * @property \Carbon\Carbon                            $created_at
 * @property \Carbon\Carbon                            $updated_at
 * @property \Carbon\Carbon                            $deleted_at
 *
 * @property \App\Services\Users\Models\Role[]         $roles
 * @property \App\Services\Users\Models\Permission[]   $permissions
 * @property \App\Services\Users\Models\User\Detail    $details
 * @property \App\Services\Users\Models\User\Timestamp $actionTimestamps
 */
class User extends BaseModel implements \Illuminate\Contracts\Auth\Authenticatable
{
    /**
     * Use this model for authentication.
     *
     * @see \Illuminate\Auth\Authenticatable
     */
    use Authenticatable;

    /**
     * Allow this model to handle being activated.
     */
    use CanActivate;

    /**
     * Allow this model to handle invites.
     */
    use CanInvite;

    /**
     * Allow this model to handle logging in.
     */
    use CanAuthenticate;

    /**
     * Allow this model to be blocked or un-blocked from authenticating.
     */
    use CanBlock;

    /**
     * Allow this model to reset its password.
     */
    use CanResetPassword;

    /**
     * Used for when social login is enabled.  If it is disabled, comment this or remove it.
     */
    use HasSocials;

    /**
     * Allow this model to generate and use tokens.
     */
    use HasTokens;

    /**
     * Allow this model to display a gravatar avatar.
     */
    use HasGravatar;

    /**
     * Allow this model to have roles and permissions.
     */
    use HasRolesAndPermissions;

    /**
     * Allow this model to receive notifications.
     */
    use Notifiable;

    /**
     * Make model use soft deletes.
     */
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that can be safely filled.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * Tell eloquent to set deleted_at as a carbon date.
     *
     * @var array
     */
    protected $dates = [
        'authenticated_at',
        'deleted_at',
        'password_updated_at',
    ];

    /**
     * A common shrinking of the necessary data for the front end.
     *
     * @return array
     */
    public function frontEndDetails(): array
    {
        return [
            'id'            => $this->id,
            'email'         => $this->email,
            'status'        => $this->status->label,
            'status_id'     => $this->status_id,
            'roles'         => $this->roles->display_name->implode(', '),
            'role_ids'      => $this->roles->id,
            'admin_actions' => $this->admin_actions,
            'deleted_at'    => $this->deleted_at,
            'details'       => $this->details ? [
                'first_name'   => $this->details->first_name,
                'middle_name'  => $this->details->middle_name,
                'last_name'    => $this->details->last_name,
                'display_name' => $this->details->display_name,
                'timezone'     => $this->details->timezone,
                'location'     => $this->details->location,
            ] : [],
        ];
    }

    /**
     * Order by name ascending scope
     *
     * @param Builder $query The current query to append to
     *
     * @return Builder
     */
    public function scopeOrderByNameAsc(Builder $query): Builder
    {
        return $query->orderBy('email', 'asc');
    }

    /**
     * A scope to help easily search users by a term.
     *
     * @param Builder $query The current query to append to
     * @param array   $filters
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('email', 'like', '%' . $search . '%')
                    ->orWhereHas('details', function ($query) use ($search) {
                        $query->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('middle_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhere('display_name', 'like', '%' . $search . '%');
                    });
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    /**
     * Create a user to allow access.
     *
     * @param string                      $email
     * @param int|array|string|collection $roles
     *
     * @return User
     */
    public function generateActiveUser(string $email, collection|int|array|string $roles): User
    {
        $user = static::firstOrCreate(compact('email'));

        $user->setStatus(Status::ACTIVE);
        $user->roles()->attach($roles);
        $user->trackTime('invited_at');

        Detail::firstOrCreate([
            'user_id'      => $user->id,
            'display_name' => $email,
        ]);

        Timestamp::firstOrCreate([
            'user_id' => $user->id,
        ]);

        return $user;
    }

    /**
     * Make sure to hash the user's password on save
     *
     * @param string $value The value of the attribute (Auto Set)
     */
    public function setPasswordAttribute(string $value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Get the most logical display name for the user.
     *
     * @return string
     */
    public function getDisplayNameAttribute(): string
    {
        if (! is_null($this->details->display_name)) {
            return $this->details->display_name;
        }

        if (! is_null($this->details->full_name)) {
            return $this->details->full_name;
        }

        return $this->email;
    }

    /**
     * Returns a list of objects that will go in a users
     * drop down menu for actions that can be taken.
     *
     * @return SupportCollection
     */
    public function getAdminActionsAttribute(): SupportCollection
    {
        return (new GetActions($this))->build();
    }

    /**
     * Set the user's status.
     *
     * @param int|null $status The ID of the status being set.
     */
    public function setStatus(?int $status)
    {
        $this->status_id = $status;
        $this->save();
    }

    /**
     * Set the user's failed login attempts.
     *
     * @param int|null $attempts The number of attempts to set it to.
     */
    public function setFailedLoginAttempts(?int $attempts)
    {
        $this->failed_login_attempts = $attempts ?? 0;
        $this->save();
    }

    /**
     * Track when something important happened.
     *
     * @param string              $column The column being updated.
     * @param null|\Carbon\Carbon $time   The time to set the token for.
     */
    public function trackTime(string $column, ?\Carbon\Carbon $time = null)
    {
        $search = [
            'user_id' => $this->id,
        ];

        $attributes = [
            $column => setTime('now'),
        ];

        Timestamp::updateOrCreate($search, $attributes);
    }

    /**
     * Extra details for a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function details(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Detail::class, 'user_id');
    }

    /**
     * Important timestamps for a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function actionTimestamps(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Timestamp::class, 'user_id');
    }

    /**
     * Status for a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
