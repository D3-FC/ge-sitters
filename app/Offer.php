<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Offer
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Advertisement $advertisement
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Offer onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Offer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Offer withoutTrashed()
 * @property int $advertisement_id
 * @property int $published_worker_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Contract $contract
 * @property-read \App\PublishedWorker $publishedWorker
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereAdvertisementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer wherePublishedWorkerId($value)
 */
class Offer extends Model
{
    use SoftDeletes;

    public static function init(array $params, Advertisement $a, PublishedWorker $pw)
    {
        return static::make($params)->associateAdvertisement($a)->associatePublishedWorker($pw);
    }

    private function associatePublishedWorker(PublishedWorker $pw): self
    {
        $this->publishedWorker()->associate($pw);

        return $this;
    }

    public function publishedWorker(): BelongsTo
    {
        return $this->belongsTo(PublishedWorker::class);
    }

    private function associateAdvertisement(Advertisement $a): self
    {
        $this->advertisement()->associate($a);

        return $this;
    }

    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function createContract(): Contract
    {
        if ($this->contract) {
            abort(403, 'This offer already has contract.');
        }
        /** @var Contract $c */
        $c = $this->contract()->create();

        return $c;
    }

    public function contract(): HasOne
    {
        return $this->hasOne(Contract::class);
    }
}
