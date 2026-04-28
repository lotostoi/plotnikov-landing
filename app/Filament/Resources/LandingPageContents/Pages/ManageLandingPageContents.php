<?php

namespace App\Filament\Resources\LandingPageContents\Pages;

use App\Filament\Resources\LandingPageContents\LandingPageContentResource;
use App\Models\LandingPageContent;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageLandingPageContents extends ManageRecords
{
    protected static string $resource = LandingPageContentResource::class;

    protected function getHeaderActions(): array
    {
        if (LandingPageContent::exists()) {
            return [];
        }

        return [
            CreateAction::make(),
        ];
    }
}
