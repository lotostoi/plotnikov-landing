<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleLike;
use App\Models\LandingBlock;
use App\Models\LandingPageContent;
use App\Models\LandingPageViewLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Throwable;

class BlogController extends Controller
{
    private const VISITOR_COOKIE = 'visitor_token';
    private const COOKIE_TTL_DAYS = 365;

    public function index(): View
    {
        $faviconUrl = LandingPageContent::query()->first()?->faviconResolvedUrl();

        if (! Schema::hasTable('articles')) {
            $articles = new LengthAwarePaginator([], 0, 9, 1, [
                'path' => request()->url(),
                'query' => request()->query(),
            ]);

            return view('blog.index', compact('articles', 'faviconUrl'));
        }

        $articles = Article::published()
            ->withCount('likes')
            ->latest('published_at')
            ->paginate(9);

        $this->recordView('/blog');

        return view('blog.index', compact('articles', 'faviconUrl'));
    }

    public function show(string $slug): View|Response
    {
        if (! Schema::hasTable('articles')) {
            abort(404);
        }

        $article = Article::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->when($article->category, fn ($q) => $q->where('category', $article->category))
            ->latest('published_at')
            ->limit(3)
            ->get();

        $contacts = LandingPageContent::query()->first();

        $ctaMax = LandingBlock::where('section_code', 'contacts')
            ->where('block_key', 'cta_max')
            ->first();

        $maxUrl  = $ctaMax?->button_url  ?: 'https://max.ru/u/f9LHodD0cOIZh45J-Dg2owlXzPWe-IUg2R7DDGo-yx1QdDAdLYK1SUWEHxM';
        $maxText = $ctaMax?->button_text ?: 'MAX';

        $ctaTelegramChannel = LandingBlock::where('section_code', 'contacts')
            ->where('block_key', 'telegram_channel')
            ->first();

        $channelUrl = $ctaTelegramChannel?->button_url ?: 'https://t.me/plotnikov_aleksander';

        $faviconUrl = $contacts?->faviconResolvedUrl();

        // Visitor token — set if missing
        $token = request()->cookie(self::VISITOR_COOKIE) ?: Str::uuid()->toString();

        // Like stats
        $likesCount = Schema::hasTable('article_likes')
            ? ArticleLike::where('article_id', $article->id)->count()
            : 0;

        $userLiked = Schema::hasTable('article_likes')
            && ArticleLike::where('article_id', $article->id)
                ->where('visitor_token', $token)
                ->exists();

        $this->recordView('/blog/' . $slug);

        $response = response()->view('blog.show', compact(
            'article', 'related', 'contacts', 'maxUrl', 'maxText',
            'channelUrl', 'faviconUrl', 'likesCount', 'userLiked'
        ));

        // Refresh cookie on every visit so it doesn't expire on active readers
        $response->cookie(self::VISITOR_COOKIE, $token, 60 * 24 * self::COOKIE_TTL_DAYS, '/', null, null, true);

        return $response;
    }

    public function like(string $slug): JsonResponse
    {
        if (! Schema::hasTable('articles') || ! Schema::hasTable('article_likes')) {
            return response()->json(['error' => 'not_available'], 503);
        }

        $article = Article::published()->where('slug', $slug)->firstOrFail();

        $token = request()->cookie(self::VISITOR_COOKIE) ?: Str::uuid()->toString();

        $alreadyLiked = ArticleLike::where('article_id', $article->id)
            ->where('visitor_token', $token)
            ->exists();

        if (! $alreadyLiked) {
            ArticleLike::create([
                'article_id'    => $article->id,
                'visitor_token' => $token,
            ]);
        }

        $count = ArticleLike::where('article_id', $article->id)->count();

        return response()
            ->json(['liked' => true, 'count' => $count])
            ->cookie(self::VISITOR_COOKIE, $token, 60 * 24 * self::COOKIE_TTL_DAYS, '/', null, null, true);
    }

    private function recordView(string $page): void
    {
        try {
            $content = LandingPageContent::query()->first();
            if (! $content) {
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
}
