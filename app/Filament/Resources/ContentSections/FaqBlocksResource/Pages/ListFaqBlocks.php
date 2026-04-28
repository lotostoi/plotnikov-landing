<?php

namespace App\Filament\Resources\ContentSections\FaqBlocksResource\Pages;

use App\Filament\Resources\ContentSections\FaqBlocksResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFaqBlocks extends ListRecords
{
    protected static string $resource = FaqBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Добавить блок'),
        ];
    }
}
