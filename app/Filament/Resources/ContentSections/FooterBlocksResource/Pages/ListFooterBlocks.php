<?php

namespace App\Filament\Resources\ContentSections\FooterBlocksResource\Pages;

use App\Filament\Resources\ContentSections\FooterBlocksResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFooterBlocks extends ListRecords
{
    protected static string $resource = FooterBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Добавить блок'),
        ];
    }
}
