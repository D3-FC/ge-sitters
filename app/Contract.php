<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Contract
 *
 * @property int $id
 * @property int $user_id
 * @property string $payment_method
 * @property string|null $description
 * @property string|null $date
 * @property string|null $from
 * @property string|null $to
 * @property float|null $price
 * @property float|null $meeting_price
 * @property float|null $coords_x
 * @property float|null $coords_y
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Contract onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereChildCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereCoordsX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereCoordsY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereMeetingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contract withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Contract withoutTrashed()
 * @mixin \Eloquent
 * @property int $children_count
 * @property-read \App\Client $client
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereChildrenCount($value)
 * @property int $client_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereClientId($value)
 * @property int $offer_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereOfferId($value)
 * @property-read \App\Offer $offer
 */
class Contract extends Model
{
    use SoftDeletes;

    public function offer(): BelongsTo
    {
        return  $this->belongsTo(Offer::class);
    }
}
