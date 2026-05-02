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
        // Livewire/Filament: временная загрузка файлов идёт на signed URL. Подпись считается по
        // полному базовому URL; без фиксации корня за nginx/Cloudflare генерация и POST могут разъехаться → 401.
        $root = rtrim((string) config('app.url'), '/');
        if ($root !== '') {
            URL::forceRootUrl($root);
        }

        if ($this->app->environment('production') || (bool) config('app.force_https')) {
            URL::forceScheme('https');
        }

        $this->normalizeDriversForSqlite();
    }

    /**
     * SQLite + Docker: сессии в БД (readonly) или в files (права на storage) дают «форма логина просто перезагружается».
     * В production для sqlite — cookie-сессия (в зашифрованной куке), без записи на диск и без таблицы sessions.
     */
    private function normalizeDriversForSqlite(): void
    {
        if (config('database.default') !== 'sqlite') {
            return;
        }

        if (! $this->app->environment('local', 'testing')) {
            config(['session.driver' => 'cookie']);
        } elseif (config('session.driver') === 'database') {
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
