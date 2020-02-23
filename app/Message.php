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
 * @property int $id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $fromUser
 * @property-read \App\User $toUser
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Message onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereFromUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereToUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Message withoutTrashed()
 * @mixin \Eloquent
 */
class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'content',
    ];

    public static function init(array $params, User $from, User $to)
    {
        return static::make($params)->associateFromUser($from)->associateToUser($to);
    }

    private function associateToUser(User $u): self
    {
        $this->toUser()->associate($u);

        return $this;
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    private function associateFromUser(User $u): self
    {
        $this->fromUser()->associate($u);

        return $this;
    }

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

}
