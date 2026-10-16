<?php

namespace App\Filament\Resources\IncubationProgramResource\Pages;

use App\Filament\Resources\IncubationProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncubationPrograms extends ListRecords
{
    protected static string $resource = IncubationProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
