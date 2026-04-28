<?php

namespace App\Filament\Resources\ContentSections\HeaderBlocksResource\Pages;

use App\Filament\Resources\ContentSections\HeaderBlocksResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHeaderBlock extends EditRecord
{
    protected static string $resource = HeaderBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
