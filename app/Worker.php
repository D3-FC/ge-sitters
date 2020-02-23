<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Worker
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $min_child_age
 * @property int|null $max_child_age
 * @property string|null $description
 * @property string|null $animal_relationship
 * @property float|null $meeting_price
 * @property float|null $coords_x
 * @property float|null $coords_y
 * @property bool|null $has_card_payment
 * @property bool|null $sits_special_children
 * @property bool|null $has_training
 * @property bool|null $can_overwork
 * @property string|null $birthday
 * @property string|null $mobile_number_confirmed_at
 * @property string|null $passport_confirmed
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Price[] $prices
 * @property-read int|null $prices_count
 * @property-read \App\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Worker onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereAnimalRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereCanOverwork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereCoordsX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereCoordsY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereHasCardPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereHasTraining($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereMaxChildAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereMeetingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereMinChildAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereMobileNumberConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker wherePassportConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereSitsSpecialChildren($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Worker withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Worker withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker withPrices()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker withSchedules()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker withUser()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Schedule[] $schedules
 * @property-read int|null $schedules_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Offer[] $offers
 * @property-read int|null $offers_count
 * @property-read \App\PublishedWorker $publishedWorker
 */
class Worker extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'max_child_age',
        'min_child_age',
        'description',
        'animal_relationship',
        'meeting_price',
        'coords_x',
        'coords_y',
        'has_card_payment',
        'sits_special_children',
        'has_training',
        'can_overwork',
        'birthday',
    ];

    protected $dates = [
        "birthday" => "date",
        "mobile_number_confirmed_at" => "datetime",
        "passport_confirmed" => "datetime",
    ];

    protected $casts = [
        "meeting_price" => "float",
        "has_card_payment" => "boolean",
        "sits_special_children" => "boolean",
        "has_training" => "boolean",
        "can_overwork" => "boolean",
    ];

    public static function init(array $params, User $user)
    {
        return static::make($params)->associateUser($user);
    }


    private function associateUser(User $user): self
    {
        /** @var self $w */
        $w = $this->user()->associate($user);

        return $w;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updateFromParams(array $params): bool
    {
        return $this->fill($params)->save();
    }

    public function createPrice(array $params)
    {
        $price = Price::init($params, $this);
        $this->prices()->save($price);

        return $price;
    }

    /**
     * @return HasMany|Price
     */
    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }

    /**
     * @param  int  $id
     *
     * @throws Exception
     */
    public function bulkDeletePrice(int $id): void
    {
        $this->prices()->whereId($id)->delete();
    }

    public function createSchedule(array $params): Schedule
    {
        $schedule = Schedule::init($params, $this);
        $this->schedules()->save($schedule);

        return $schedule;
    }

    /**
     * @return HasMany|Schedule
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * @param  int  $id
     *
     * @throws Exception
     */
    public function bulkDeleteSchedule(int $id): void
    {
        $this->schedules()->whereId($id)->delete();
    }

    public function publish(): PublishedWorker
    {
        if($this->publishedWorker){
            abort(403, 'Already published');
        }
        $pw = PublishedWorker::init([], $this);
        $this->publishedWorker()->save($pw);

        return $pw;
    }

    public function publishedWorker(): HasOne
    {
        return $this->hasOne(PublishedWorker::class);
    }

    public function getOfferById(int $id): Offer
    {
        /** @var Offer $o */
        $o = $this->offers()->findOrFail($id);

        return $o;
    }

    /**
     * @return HasManyThrough|Offer
     */
    public function offers(): HasManyThrough
    {
        return $this->hasManyThrough(Offer::class, PublishedWorker::class);
    }
}
