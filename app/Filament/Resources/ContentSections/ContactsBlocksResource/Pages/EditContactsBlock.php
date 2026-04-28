<?php

namespace App\Filament\Resources\ContentSections\ContactsBlocksResource\Pages;

use App\Filament\Resources\ContentSections\ContactsBlocksResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContactsBlock extends EditRecord
{
    protected static string $resource = ContactsBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
