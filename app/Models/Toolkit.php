<?php

namespace App\Models;

use App\Enums\ToolkitStage;
use App\Models\Concerns\HasTranslations;
use App\Models\Concerns\ResolvesMediaUrl;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\RouteKey;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'title', 'title_en', 'slug', 'stage', 'description', 'description_en', 'thumbnail', 'video_url', 'pdf_path',
    'tools_count', 'activities_count', 'duration_label', 'duration_label_en', 'sort_order', 'is_active',
])]
#[RouteKey('slug')]
class Toolkit extends Model
{
    use ResolvesMediaUrl, HasTranslations;

    protected array $translatable = ['title', 'description', 'duration_label'];

    protected function casts(): array
    {
        return [
            'stage' => ToolkitStage::class,
            'is_active' => 'boolean',
        ];
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', true)->orderBy('sort_order');
    }

    protected function thumbnailUrl(): Attribute
    {
        return Attribute::get(fn () => $this->mediaUrl($this->thumbnail));
    }

    protected function pdfUrl(): Attribute
    {
        return Attribute::get(fn () => $this->mediaUrl($this->pdf_path));
    }
}
