<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * App\Advertisement
 *
 * @property int $id
 * @property int $client_id
 * @property int|null $children_count
 * @property string $payment_method
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $date
 * @property string|null $from
 * @property string|null $to
 * @property float|null $price
 * @property float|null $meeting_price
 * @property float|null $coords_x
 * @property float|null $coords_y
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Client $client
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Advertisement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereChildrenCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereCoordsX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereCoordsY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereMeetingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Advertisement withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Advertisement withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Offer[] $offers
 * @property-read int|null $offers_count
 */
class Advertisement extends Model
{
    use SoftDeletes;

    protected $dates = [
        'date',
    ];

    protected $fillable = [
        'children_count',
        'payment_method',
        'description',
        'date',
        'from',
        'to',
        'price',
        'meeting_price',
        'coords_y',
    ];

    public static function init(array $params, Client $client): self
    {
        return static::make($params)->associateClient($client);
    }

    private function associateClient(Client $client): self
    {
        $this->client()->associate($client);

        return $this;
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @param  array  $params
     * @param  PublishedWorker  $pw
     *
     * @return Offer
     * @throws HttpException
     */
    public function createOfferTo(array $params, PublishedWorker $pw): Offer
    {
        if ($this->hasOfferFor($pw)) {
            abort(403, 'Already has offer for same Worker');
        }
        $o = Offer::init($params, $this, $pw);

        return $this->addOffer($o);
    }

    private function hasOfferFor(PublishedWorker $pw)
    {
        return $this->offers()->wherePublishedWorkerId($pw->id);
    }

    /**
     * @return HasMany|Offer
     */
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    private function addOffer($o): Offer
    {
        $this->offers()->save($o);

        return $o;
    }

}
