<?php

namespace App\Filament\Resources\AssessmentDimensionResource\Pages;

use App\Filament\Resources\AssessmentDimensionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssessmentDimension extends EditRecord
{
    protected static string $resource = AssessmentDimensionResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
