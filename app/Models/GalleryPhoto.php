<?php

namespace App\Models;

use App\Models\Concerns\ResolvesMediaUrl;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['event_id', 'image', 'caption', 'sort_order'])]
class GalleryPhoto extends Model
{
    use ResolvesMediaUrl;

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->mediaUrl($this->image));
    }
}
