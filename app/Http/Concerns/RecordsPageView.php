<?php

declare(strict_types=1);

namespace App\Http\Concerns;

use App\Models\LandingPageContent;
use App\Models\LandingPageViewLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

trait RecordsPageView
{
    /** Минимальный интервал между двумя визитами одного IP на одну страницу (часы). */
    private int $deduplicateHours = 5;

    protected function recordPageView(string $page): void
    {
        try {
            $content = LandingPageContent::query()->first();
            if (! $content) {
                return;
            }

            $ip = request()->ip();

            // Дедупликация: не писать визит, если тот же IP был на той же странице < N часов назад
            if ($this->recentVisitExists($ip, $page)) {
                return;
            }

            DB::table('landing_page_contents')
                ->where('id', $content->id)
                ->update([
                    'landing_page_views_count' => DB::raw('landing_page_views_count + 1'),
                    'landing_page_last_view_at' => now(),
                ]);

            if (! Schema::hasTable('landing_page_view_logs')) {
                return;
            }

            $ua = (string) (request()->userAgent() ?? '');

            $data = [
                'landing_page_content_id' => $content->id,
                'viewed_at'               => now(),
                'ip'                      => $ip,
                'user_agent'              => $ua ?: null,
                'device'                  => LandingPageViewLog::detectDevice($ua),
                'referrer'                => request()->header('referer') ?: null,
                'utm_source'              => request()->query('utm_source') ?: null,
                'utm_medium'              => request()->query('utm_medium') ?: null,
                'utm_campaign'            => request()->query('utm_campaign') ?: null,
                'utm_term'                => request()->query('utm_term') ?: null,
                'utm_content'             => request()->query('utm_content') ?: null,
            ];

            if (Schema::hasColumn('landing_page_view_logs', 'page')) {
                $data['page'] = $page;
            }

            LandingPageViewLog::query()->create($data);
        } catch (Throwable) {
            // Never break page rendering on analytics failure.
        }
    }

    private function recentVisitExists(string $ip, string $page): bool
    {
        if (! Schema::hasTable('landing_page_view_logs')) {
            return false;
        }

        $hasPage = Schema::hasColumn('landing_page_view_logs', 'page');

        $query = LandingPageViewLog::query()
            ->where('ip', $ip)
            ->where('viewed_at', '>=', now()->subHours($this->deduplicateHours));

        if ($hasPage) {
            $query->where('page', $page);
        }

        return $query->exists();
    }
}
