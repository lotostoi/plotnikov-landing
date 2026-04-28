<?php

namespace App\Filament\Resources\ContentSections\EducationBlocksResource\Pages;

use App\Filament\Resources\ContentSections\EducationBlocksResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEducationBlock extends EditRecord
{
    protected static string $resource = EducationBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
