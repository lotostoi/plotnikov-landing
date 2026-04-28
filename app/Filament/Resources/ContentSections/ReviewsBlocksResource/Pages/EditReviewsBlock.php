<?php

namespace App\Filament\Resources\ContentSections\ReviewsBlocksResource\Pages;

use App\Filament\Resources\ContentSections\ReviewsBlocksResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditReviewsBlock extends EditRecord
{
    protected static string $resource = ReviewsBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
