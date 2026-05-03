<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\LandingPageViewLog;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use UnitEnum;

class VisitsLogPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.visits-log-page';

    protected static ?string $navigationLabel = 'Посещения';
    protected static ?string $title = 'Журнал посещений';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static UnitEnum|string|null $navigationGroup = 'Инфопанель';
    protected static ?int $navigationSort = 2;

    public function table(Table $table): Table
    {
        $hasNewColumns  = Schema::hasColumn('landing_page_view_logs', 'ip');
        $hasPageColumn  = Schema::hasColumn('landing_page_view_logs', 'page');

        return $table
            ->query(
                LandingPageViewLog::query()->latest('viewed_at')
            )
            ->columns(array_values(array_filter([
                TextColumn::make('viewed_at')
                    ->label('Дата и время')
                    ->dateTime('d.m.Y H:i:s')
                    ->timezone(config('app.timezone') ?: 'UTC')
                    ->sortable(),

                $hasPageColumn ? TextColumn::make('page')
                    ->label('Страница')
                    ->badge()
                    ->color(fn (?string $state): string => match (true) {
                        $state === '/'                      => 'success',
                        str_starts_with((string) $state, '/psiholog-online')      => 'info',
                        str_starts_with((string) $state, '/geshtalt-terapevt')    => 'warning',
                        str_starts_with((string) $state, '/psiholog-vladivostok') => 'primary',
                        str_starts_with((string) $state, '/psiholog-artem')       => 'gray',
                        default => 'gray',
                    })
                    ->sortable() : null,

                $hasNewColumns ? TextColumn::make('device')
                    ->label('Устройство')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'mobile'  => '📱 Mobile',
                        'tablet'  => '💻 Tablet',
                        'bot'     => '🤖 Bot',
                        'desktop' => '🖥 Desktop',
                        default   => '🖥 Desktop',
                    })
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'mobile'  => 'warning',
                        'tablet'  => 'info',
                        'bot'     => 'danger',
                        default   => 'success',
                    })
                    ->sortable() : null,

                $hasNewColumns ? TextColumn::make('ip')
                    ->label('IP-адрес')
                    ->copyable()
                    ->copyMessage('IP скопирован')
                    ->url(
                        fn (LandingPageViewLog $record): string => "https://ipinfo.io/{$record->ip}",
                        shouldOpenInNewTab: true,
                    )
                    ->color('primary') : null,

                $hasNewColumns ? TextColumn::make('utm_source')
                    ->label('UTM Source')
                    ->badge()
                    ->color('gray')
                    ->placeholder('—')
                    ->sortable() : null,

                $hasNewColumns ? TextColumn::make('utm_medium')
                    ->label('UTM Medium')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true) : null,

                $hasNewColumns ? TextColumn::make('utm_campaign')
                    ->label('UTM Campaign')
                    ->placeholder('—')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true) : null,

                $hasNewColumns ? TextColumn::make('utm_term')
                    ->label('UTM Term')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true) : null,

                $hasNewColumns ? TextColumn::make('utm_content')
                    ->label('UTM Content')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true) : null,

                $hasNewColumns ? TextColumn::make('referrer')
                    ->label('Реферер')
                    ->limit(50)
                    ->tooltip(fn (LandingPageViewLog $record): ?string => $record->referrer)
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true) : null,

                $hasNewColumns ? TextColumn::make('user_agent')
                    ->label('User-Agent')
                    ->limit(60)
                    ->tooltip(fn (LandingPageViewLog $record): ?string => $record->user_agent)
                    ->toggleable(isToggledHiddenByDefault: true) : null,
            ])))
            ->filters(array_values(array_filter([
                $hasPageColumn ? SelectFilter::make('page')
                    ->label('Страница')
                    ->options([
                        '/'                      => '🏠 Главная',
                        '/psiholog-online'       => '🌐 Психолог онлайн',
                        '/geshtalt-terapevt'     => '🧠 Гештальт-терапевт',
                        '/psiholog-vladivostok'  => '📍 Психолог Владивосток',
                        '/psiholog-artem'        => '📍 Психолог Артём',
                    ]) : null,

                $hasNewColumns ? SelectFilter::make('device')
                    ->label('Устройство')
                    ->options([
                        'desktop' => '🖥 Desktop',
                        'mobile'  => '📱 Mobile',
                        'tablet'  => '💻 Tablet',
                        'bot'     => '🤖 Bot',
                    ]) : null,

                $hasNewColumns ? SelectFilter::make('utm_source')
                    ->label('UTM Source')
                    ->options(
                        fn (): array => LandingPageViewLog::query()
                            ->whereNotNull('utm_source')
                            ->distinct()
                            ->orderBy('utm_source')
                            ->pluck('utm_source', 'utm_source')
                            ->toArray()
                    )
                    ->searchable() : null,

                $hasNewColumns ? SelectFilter::make('utm_medium')
                    ->label('UTM Medium')
                    ->options(
                        fn (): array => LandingPageViewLog::query()
                            ->whereNotNull('utm_medium')
                            ->distinct()
                            ->orderBy('utm_medium')
                            ->pluck('utm_medium', 'utm_medium')
                            ->toArray()
                    ) : null,

                $hasNewColumns ? SelectFilter::make('utm_campaign')
                    ->label('UTM Campaign')
                    ->options(
                        fn (): array => LandingPageViewLog::query()
                            ->whereNotNull('utm_campaign')
                            ->distinct()
                            ->orderBy('utm_campaign')
                            ->pluck('utm_campaign', 'utm_campaign')
                            ->toArray()
                    ) : null,

                Filter::make('has_utm')
                    ->label('Только с UTM')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('utm_source'))
                    ->toggle(),
            ])))
            ->defaultSort('viewed_at', 'desc')
            ->paginated([25, 50, 100])
            ->striped()
            ->poll('60s');
    }
}
