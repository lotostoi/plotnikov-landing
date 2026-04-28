<?php

namespace App\Filament\Resources\ContentSections\EducationBlocksResource\Pages;

use App\Filament\Resources\ContentSections\EducationBlocksResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEducationBlocks extends ListRecords
{
    protected static string $resource = EducationBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Добавить блок'),
        ];
    }
}
