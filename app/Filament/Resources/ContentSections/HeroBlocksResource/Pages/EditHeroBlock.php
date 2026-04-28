<?php

namespace App\Filament\Resources\ContentSections\HeroBlocksResource\Pages;

use App\Filament\Resources\ContentSections\HeroBlocksResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHeroBlock extends EditRecord
{
    protected static string $resource = HeroBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
