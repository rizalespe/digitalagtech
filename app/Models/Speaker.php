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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

#[Fillable(['name', 'slug', 'title', 'title_en', 'expertise', 'expertise_en', 'bio', 'bio_en', 'photo', 'linkedin_url', 'instagram_url', 'is_featured', 'sort_order'])]
#[RouteKey('slug')]
class Speaker extends Model
{
    use ResolvesMediaUrl, HasTranslations;

    protected array $translatable = ['title', 'expertise', 'bio'];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
        ];
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)->withPivot('role');
    }

    #[Scope]
    protected function ordered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('name');
    }

    #[Scope]
    protected function featured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    protected function photoUrl(): Attribute
    {
        return Attribute::get(fn () => $this->mediaUrl($this->photo));
    }

    protected function initials(): Attribute
    {
        return Attribute::get(fn () => Str::of($this->name)
            ->replaceMatches('/,.*$/', '')
            ->explode(' ')
            ->filter()
            ->take(2)
            ->map(fn (string $word) => Str::upper(Str::substr($word, 0, 1)))
            ->implode(''));
    }
}
