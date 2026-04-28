<?php

namespace App\Filament\Resources\ContentSections\FaqBlocksResource\Pages;

use App\Filament\Resources\ContentSections\FaqBlocksResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFaqBlock extends EditRecord
{
    protected static string $resource = FaqBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
