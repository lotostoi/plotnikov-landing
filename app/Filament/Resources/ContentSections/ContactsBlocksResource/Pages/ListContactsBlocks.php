<?php

namespace App\Filament\Resources\ContentSections\ContactsBlocksResource\Pages;

use App\Filament\Resources\ContentSections\ContactsBlocksResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContactsBlocks extends ListRecords
{
    protected static string $resource = ContactsBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Добавить блок'),
        ];
    }
}
