<?php

namespace App\Models;

use App\Enums\EventType;
use App\Models\Concerns\HasTranslations;
use App\Models\Concerns\ResolvesMediaUrl;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\RouteKey;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'title', 'title_en', 'slug', 'type', 'summary', 'summary_en', 'description', 'description_en',
    'starts_at', 'ends_at', 'location', 'city', 'is_online', 'meeting_url', 'thumbnail', 'flyer',
    'workshop_cities', 'quota', 'is_featured', 'registration_open', 'published_at',
])]
#[RouteKey('slug')]
class Event extends Model
{
    use ResolvesMediaUrl, HasTranslations;

    protected array $translatable = ['title', 'summary', 'description'];

    protected function casts(): array
    {
        return [
            'type' => EventType::class,
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_online' => 'boolean',
            'workshop_cities' => 'array',
            'is_featured' => 'boolean',
            'registration_open' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(EventSession::class)->orderBy('sort_order')->orderBy('starts_at');
    }

    public function speakers(): BelongsToMany
    {
        return $this->belongsToMany(Speaker::class)->withPivot('role');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class);
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    #[Scope]
    protected function upcoming(Builder $query): void
    {
        $query->where('starts_at', '>=', now()->startOfDay())->orderBy('starts_at');
    }

    #[Scope]
    protected function past(Builder $query): void
    {
        $query->where('starts_at', '<', now()->startOfDay())->orderByDesc('starts_at');
    }

    public function isFull(): bool
    {
        return $this->quota !== null && $this->registrations()->count() >= $this->quota;
    }

    public function acceptsRegistrations(): bool
    {
        return $this->registration_open && $this->starts_at->isFuture() && ! $this->isFull();
    }

    protected function thumbnailUrl(): Attribute
    {
        return Attribute::get(fn () => $this->mediaUrl($this->thumbnail));
    }

    protected function flyerUrl(): Attribute
    {
        return Attribute::get(fn () => $this->mediaUrl($this->flyer));
    }

    /**
     * Time range label, e.g. "09:00 – 11:00 WIB".
     */
    protected function timeRange(): Attribute
    {
        return Attribute::get(function () {
            $range = $this->starts_at->format('H:i');

            if ($this->ends_at) {
                $range .= ' – '.$this->ends_at->format('H:i');
            }

            return $range.' WIB';
        });
    }
}
