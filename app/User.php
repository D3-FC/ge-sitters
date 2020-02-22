<?php

namespace App;

use App\Http\Requests\User\RegisterRequest;
use Eloquent;
use Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Token;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string|null $phone
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static Builder|User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static Builder|User withTrashed()
 * @method static Builder|User withoutTrashed()
 * @property-read Admin $admin
 * @property-read mixed $is_admin
 * @property-read Admin $client
 * @property-read \App\Worker $worker
 * @property-read mixed $is_client
 * @property-read mixed $is_worker
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Message[] $messages
 * @property-read int|null $messages_count
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
        $u = new User();
        $u->name = data_get($params, 'name');
        $u->email = data_get($params, 'email');
        $u->password = data_get($params, 'password');
        $u->save();

        return $u;
    }

    public function becomeWorker(array $params): Worker
    {
        /** @var Worker $w */
        $w =$this->worker()->save(Worker::init($params, $this));
        return $w;

    }

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

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function setPasswordAttribute(string $v)
    {
        $this->attributes['password'] = Hash::make($v);
    }

    public function updateFromArray(array $params)
    {
        $this->email = data_get($params, 'email');
        $this->name = data_get($params, 'name');
        $this->phone = data_get($params, 'phone');

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

    private function becomeClient(): void
    {
        $this->client()->create();
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }
}
