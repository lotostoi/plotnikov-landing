<?php

namespace App\Filament\Resources\ContentSections\AboutBlocksResource\Pages;

use App\Filament\Resources\ContentSections\AboutBlocksResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAboutBlocks extends ListRecords
{
    protected static string $resource = AboutBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Добавить блок'),
        ];
    }
}
