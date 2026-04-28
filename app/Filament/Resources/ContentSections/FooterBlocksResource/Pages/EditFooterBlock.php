<?php

namespace App\Filament\Resources\ContentSections\FooterBlocksResource\Pages;

use App\Filament\Resources\ContentSections\FooterBlocksResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFooterBlock extends EditRecord
{
    protected static string $resource = FooterBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
