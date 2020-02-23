<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Client
 *
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Client onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Client withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Client withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contract[] $contracts
 * @property-read int|null $contracts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Advertisement[] $advertisements
 * @property-read int|null $advertisements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Offer[] $offers
 * @property-read int|null $offers_count
 */
class Client extends Model
{
    use SoftDeletes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function createAdvertisement(array $params)
    {
        $a = Advertisement::init($params, $this);

        return $this->addAdvertisement($a);
    }

    private function addAdvertisement(Advertisement $c): Advertisement
    {
        /** @var Advertisement $c */
        $c = $this->advertisements()->save($c);

        return $c;
    }

    /**
     * @return HasMany|Advertisement
     */
    public function advertisements(): HasMany
    {
        return $this->hasMany(Advertisement::class);
    }

    public function getAdvertisementById(int $id): Advertisement
    {
        /** @var Advertisement $a */
        $a = $this->advertisements()->findOrFail($id);

        return $a;
    }

    public function getOfferById(int $id): Offer
    {
        /** @var Offer $o */
        $o = $this->offers()->findOrFail($id);

        return $o;
    }

    /**
     * @return HasManyThrough|Advertisement
     */
    public function offers(): HasManyThrough
    {
        return $this->hasManyThrough(Offer::class, Advertisement::class);
    }


}
