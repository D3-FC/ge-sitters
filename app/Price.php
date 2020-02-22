<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 */
class Price extends Model
{

    public static function init(array $params, Worker $worker): self
    {
        $p = new static();
        $p->fillFields($params);

        $p->associateWorker($worker);

        return $p;
    }

    //

    private function fillFields(array $params)
    {
        $this->children_count = data_get($params, 'children_count');
        $this->amount_per_hour = data_get($params, 'amount_per_hour');
        $this->over_time_amount_per_hour = data_get($params, 'over_time_amount_per_hour');

    }

    private function associateWorker(Worker $worker): Worker
    {
        /** @var Worker $w */
        $w = $this->worker()->associate($worker);

        return $w;
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
}
