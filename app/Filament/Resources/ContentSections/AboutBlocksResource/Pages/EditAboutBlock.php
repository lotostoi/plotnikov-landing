<?php

namespace App\Filament\Resources\ContentSections\AboutBlocksResource\Pages;

use App\Filament\Resources\ContentSections\AboutBlocksResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAboutBlock extends EditRecord
{
    protected static string $resource = AboutBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
