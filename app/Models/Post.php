<?php

namespace App\Models;

use App\Observers\ModelObserver;
use App\Traits\FillableColumns;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $tenant_id
 * @property int $user_id
 * @property-read \App\Models\User|null $author
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUserId($value)
 * @mixin \Eloquent
 */
class Post extends Model
{
    use HasFactory, FillableColumns;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public static function booted()
    {
        static::addGlobalScope(new Scopes\TenantScope());
        static::observe(ModelObserver::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
