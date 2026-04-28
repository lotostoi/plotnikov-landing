<?php

namespace App\Filament\Resources\ContentSections\BlogBlocksResource\Pages;

use App\Filament\Resources\ContentSections\BlogBlocksResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogBlock extends CreateRecord
{
    protected static string $resource = BlogBlocksResource::class;
}
