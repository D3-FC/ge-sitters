<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Schedule
 *
 * @property int $id
 * @property int $worker_id
 * @property string|null $day
 * @property string|null $from
 * @property string|null $to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereWorkerId($value)
 * @mixin \Eloquent
 */
class Schedule extends Model
{
    use SoftDeletes;

    public static function init(array $params, Worker $worker): Schedule
    {
        $s = new static();
        $s->fillFields($params);

        $s->associateWorker($worker);

        return $s;
    }

    private function fillFields(array $params): self
    {
        $this->day = data_get($params, 'day');
        $this->from = data_get($params, 'from');
        $this->to = data_get($params, 'to');

        return $this;
    }

    private function associateWorker(Worker $worker): Schedule
    {
        return $this->worker()->associate($worker);
    }

    private function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
}
