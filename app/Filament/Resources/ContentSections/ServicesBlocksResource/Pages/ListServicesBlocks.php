<?php

namespace App\Filament\Resources\ContentSections\ServicesBlocksResource\Pages;

use App\Filament\Resources\ContentSections\ServicesBlocksResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListServicesBlocks extends ListRecords
{
    protected static string $resource = ServicesBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Добавить блок'),
        ];
    }
}
