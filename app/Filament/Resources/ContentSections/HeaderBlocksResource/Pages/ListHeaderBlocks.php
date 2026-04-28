<?php

namespace App\Filament\Resources\ContentSections\HeaderBlocksResource\Pages;

use App\Filament\Resources\ContentSections\HeaderBlocksResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHeaderBlocks extends ListRecords
{
    protected static string $resource = HeaderBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Добавить блок'),
        ];
    }
}
