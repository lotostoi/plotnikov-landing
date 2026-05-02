<?php

declare(strict_types=1);

namespace App\Support\Livewire;

use Illuminate\Support\Facades\URL;
use Livewire\Features\SupportFileUploads\FileUploadConfiguration;
use Livewire\Features\SupportFileUploads\GenerateSignedUploadUrl;

/**
 * Подпись upload-file по относительному пути (без схемы/хоста), чтобы не ловить 401 за прокси,
 * когда генерация signed URL и POST расходятся по https/http или Host.
 */
class RelativeSignedUploadUrlGenerator extends GenerateSignedUploadUrl
{
    public function forLocal()
    {
        return URL::temporarySignedRoute(
            'livewire.upload-file',
            now()->addMinutes(FileUploadConfiguration::maxUploadTime()),
            [],
            false,
        );
    }
}
