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
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Schedule onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Schedule withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Schedule withoutTrashed()
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
        /** @var Schedule $s */
        $s = $this->worker()->associate($worker);

        return $s;
    }

    private function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
}
