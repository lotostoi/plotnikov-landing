<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Livewire\Features\SupportFileUploads\FileUploadConfiguration;
use Livewire\Features\SupportFileUploads\FileUploadController;

class LivewireSignedFileUploadController extends FileUploadController
{
    public function handle()
    {
        abort_unless(request()->hasValidSignature(false), 401);

        $disk = FileUploadConfiguration::disk();

        $filePaths = $this->validateAndStore(request('files'), $disk);

        return ['paths' => $filePaths];
    }
}
