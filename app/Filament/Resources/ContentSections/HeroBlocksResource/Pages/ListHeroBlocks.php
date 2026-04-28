<?php

namespace App\Filament\Resources\ContentSections\HeroBlocksResource\Pages;

use App\Filament\Resources\ContentSections\HeroBlocksResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHeroBlocks extends ListRecords
{
    protected static string $resource = HeroBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Добавить блок'),
        ];
    }
}
