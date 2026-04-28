<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class AnalyticsPage extends BaseSettingsPage
{
    protected static ?string $navigationLabel = 'Аналитика';
    protected static ?string $title = 'Аналитика и верификация';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;
    protected static ?int $navigationSort = 3;

    protected function getFormComponents(): array
    {
        return [
            Section::make('Счётчики аналитики')
                ->schema([
                    TextInput::make('yandex_metrika_id')
                        ->label('Яндекс.Метрика — Counter ID')
                        ->placeholder('12345678')
                        ->maxLength(50),
                    TextInput::make('google_analytics_id')
                        ->label('Google Analytics 4 — Measurement ID')
                        ->placeholder('G-XXXXXXXXXX')
                        ->maxLength(50),
                    TextInput::make('google_tag_manager_id')
                        ->label('Google Tag Manager — Container ID')
                        ->placeholder('GTM-XXXXXXX')
                        ->maxLength(50),
                ]),

            Section::make('Верификация в поисковиках')
                ->schema([
                    TextInput::make('yandex_verification')
                        ->label('Yandex Webmaster — verification meta')
                        ->maxLength(255),
                    TextInput::make('google_site_verification')
                        ->label('Google Search Console — verification meta')
                        ->maxLength(255),
                    TextInput::make('bing_site_verification')
                        ->label('Bing — verification meta')
                        ->maxLength(255),
                ]),

            Section::make('Соцсети')
                ->schema([
                    TextInput::make('vk_url')
                        ->label('ВКонтакте URL')
                        ->url()
                        ->maxLength(255),
                    TextInput::make('youtube_url')
                        ->label('YouTube URL')
                        ->url()
                        ->maxLength(255),
                    TextInput::make('instagram_url')
                        ->label('Instagram URL')
                        ->url()
                        ->maxLength(255),
                ]),
        ];
    }
}
