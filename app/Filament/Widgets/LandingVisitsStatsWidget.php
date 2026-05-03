<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\LandingPageContent;
use App\Models\LandingPageViewLog;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LandingVisitsStatsWidget extends StatsOverviewWidget
{
    protected static bool $isDiscovered = false;

    protected static ?int $sort = -5;

    protected ?string $pollingInterval = null;

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        $content = LandingPageContent::query()->first();
        $views   = (int) ($content?->landing_page_views_count ?? 0);
        $last    = $content?->landing_page_last_view_at;

        $lastLabel = $last !== null
            ? $last->timezone(config('app.timezone'))->format('d.m.Y H:i')
            : '—';

        $today = LandingPageViewLog::query()
            ->whereDate('viewed_at', today())
            ->count();

        /** @var object|null $maxRow */
        $maxRow = LandingPageViewLog::query()
            ->selectRaw('DATE(viewed_at) as day, COUNT(*) as cnt')
            ->where('viewed_at', '>=', now()->subDays(30))
            ->groupByRaw('DATE(viewed_at)')
            ->orderByDesc('cnt')
            ->first();

        $maxDay     = (int) ($maxRow?->cnt ?? 0);
        $maxDayDate = $maxRow?->day ?? '—';

        $tgHandle = $content?->contact_handle
            ? '@' . ltrim((string) $content->contact_handle, '@')
            : 'Telegram';

        $tgUrl = $content?->telegram_url ?? null;

        $stats = [
            Stat::make('Всего просмотров', number_format($views, 0, ',', ' '))
                ->description('Все открытия главной за всё время')
                ->descriptionIcon('heroicon-m-eye')
                ->color('primary'),

            Stat::make('Сегодня', (string) $today)
                ->description('Просмотров за ' . now()->timezone(config('app.timezone'))->format('d.m.Y'))
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color($today > 0 ? 'success' : 'gray'),

            Stat::make('Рекорд дня (30 дн.)', (string) $maxDay)
                ->description('Макс. за день: ' . $maxDayDate)
                ->descriptionIcon('heroicon-m-trophy')
                ->color('warning'),

            Stat::make('Последний визит', $lastLabel)
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),
        ];

        if ($tgUrl) {
            $stats[] = Stat::make('Telegram-канал', $tgHandle)
                ->description('Перейти в канал — читать обо мне')
                ->descriptionIcon('heroicon-m-arrow-top-right-on-square')
                ->color('success')
                ->url($tgUrl);
        }

        return $stats;
    }
}
