<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\File;

class LogViewerPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-bug-ant';

    protected string $view = 'filament.pages.log-viewer';

    protected static ?string $navigationLabel = 'Логи';

    protected static ?string $title = 'Laravel Log';

    protected static ?int $navigationSort = 99;

    public static function getNavigationGroup(): string|null
    {
        return 'Система';
    }

    private const LOG_FILE = 'logs/laravel.log';

    private const TAIL_LINES = 500;

    public function getLogContent(): string
    {
        $path = storage_path(self::LOG_FILE);

        if (! File::exists($path)) {
            return 'Лог-файл не найден: ' . $path;
        }

        $file = new \SplFileObject($path, 'r');
        $file->seek(PHP_INT_MAX);
        $total = $file->key();

        $startLine = max(0, $total - self::TAIL_LINES);
        $lines = [];
        $file->seek($startLine);

        while (! $file->eof()) {
            $lines[] = rtrim((string) $file->current());
            $file->next();
        }

        return implode("\n", $lines);
    }

    public function getLogSizeLabel(): string
    {
        $path = storage_path(self::LOG_FILE);

        if (! File::exists($path)) {
            return '';
        }

        $bytes = File::size($path);

        if ($bytes >= 1024 * 1024) {
            return number_format($bytes / 1024 / 1024, 2) . ' MB';
        }

        return number_format($bytes / 1024, 1) . ' KB';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('clear')
                ->label('Очистить лог')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Очистить лог?')
                ->modalDescription('Содержимое файла laravel.log будет удалено. Файл останется на месте.')
                ->action(function (): void {
                    $path = storage_path(self::LOG_FILE);

                    if (File::exists($path)) {
                        File::put($path, '');
                    }

                    Notification::make()
                        ->title('Лог очищен')
                        ->success()
                        ->send();
                }),

            Action::make('refresh')
                ->label('Обновить')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->action(fn () => null),
        ];
    }
}
