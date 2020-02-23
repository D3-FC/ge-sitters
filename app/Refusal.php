<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Refusal
 *
 * @property-read \App\Offer $offer
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refusal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refusal newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Refusal onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Refusal query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Refusal withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Refusal withoutTrashed()
 * @mixin \Eloquent
 */
class Refusal extends Model
{
    use SoftDeletes;

    public function offer(): BelongsTo
    {
        return  $this->belongsTo(Offer::class);
    }
}
