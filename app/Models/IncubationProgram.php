<?php

namespace App\Models;

use App\Models\Concerns\ResolvesMediaUrl;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\RouteKey;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'description', 'cover_image', 'sort_order', 'is_active'])]
#[RouteKey('slug')]
class IncubationProgram extends Model
{
    use ResolvesMediaUrl;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function photos(): HasMany
    {
        return $this->hasMany(IncubationProgramPhoto::class)->orderBy('sort_order');
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', true)->orderBy('sort_order');
    }

    protected function coverImageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->mediaUrl($this->cover_image));
    }
}
