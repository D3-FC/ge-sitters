<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Message
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message query()
 * @mixin Eloquent
 * @property int $id
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUpdatedAt($value)
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static Builder|Message onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereDeletedAt($value)
 * @method static Builder|Message withTrashed()
 * @method static Builder|Message withoutTrashed()
 */
class Message extends Model
{
    use SoftDeletes;

    public static function init(array $params, User $from, User $to)
    {
        $m = new static();
        $m->content = data_get($params, 'content');
        $m->associateFromUser($from);
        $m->associateToUser($to);

        return $m;
    }

    private function associateFromUser(User $u)
    {
        $this->fromUser()->associate($u);
    }

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    private function associateToUser(User $u)
    {
        $this->toUser()->associate($u);
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
