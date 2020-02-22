<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\PublishedWorker
 *
 * @property int $id
 * @property int $worker_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PublishedWorker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PublishedWorker newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\PublishedWorker onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PublishedWorker query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PublishedWorker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PublishedWorker whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PublishedWorker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PublishedWorker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PublishedWorker whereWorkerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PublishedWorker withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\PublishedWorker withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Worker $worker
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PublishedWorker withPrices()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PublishedWorker withSchedules()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PublishedWorker withUser()
 */
class PublishedWorker extends Model
{
    use SoftDeletes;

    public static function init(array $params, Worker $worker): self
    {
        $pw = new static();

        $pw->associateWorker($worker);

        return $pw;
    }

    private function associateWorker(Worker $worker): PublishedWorker
    {
        /** @var PublishedWorker $pw */
        $pw = $this->worker()->associate($worker);

        return $pw;
    }

    /**
     * @return BelongsTo|Worker
     */
    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    /**
     * @param  int  $id
     *
     * @throws Exception
     */
    public static function deleteById(int $id)
    {
        static::whereId($id)->delete();
    }


}
