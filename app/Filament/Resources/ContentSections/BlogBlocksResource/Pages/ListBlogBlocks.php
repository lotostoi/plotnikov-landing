<?php

namespace App\Filament\Resources\ContentSections\BlogBlocksResource\Pages;

use App\Filament\Resources\ContentSections\BlogBlocksResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBlogBlocks extends ListRecords
{
    protected static string $resource = BlogBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Добавить блок'),
        ];
    }
}
