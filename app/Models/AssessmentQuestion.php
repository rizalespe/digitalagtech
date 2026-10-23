<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['assessment_dimension_id', 'question', 'question_en', 'sort_order', 'is_active'])]
class AssessmentQuestion extends Model
{
    use HasTranslations;

    protected array $translatable = ['question'];
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function dimension(): BelongsTo
    {
        return $this->belongsTo(AssessmentDimension::class, 'assessment_dimension_id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(AssessmentOption::class)->orderBy('sort_order');
    }
}
