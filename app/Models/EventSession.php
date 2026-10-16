<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

#[Fillable(['event_id', 'starts_at', 'ends_at', 'title', 'sort_order'])]
class EventSession extends Model
{
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Time range label, e.g. "09.00 AM – 09.20 AM".
     */
    protected function timeRange(): Attribute
    {
        return Attribute::get(fn () => Carbon::parse($this->starts_at)->format('h.i A')
            .' – '.Carbon::parse($this->ends_at)->format('h.i A'));
    }
}
