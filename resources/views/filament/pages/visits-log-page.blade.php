<x-filament-panels::page>
    @livewire(\App\Filament\Widgets\LandingVisitsStatsWidget::class, [], key('visits-stats'))
    @livewire(\App\Filament\Widgets\LandingVisitsChartWidget::class, [], key('visits-chart'))
    {{ $this->table }}
</x-filament-panels::page>
