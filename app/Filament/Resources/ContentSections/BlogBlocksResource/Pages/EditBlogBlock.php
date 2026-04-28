<?php

namespace App\Filament\Resources\ContentSections\BlogBlocksResource\Pages;

use App\Filament\Resources\ContentSections\BlogBlocksResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBlogBlock extends EditRecord
{
    protected static string $resource = BlogBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
