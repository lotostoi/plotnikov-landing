<?php

namespace App\Filament\Resources\ContentSections\ServicesBlocksResource\Pages;

use App\Filament\Resources\ContentSections\ServicesBlocksResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditServicesBlock extends EditRecord
{
    protected static string $resource = ServicesBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
