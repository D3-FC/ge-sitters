<?php

namespace App;

use App\Enums\WorkerRelation;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 */
class Worker extends Model
{
    use SoftDeletes;

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
        $w = new static();

        $w->fillFields($params);

        $w->associateUser($user);

        return $w;
    }

    private function fillFields(array $params): self
    {
        $this->max_child_age = data_get($params, 'max_child_age');
        $this->min_child_age = data_get($params, 'min_child_age');
        $this->description = data_get($params, 'description');
        $this->animal_relationship = data_get($params, 'animal_relationship');
        $this->meeting_price = data_get($params, 'meeting_price');
        $this->coords_x = data_get($params, 'coords_x');
        $this->coords_y = data_get($params, 'coords_y');
        $this->has_card_payment = data_get($params, 'has_card_payment');
        $this->sits_special_children = data_get($params, 'sits_special_children');
        $this->has_training = data_get($params, 'has_training');
        $this->can_overwork = data_get($params, 'can_overwork');
        $this->birthday = data_get($params, 'birthday');

        return $this;
    }

    private function associateUser(User $user)
    {
        $this->user()->associate($user);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updateFromParams(array $params): bool
    {
        return $this->fillFields($params)->save();
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
        $pw = PublishedWorker::init([], $this);
        $this->publishedWorker()->save($pw);

        return $pw;
    }

    private function publishedWorker(): HasOne
    {
        return $this->hasOne(PublishedWorker::class);
    }

    public function loadPrices(): self
    {
        return $this->load(WorkerRelation::PRICES);
    }

    public function loadSchedules(): self
    {
        return $this->load(WorkerRelation::SCHEDULES);
    }

    public function loadUser(): self
    {
        return $this->load(WorkerRelation::USER);
    }

    private function createPricesFromParams(array $paramsList): bool  // TODO: mb remove 2020-02-22
    {
        $prices = collect($paramsList)->map(function (array $params) {
            return Price::init($params, $this);
        });

        $r = Price::insert($prices->toArray());

        $this->loadMissing(WorkerRelation::PRICES);

        return $r;
    }

}
