<?php

declare(strict_types=1);

namespace App\Http\Concerns;

use App\Models\LandingPageContent;
use App\Models\LandingPageViewLog;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Throwable;

trait RecordsPageView
{
    private const VIEW_COOKIE       = 'visitor_token';
    private const VIEW_COOKIE_DAYS  = 365;
    private const DEDUP_HOURS       = 24;

    protected function recordPageView(string $page): void
    {
        try {
            $content = LandingPageContent::query()->first();
            if (! $content) {
                return;
            }

            $token = $this->resolveViewerToken();

            if ($this->recentVisitExists($token, $page)) {
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
                'ip'                      => request()->ip(),
                'visitor_token'           => Schema::hasColumn('landing_page_view_logs', 'visitor_token') ? $token : null,
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

            // Remove visitor_token from data if column doesn't exist yet
            if (! Schema::hasColumn('landing_page_view_logs', 'visitor_token')) {
                unset($data['visitor_token']);
            }

            LandingPageViewLog::query()->create($data);
        } catch (Throwable) {
            // Never break page rendering on analytics failure.
        }
    }

    /**
     * Returns existing visitor token from cookie, or generates and queues a new one.
     */
    private function resolveViewerToken(): string
    {
        $token = request()->cookie(self::VIEW_COOKIE);

        if (! $token) {
            $token = Str::uuid()->toString();
            Cookie::queue(
                self::VIEW_COOKIE,
                $token,
                60 * 24 * self::VIEW_COOKIE_DAYS,
                '/',
                null,
                null,
                true
            );
        }

        return $token;
    }

    private function recentVisitExists(string $token, string $page): bool
    {
        if (! Schema::hasTable('landing_page_view_logs')) {
            return false;
        }

        $hasToken = Schema::hasColumn('landing_page_view_logs', 'visitor_token');
        $hasPage  = Schema::hasColumn('landing_page_view_logs', 'page');

        $query = LandingPageViewLog::query()
            ->where('viewed_at', '>=', now()->subHours(self::DEDUP_HOURS));

        if ($hasToken) {
            $query->where('visitor_token', $token);
        } else {
            $query->where('ip', request()->ip());
        }

        if ($hasPage) {
            $query->where('page', $page);
        }

        return $query->exists();
    }
}
