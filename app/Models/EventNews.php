<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

use Illuminate\Database\Eloquent\MassPrunable;

#[Fillable([
    'user_id',
    'title',
    'slug',
    'content',
    'image_path',
    'author_name',
    'source_url',
    'publish_date'
])]
class EventNews extends Model
{
    use MassPrunable;

    /**
     * Get the prunable model query.
     */
    public function prunable()
    {
        return static::where('publish_date', '<=', now()->subMonths(3));
    }

    protected $casts = [
        'publish_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function savedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'saved_events', 'event_news_id', 'user_id')->withTimestamps();
    }
}
