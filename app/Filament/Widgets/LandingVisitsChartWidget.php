<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\LandingPageViewLog;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Schema;

class LandingVisitsChartWidget extends ChartWidget
{
    protected static bool $isDiscovered = false;

    protected static ?int $sort = -4;

    protected int | string | array $columnSpan = 'full';

    protected ?string $heading = 'Просмотры по дням';

    protected ?string $description = 'Каждое открытие главной страницы лендинга (не админки).';

    protected ?string $maxHeight = '320px';

    public ?string $filter = '30';

    public function updatedFilter(): void
    {
        $this->cachedData = null;
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getFilters(): ?array
    {
        return [
            '7'   => '7 дней',
            '30'  => '30 дней',
            '90'  => '90 дней',
            '365' => 'Год',
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks'       => ['precision' => 0, 'stepSize' => 1],
                    'grid'        => ['color' => 'rgba(127,127,127,.08)'],
                ],
                'x' => [
                    'grid' => ['display' => false],
                ],
            ],
            'barPercentage'      => 0.75,
            'categoryPercentage' => 0.9,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        if (! Schema::hasTable('landing_page_view_logs')) {
            return [
                'labels'   => [],
                'datasets' => [['label' => 'Просмотры', 'data' => []]],
            ];
        }

        $days  = max(1, min(366, (int) ($this->filter ?: 30)));
        $tz    = config('app.timezone') ?: 'UTC';
        $end   = Carbon::now($tz)->endOfDay();
        $start = Carbon::now($tz)->subDays($days - 1)->startOfDay();

        $logs = LandingPageViewLog::query()
            ->where('viewed_at', '>=', $start)
            ->where('viewed_at', '<=', $end)
            ->get(['viewed_at']);

        $counts = [];
        foreach ($logs as $log) {
            $key          = $log->viewed_at->timezone($tz)->format('Y-m-d');
            $counts[$key] = ($counts[$key] ?? 0) + 1;
        }

        $labels = [];
        $data   = [];
        $cursor = $start->copy();

        for ($i = 0; $i < $days; $i++) {
            $key      = $cursor->format('Y-m-d');
            $labels[] = $cursor->format('d.m');
            $data[]   = $counts[$key] ?? 0;
            $cursor->addDay();
        }

        return [
            'labels'   => $labels,
            'datasets' => [
                [
                    'label'           => 'Просмотры',
                    'data'            => $data,
                    'backgroundColor' => 'rgba(245,158,11,0.72)',
                    'borderColor'     => 'rgba(245,158,11,1)',
                    'borderWidth'     => 1,
                    'borderRadius'    => 5,
                    'hoverBackgroundColor' => 'rgba(245,158,11,0.92)',
                ],
            ],
        ];
    }
}
