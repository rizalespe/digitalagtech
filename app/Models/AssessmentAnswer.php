<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['assessment_attempt_id', 'assessment_question_id', 'assessment_option_id'])]
class AssessmentAnswer extends Model
{
    public function attempt(): BelongsTo
    {
        return $this->belongsTo(AssessmentAttempt::class, 'assessment_attempt_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(AssessmentQuestion::class, 'assessment_question_id');
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(AssessmentOption::class, 'assessment_option_id');
    }
}
