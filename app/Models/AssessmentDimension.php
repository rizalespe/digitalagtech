<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'name_en', 'slug', 'description', 'description_en', 'sort_order'])]
class AssessmentDimension extends Model
{
    use HasTranslations;

    protected array $translatable = ['name', 'description'];
    public function questions(): HasMany
    {
        return $this->hasMany(AssessmentQuestion::class)->orderBy('sort_order');
    }
}
