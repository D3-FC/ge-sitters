<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Price
 *
 * @property int $id
 * @property int $worker_id
 * @property int $children_count
 * @property float|null $amount_per_hour
 * @property float|null $over_time_amount_per_hour
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Price newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Price newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Price query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Price whereAmountPerHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Price whereChildrenCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Price whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Price whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Price whereOverTimeAmountPerHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Price whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Price whereWorkerId($value)
 * @mixin \Eloquent
 * @property-read \App\Worker $worker
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Price onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Price whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Price withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Price withoutTrashed()
 */
class Price extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'children_count',
        'amount_per_hour',
        'over_time_amount_per_hour',
    ];

    public static function init(array $params, Worker $worker): self
    {
        return static::make($params)->associateWorker($worker); $p;
    }

    private function associateWorker(Worker $worker): Price
    {
        $this->worker()->associate($worker);

        return $this;
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
}
