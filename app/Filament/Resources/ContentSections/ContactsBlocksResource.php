<?php

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\ContactsBlocksResource\Pages\ManageContactsBlocks;

class ContactsBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Контакты';
    protected static ?int $navigationSort = 18;

    protected static function sectionCode(): string
    {
        return 'contacts';
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageContactsBlocks::route('/'),
        ];
    }
}

