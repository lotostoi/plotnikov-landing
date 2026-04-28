<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production') || (bool) config('app.force_https')) {
            URL::forceScheme('https');
        }

        $this->normalizeDriversForSqlite();
    }

    /**
     * Сессии/кэш в SQLite на Docker с read-only database.sqlite ломают вход в Filament
     * (каждый запрос новая сессия, CSRF/логин «молча»). Переопределяем даже при устаревшем config:cache.
     */
    private function normalizeDriversForSqlite(): void
    {
        if (config('database.default') !== 'sqlite') {
            return;
        }

        if (config('session.driver') === 'database') {
            config(['session.driver' => 'file']);
        }

        if (config('cache.default') === 'database') {
            config(['cache.default' => 'file']);
        }

        if (config('queue.default') === 'database') {
            config(['queue.default' => 'sync']);
        }
    }
}
