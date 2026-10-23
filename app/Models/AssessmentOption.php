<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['assessment_question_id', 'label', 'label_en', 'text', 'text_en', 'score', 'sort_order'])]
class AssessmentOption extends Model
{
    use HasTranslations;

    protected array $translatable = ['label', 'text'];
    public function question(): BelongsTo
    {
        return $this->belongsTo(AssessmentQuestion::class, 'assessment_question_id');
    }
}
