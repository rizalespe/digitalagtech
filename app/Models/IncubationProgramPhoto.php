<?php

namespace App\Models;

use App\Models\Concerns\ResolvesMediaUrl;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['incubation_program_id', 'image', 'caption', 'sort_order'])]
class IncubationProgramPhoto extends Model
{
    use ResolvesMediaUrl;

    public function program(): BelongsTo
    {
        return $this->belongsTo(IncubationProgram::class, 'incubation_program_id');
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->mediaUrl($this->image));
    }
}
