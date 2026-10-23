<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use App\Models\Concerns\ResolvesMediaUrl;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\RouteKey;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'title', 'title_en', 'slug', 'excerpt', 'excerpt_en', 'body', 'body_en', 'thumbnail', 'author_name', 'published_at'])]
#[RouteKey('slug')]
class Post extends Model
{
    use ResolvesMediaUrl, HasTranslations;

    protected array $translatable = ['title', 'excerpt', 'body'];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at');
    }

    protected function thumbnailUrl(): Attribute
    {
        return Attribute::get(fn () => $this->mediaUrl($this->thumbnail));
    }
}
