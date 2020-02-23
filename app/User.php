<?php

namespace App;

use App\Http\Requests\RegisterRequest;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Admin $admin
 * @property-read \App\Client $client
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read mixed $is_admin
 * @property-read mixed $is_client
 * @property-read mixed $is_worker
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Worker $worker
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\User withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Message[] $receivedMessages
 * @property-read int|null $received_messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Message[] $sentMessages
 * @property-read int|null $sent_messages_count
 */
class User extends Authenticatable
{

    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function registerSaveFromRequest(RegisterRequest $request): User
    {
        return static::register($request->all());
    }

    private static function register(array $params): User
    {
        return User::create($params);
    }

    public function becomeWorker(array $params): Worker
    {
        /** @var Worker $w */
        $w = $this->worker()->save(Worker::init($params, $this));

        return $w;

    }

    /**
     * @return HasOne|Worker
     */
    public function worker(): HasOne
    {
        return $this->hasOne(Worker::class);
    }

    public function becomeAdmin(): void
    {
        $this->admin()->create();
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'from_user_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'to_user_id');
    }

    public function setPasswordAttribute(string $v)
    {
        $this->attributes['password'] = Hash::make($v);
    }

    public function updateFromArray(array $params)
    {
        $this->fill($params);

        return $this;
    }

    public function getIsAdminAttribute()
    {
        return !!$this->admin;
    }

    public function getIsClientAttribute()
    {
        return !!$this->client;
    }

    public function getIsWorkerAttribute()
    {
        return !!$this->worker;
    }

    public function messageTo(array $params, User $user)
    {
        $m = Message::init($params, $this, $user);
        $m->save();

        return $m;
    }

    public function becomeClient(): Client
    {
        /** @var Client $client */
        $client = $this->client()->create();

        return $client;
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function myMessages(): Builder
    {
        return Message::orWhere(function (Builder $q) {
            /** @var Message $q */
            return $q->whereToUserId($this->id);
        })->orWhere(function (Builder $q) {
            /** @var Message $q */
            return $q->whereFromUserId($this->id);
        });
    }
}
