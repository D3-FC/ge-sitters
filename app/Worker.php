<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Worker
 *
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Worker onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Worker whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Worker withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Worker withoutTrashed()
 * @mixin \Eloquent
 */
class Worker extends Model
{
    use SoftDeletes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
