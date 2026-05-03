<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\LandingPageContent;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LandingVisitsStatsWidget extends StatsOverviewWidget
{
    protected static bool $isDiscovered = false;

    protected static ?int $sort = -5;

    protected ?string $pollingInterval = null;

    protected ?string $heading = 'Просмотры лендинга';

    protected ?string $description = 'Счётчик на сервере (каждое открытие главной). Не заменяет Яндекс.Метрику.';

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        $content = LandingPageContent::query()->first();
        $views = (int) ($content?->landing_page_views_count ?? 0);
        $last = $content?->landing_page_last_view_at;

        $lastLabel = $last !== null
            ? $last->timezone(config('app.timezone'))->format('d.m.Y H:i')
            : '—';

        return [
            Stat::make('Всего просмотров', number_format($views, 0, ',', ' ')),
            Stat::make('Последний просмотр', $lastLabel),
        ];
    }
}
